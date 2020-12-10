<?php


namespace boisson\controllers;


use boisson\models\Recette;
use boisson\views\RecipeView;

class RecipeController
{
    public static function recipe($app, $id) {
        $recipe = Recette::where('id', '=', $id)->first();
        $arg = array(
            'recipe' => $recipe,
            'ingredient' => $recipe->ingredients()->get()
        );
        return RecipeView::render($app, $arg);
    }


    public static function recipeList($app) {
        $recipe = Recette::get();
        return RecipeView::renderList($app, $recipe);
    }
}