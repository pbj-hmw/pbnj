<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 7/21/18
 * Time: 11:08 PM
 */


namespace App\Http\Controllers;

use App\Models\RecipeItem;
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


    public function postRecipeItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'image_link' => 'required|string',
            'importance' => 'required'
        ]);

        if ($validator->fails()) {
            abort(400, $validator->errors());
        }

        $properties = $request->all();

        $result = $this->recipeItemService->createRecipeItem($properties);

        if (!$result->success) {
            abort(400, $result->error);
        }

        $recipe_item = $result->recipe_item;

        return $recipe_item;
    }

    public function getRecipeItems()
    {
        $items = RecipeItem::orderBy('importance', 'DESC')->get();

        return $items;
    }
}
