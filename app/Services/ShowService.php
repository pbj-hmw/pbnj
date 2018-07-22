<?php

namespace App\Services;

use App\Factory\ResultFactory;
use App\Models\Show;
use App\Services\TwilioService;
use Bugsnag;

/**
 * Class ShowService
 * @package App\Services
 */
class ShowService
{
    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var TwilioService
     */
    protected $twilioService;

    /**
     * ShowService constructor.
     *
     * @param ResultFactory $resultFactory
     * @param TwilioService $twilioService
     */
    public function __construct(ResultFactory $resultFactory, TwilioService $twilioService)
    {
        $this->resultFactory = $resultFactory;
        $this->twilioService = $twilioService;
    }

    /**
     *
     * Create a new Show
     *
     * @param $properties array Values are default of what model expects. Check controller validation for exact.
     * @return object
     */
    public function createShow($properties)
    {
        try {
            $show = Show::create($properties);

            $chat_created = $this->twilioService->createChannel($show->title);
            if (!$chat_created->success) {
                return $chat_created;
            }
            $show->chat_sid = $chat_created->channel->sid;
            $show->save();

            return $this->resultFactory->success($show, 'show');
        } catch (\Exception $exception) {
            Bugsnag::notifyException($exception);
            return $this->resultFactory->error("Unable to create new show.");
        }
    }
}
