<?php


namespace boisson\views;

class RecipeView
{
    public static function render($app, $args) {
        $contentArray = array('title' => $args['recipe']->title);

        $ingredients = $args['ingredient'];
        $content = "<h2>" . $contentArray['title'] . "</h2>";

        $url = 'img/' . str_replace(' ', '_', $contentArray['title']) . '.jpg';
        if(file_exists('./' . $url)) $content .= "<img src='/$url' alt='recipe image'>";

        $content .= "<h3>Liste des ingredient</h3><ul>";

        foreach ($ingredients as $ingredient) {
            $name = $ingredient->name;
            $url = $app->getRouteCollector()->getRouteParser()->urlFor('ingredient', array('id' => $ingredient->id));
            $content .= "<li><a href='$url'>$name</a></li>";
        }

        $contentArray['body'] = $content . "</ul>";

        return (new ViewRendering())->render($contentArray);
    }


    public static function renderList($app, $recipes) {
        $contentArray = array('title' => 'List des recette');
        $content = "<h2>" . $contentArray['title'] . "</h2><ul>";

        foreach ($recipes as $recipe) {
            $name = $recipe->title;
            $url = $app->getRouteCollector()->getRouteParser()->urlFor('recipe', array('id' => $recipe->id));
            $content .= "<li><a href='$url'>$name</a></li>";
        }

        $contentArray['body'] = $content . "</ul>";

        return (new ViewRendering())->render($contentArray);
    }
}