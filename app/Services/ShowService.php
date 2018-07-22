<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 7/21/18
 * Time: 7:17 PM
 */

namespace App\Services;

use Carbon\Carbon;

use App\Factory\ResultFactory;

use App\Models\Show;

class ShowService
{
    protected $resultFactory;

    public function __construct(ResultFactory $resultFactory) {
        $this->resultFactory = $resultFactory;
    }


    /**
     *
     * Create a new Show
     *
     * @param $properties array Values are default of what model expects. Check controller validation for exact.
     * @return object
     */
    public function createShow($properties) {
        try {
            $show = Show::create($properties);

            return $this->resultFactory->success($show, 'show');
        } catch (\Exception $e) {
            return $this->resultFactory->error("Unable to create new Show");
        }

        //TODO: Create Twilio chat to associate to a chat.
    }

    public function getShow($id) {
        $show = Show::with('recipeItems', 'steps')->find($id);

        if (is_null($show)) {
            return $this->resultFactory->error("Could not find Show",'object', 404);
        }

        return $this->resultFactory->success($show, 'show');
    }


    public function getNextShow() {
        $one_hour_ago = Carbon::now()->subHours(1);
        $twenty_four_hours = Carbon::now()->addHours(24);

        $show = Show::with('recipeItems', 'steps')
            ->where('start_time', '>', $one_hour_ago->toDateTimeString())
            ->where('start_time','<', $twenty_four_hours->toDateTimeString())
            ->where('finished', false)
            ->orderBy('created_at', 'ASC')
            ->first();

        if (is_null($show)) {
            return $this->resultFactory->error("Could not find Show",'object', 404);
        }

        return $this->resultFactory->success($show, 'show');
    }
}
