<?php


namespace boisson\controllers;


use boisson\models\Recette;
use boisson\views\RecipeView;
use Slim\App;

/**
 * Class RecipeController
 * @package boisson\controllers
 */
class RecipeController
{
    /**
     * Get the page of a recipe
     * @param $app App slim instance
     * @param $id string id of the recipe
     * @return mixed The page who get send to the client
     */
    public static function recipe($app, $id) {
        $recipe = Recette::where('id', '=', $id)->first();
        $arg = array(
            'recipe' => $recipe,
            'ingredient' => $recipe->ingredients()->get()
        );
        return RecipeView::render($app, $arg);
    }

    /**
     * Get a list with all recipes
     * @param $app App slim instance
     * @return mixed The page who get send to the client
     */
    public static function recipeList($app) {
        $recipe = Recette::get();
        return RecipeView::renderList($app, $recipe);
    }
}