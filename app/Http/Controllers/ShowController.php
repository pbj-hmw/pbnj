<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ShowService;
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
    protected $showService;

    public function __construct(ShowService $showService)
    {
        $this->showService = $showService;
    }


    /**
     * Creates a new show, this will also create the associated chat and other details to go with the show.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function postShow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => 'required|date',
            'title' => 'required|string',
            'description' => 'required|string',
            'runtime' => 'required|string',
            'show_image_header' => 'required|string',
            'calories' => 'required|string'
        ]);

        if ($validator->fails()) {
            abort(400, $validator->errors());
        }

        $properties = $request->all();

        $result = $this->showService->createShow($properties);

        if (!$result->success) {
            abort(400, $result->error);
        }

        $show = $result->show;

        return $show;
    }
}
