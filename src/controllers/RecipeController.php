<?php


namespace boisson\controllers;


use boisson\models\Recette;
use boisson\views\RecipeView;

/**
 * Class RecipeController
 * @package boisson\controllers
 */
class RecipeController
{
    /**
     * Get the page of a recipe
     * @param $id string id of the recipe
     * @return mixed The page who get send to the client
     */
    public static function recipe($id)
    {
        $recipe = Recette::where('id', '=', $id)->first();
        $arg = array(
            'recipe' => $recipe,
            'ingredient' => $recipe->ingredients()->get()
        );
        return RecipeView::render($arg);
    }

    /**
     * Get a list with all recipes
     * @return mixed The page who get send to the client
     */
    public static function recipeList()
    {
        $recipe = Recette::get();
        return RecipeView::renderList($recipe);
    }
}