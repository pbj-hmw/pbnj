<?php

namespace App\Http\Controllers;

use App\Models\User;
use Bugsnag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use Webpatser\Uuid\Uuid;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class ShowController extends Controller
{
    /**
     * Creates a new show, this will also create the associated chat and other details to go with the show.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function postShow(Request $request)
    {

    }
}
