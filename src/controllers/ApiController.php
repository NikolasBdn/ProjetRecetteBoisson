<?php


namespace boisson\controllers;


use boisson\models\Ingredient;
use boisson\models\Recette;
use boisson\utils\AppContainer;
use Slim\App;

class ApiController
{

    public static function searchFor(string $elementToSearch)
    {
        $filterElementToSearch = filter_var($elementToSearch, FILTER_UNSAFE_RAW);

        $out = '[';

        $out .= self::getIngredients($filterElementToSearch);
        $out .= self::getRecipes($filterElementToSearch);

        return substr($out, 0, -1) . ']';
    }

    public static function searchForFilteredBy(string $elementToSearch, string $searchFilter)
    {
        $filterElementToSearch = filter_var($elementToSearch, FILTER_UNSAFE_RAW);
        $filterSearchFilter = filter_var($searchFilter, FILTER_UNSAFE_RAW);

        $out = '[';

        switch ($filterSearchFilter)
        {
            case 'ingredient':
                $out .= self::getIngredients($filterElementToSearch);
                break;
            case 'recipe':
                $out .= self::getRecipes($filterElementToSearch);
                break;
            default:
                return '{"error": "undefined search filter"}';
        }

        return substr($out, 0, -1) . ']';
    }

    public static function quickSearch(string $elementToSearch)
    {
        $app = AppContainer::getInstance();
        $filterElementToSearch = filter_var($elementToSearch, FILTER_UNSAFE_RAW);

        $ingredients = Ingredient::select('id', 'name')->where('name', 'like', '%' . $filterElementToSearch . '%')->skip(0)->take(6)->get();
        $recipes = Recette::select('id', 'title')->where('title', 'like', '%' . $filterElementToSearch . '%')->skip(0)->take(6)->get();

        $nbElement = 0;
        $out = '[';

        foreach ($ingredients as $ingredient) {
            $url = $app->getRouteCollector()->getRouteParser()->urlFor('ingredient', array('id' => $ingredient->id));
            $out .= '{"label":"' . $ingredient->name . '","url":"' . $url . '"},';
            $nbElement++;
        }

        foreach ($recipes as $recipe) {
            if ($nbElement >= 6) break;
            $url = $app->getRouteCollector()->getRouteParser()->urlFor('recipe', array('id' => $recipe->id));
            $out .= '{"label":"' . $recipe->title . '","url":"' . $url . '"},';
            $nbElement++;
        }

        return substr($out, 0, -1) . ']';
    }

    private static function getIngredients($like) {
        $out = '';
        $ingredients = Ingredient::select('id', 'name')->where('name', 'like', '%' . $like . '%')->get();
        foreach ($ingredients as $ingredient) $out .= '{"type": "ingredient","id":' . $ingredient->id . ',"name":"' . $ingredient->name . '"},';
        return $out;
    }

    private static function getRecipes($like) {
        $out = '';
        $recipes = Recette::select('id', 'title')->where('title', 'like', '%' . $like . '%')->get();
        foreach ($recipes as $recipe) $out .= '{"type": "recipe","id":' . $recipe->id . ',"name":"' . $recipe->title . '"},';
        return $out;
    }

}