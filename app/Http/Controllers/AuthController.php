<?php

namespace App\Http\Controllers;

use App\Models\AuthCode;
use App\Models\User;
use Bugsnag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Services_Twilio;
use Services_Twilio_RestException;
use Validator;

class AuthController extends Controller
{
    public function postRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'string|max:255|required',
            'phone_number' => 'numeric|size:11|unique:users,phone_number|required'
        ]);
        if ($validator->fails()) {
            abort(400, $validator->errors());
        }

        $user = User::create([
            'username' => $request->input('username'),
            'phone_number' => $request->input('phone_number')
        ]);

        return $user;
    }

    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'numeric|size:11|required'
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
            $client = new Services_Twilio(config('pbnj.twilio_account_sid'), config('pbnj.twilio_auth_token'));
            $client->account->messages->sendMessage(
                config('pbnj.twilio_number'),
                $user->phone_number,
                $message
            );
        } catch (Services_Twilio_RestException $exception) {
            Bugsnag::notifyException($exception);
            abort(400, 'An error occurred while attempting to sign in.');
        }

        return response('', 200);
    }

    public function postCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'string|required',
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
            ['code', $request->input('code')],
            ['valid', true]
        ])->first();

        if (!is_null($code)) {
            $now = Carbon::now();
            if ($now->gte($code->expires)) {
                $code->valid = false;
                $code->save();
                abort(401, 'Unauthorized');
            }
        }
    }
}
