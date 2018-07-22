<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 7/21/18
 * Time: 10:09 PM
 */

namespace App\Services;

use App\Factory\ResultFactory;
use App\Models\RecipeItem;

/**
 * Class RecipeItemService
 * @package App\Services
 */
class RecipeItemService
{
    protected $resultFactory;

    public function __construct(ResultFactory $resultFactory)
    {
        $this->resultFactory = $resultFactory;
    }


    /**
     *
     * Create a new recipe item
     *
     * @param $properties array Values are default of what model expects. Check controller validation for exact.
     * @return object
     */
    public function createRecipeItem($properties)
    {
        try {
            $show = RecipeItem::create($properties);

            return $this->resultFactory->success($show, 'recipe_item');
        } catch (\Exception $e) {
            return $this->resultFactory->error("Unable to create new Recipe Item.");
        }
    }


    /**
     * @param $id
     * @return mixed
     */
    public function getRecipeItem($id)
    {
        $recipe_item = RecipeItem::find($id);

        if (is_null($recipe_item)) {
            return $this->resultFactory->error("Could not find Recipe Item", 'object', 404);
        }

        return $this->resultFactory->success($recipe_item, 'recipe_item');
    }


    /**
     * @return mixed
     */
    public function getAllRecipeItems()
    {
        $recipe_items = RecipeItem::all();

        if (is_null($recipe_items)) {
            return $this->resultFactory->error("Could not find Recipe Items", 'object', 404);
        }

        return $this->resultFactory->success($recipe_items, 'recipe_items');
    }
}
