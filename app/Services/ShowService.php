<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 7/21/18
 * Time: 7:17 PM
 */

namespace App\Services;


use App\Factory\ResultFactory;

class ShowService
{
    protected $resultFactory;

    public function __construct(ResultFactory $resultFactory) {
        $this->resultFactory = $resultFactory;
    }

    public function createShow($properties) {

    }
}