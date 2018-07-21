<?php

namespace App\Http\Controllers;

use App\Models\AuthCode;
use App\Models\User;
use Bugsnag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;
use Validator;
use Webpatser\Uuid\Uuid;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * Creates a new user with a username and a 11 digit phone number.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function postRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'string|max:255|unique:users,username|required',
            'phone_number' => ['numeric', 'regex:/^[0][1-9]\d{10}$|^[1-9]\d{10}$/', 'unique:users,phone_number', 'required']
        ]);
        if ($validator->fails()) {
            abort(400, $validator->errors());
        }

        try {
            $user = User::create([
                'username' => $request->input('username'),
                'phone_number' => $request->input('phone_number'),
                'access_token' => Uuid::generate(4)->string
            ]);

            return $user;
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            abort(400, 'An error occurred while attempting to register.');
        }
    }

    /**
     * Sends a 6 digit code to the phone number.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => ['numeric', 'regex:/^[0][1-9]\d{10}$|^[1-9]\d{10}$/', 'required']
        ]);
        if ($validator->fails()) {
            abort(400, $validator->errors());
        }

        $user = User::where('phone_number', $request->input('phone_number'))->first();
        if (is_null($user)) {
            abort(401, 'Unauthorized');
        }

        $existing_codes = AuthCode::where('user_id', $user->id)->get();
        foreach ($existing_codes as $existing_code) {
            $existing_code->valid = false;
            $existing_code->save();
        }

        $code = AuthCode::create([
            'user_id' => $user->id,
            'code' => strval(mt_rand(100000, 999999)),
            'expires' => Carbon::now()->addMinutes(5),
            'valid' => true
        ]);

        $message = $code->code . " is your one-time code for PBNJ (valid for 5 min).";

        try {
            $client = new Client(config('pbnj.twilio_account_sid'), config('pbnj.twilio_auth_token'));
            $client->messages->create(
                '+'.$user->phone_number,
                array(
                    'from' => config('pbnj.twilio_number'),
                    'body' => $message
                )
            );
        } catch (TwilioException $exception) {
            Bugsnag::notifyException($exception);
            abort(400, 'An error occurred while attempting to sign in.');
        }

        return response('', 200);
    }

    /**
     * Exchanges a 6 digit code for a new access token.
     *
     * @param Request $request
     *
     * @return User
     */
    public function postCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => ['numeric', 'regex:/^[0][1-9]\d{10}$|^[1-9]\d{10}$/', 'required'],
            'code' => 'string|required'
        ]);
        if ($validator->fails()) {
            abort(400, $validator->errors());
        }

        $user = User::where('phone_number', $request->input('phone_number'))->first();
        if (is_null($user)) {
            abort(401, 'Unauthorized');
        }

        $code = AuthCode::where([
            ['user_id', $user->id],
            ['code', $request->input('code')]
        ])->first();
        if (is_null($code) || !$code->valid) {
            abort(401, 'Unauthorized');
        }

        $now = Carbon::now();
        if ($now->gte($code->expires)) {
            $code->valid = false;
            $code->save();
            abort(401, 'Unauthorized');
        }

        $code->valid = false;
        $code->save();

        try {
            $user->access_token = Uuid::generate(4)->string;
            $user->save();
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            abort(400, 'An error occurred while generating a new access token');
        }

        return $user;
    }

    /**
     * Updates a users phone number.
     *
     * @param Request $request
     *
     * @return User
     */
    public function putPhoneNumber(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => ['numeric', 'regex:/^[0][1-9]\d{10}$|^[1-9]\d{10}$/', 'unique:users,phone_number', 'required']
        ]);
        if ($validator->fails()) {
            abort(400, $validator->errors());
        }

        $user = User::find($request->input('user_id'));
        $user->phone_number = $request->input('phone_number');
        $user->save();

        return $user;
    }
}
