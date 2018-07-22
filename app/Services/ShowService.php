<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 7/21/18
 * Time: 7:17 PM
 */

namespace App\Services;


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
    }
}