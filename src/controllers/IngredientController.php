<?php


namespace boisson\controllers;

use boisson\models\Ingredient;
use boisson\views\IngredientView;

class IngredientController
{

  public static function ingredients() {
      $ingredients = Ingredient::get();
      return IngredientView::renderList($ingredients);
  }
  public static function ingredient($id) {
      $ingredient = Ingredient::where('id', '=', $id)->first();
      $arg = array(
        'ingredient' => $ingredient,
        'sup_categorys' => $ingredient->sup_categorys()->get(),
        'sub_categorys' => $ingredient->sub_categorys()->get()
      );
      return IngredientView::render($arg);
  }
}
