<?php

namespace App\Services;

use App\Factory\ResultFactory;
use App\Models\AuthCode;
use Carbon\Carbon;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

/**
 * Class TwilioService
 * @package App\Services
 */
class TwilioService
{
    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * ShowService constructor.
     *
     * @param ResultFactory $resultFactory
     */
    public function __construct(ResultFactory $resultFactory)
    {
        $this->resultFactory = $resultFactory;
    }

    /**
     * Creates and sends an sms login code to a user.
     *
     * @param User $user User to send the code to.
     *
     * @return object    ResultFactory
     */
    public function sendLoginCode($user)
    {
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
            return $this->resultFactory->error('An error occurred while attempting to sign in.');
        }
        return $this->resultFactory->success('Success');
    }

    /**
     * Creates a live stream chat room.
     *
     * @param string $name Name of the live stream.
     *
     * @return object      ResultFactory
     */
    public function createChannel($name)
    {
        try {
            $client = new Client(config('pbnj.twilio_account_sid'), config('pbnj.twilio_auth_token'));
            $channel = $client->chat->v2->services(config('pbnj.twilio_service_sid'))
                ->channels
                ->create(array("friendlyName" => $name));
            return $this->resultFactory->success($channel, 'channel');
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            return $this->resultFactory->error('Unable to create the chat room.');
        }
    }

    /**
     * Deletes a live stream chat.
     *
     * @param string $id ID of the channel to delete.
     *
     * @return object    ResultFactory
     */
    public function deleteChannel($id)
    {
        try {
            $client = new Client(config('pbnj.twilio_account_sid'), config('pbnj.twilio_auth_token'));
            $client->chat->v2->services(config('pbnj.twilio_service_sid'))
                ->channels($id)
                ->delete();
            return $this->resultFactory->success('Success', '', 204);
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            return $this->resultFactory->error('Unable to delete the chat room.');
        }
    }
}
