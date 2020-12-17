<?php


namespace boisson\views;

use boisson\utils\AppContainer;
use Illuminate\Database\Eloquent\Model;

class RecipeView
{
    /**
     * Build the page of a recipe
     * @param $args array List of element needed to build the page
     * @return mixed The page who get send to the client
     */
    public static function render($args) {
        $contentArray = array('title' => $args['recipe']->title);
        $app = AppContainer::getInstance();

        $ingredients = $args['ingredient'];
        $content = "<div id='items'><h1>" . $contentArray['title'] . "</h1>";

        $url = 'img/' . str_replace(' ', '_', $contentArray['title']) . '.jpg';
        if(file_exists('./' . $url)) $content .= "<img class='img' src='/$url' alt='recipe image'>";

        $content .= "<h4>Preparation :</h4><p>" . $args['recipe']->preparation . "</p>";
        $content .= "<h4>Ingredient :</h4><p>" . $args['recipe']->ingredients_text . "</p>";
        $content .= "<h3>Liste des ingredient</h3><p>";

        foreach ($ingredients as $ingredient) {
            $name = $ingredient->name;
            $url = $app->getRouteCollector()->getRouteParser()->urlFor('ingredient', array('id' => $ingredient->id));
            $content .= "<a class='list_item' href='$url'>$name</a>";
        }

        $contentArray['body'] = $content . "</p></div>";

        return (new ViewRendering())->render($contentArray);
    }

    /**
     * Build the page list with all recipes
     * @param $recipes Model List of element needed to build the page
     * @return mixed The page who get send to the client
     */
    public static function renderList($recipes) {
        $contentArray = array('title' => 'List des recette');
        $content = "<div id='lists'><h1>" . $contentArray['title'] . "</h1>";
        $content .= "<table>";
        foreach ($recipes as $recipe) {
            $name = $recipe->title;
            $js = "showRecipe(".$recipe->id.")";
            $content .= "<tr onclick=$js><th>$name</th></tr>";
        }
        $contentArray['body'] = $content . "</table></div>";
        return (new ViewRendering())->render($contentArray);
    }
}