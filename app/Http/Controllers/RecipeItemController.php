<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 7/21/18
 * Time: 11:08 PM
 */


namespace App\Http\Controllers;

use App\Models\User;
use App\Services\RecipeItemService;
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
class RecipeItemController extends Controller
{
    protected $showService;
    protected $recipeItemService;

    public function __construct(ShowService $showService, RecipeItemService $recipeItemService)
    {
        $this->showService = $showService;
        $this->recipeItemService = $recipeItemService;
    }

}