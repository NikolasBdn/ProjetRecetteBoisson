<?php


namespace boisson\controllers;


use boisson\models\Recette;

class RecipeController
{
    public static function recipe($id, $app) {
        $ingredients = Recette::where('id', '=', $id)->first()->ingredients()->get();
        foreach ($ingredients as $ingredient) {
            echo $ingredient->name . "\n";
        }

        return "";
    }
}