<?php


namespace boisson\views;


class RecipeView
{
    public static function render($app, $args) {
        $contentArray = array('title' => $args['recipe']->title);

        $ingredients = $args['ingredient'];
        $content = "<h2>" . $contentArray['title'] . "</h2>";
        $content .= "<h3>Liste des ingredient</h3><ul>";

        foreach ($ingredients as $ingredient) {
            $name = $ingredient->name;
            $url = $app->getRouteCollector()->getRouteParser()->urlFor('ingredient', array('id' => $ingredient->id));
            $content .= "<li><a href='$url'>$name</a></li>";
        }

        $contentArray['body'] = $content . "</ul>";

        return (new ViewRendering())->render($contentArray);
    }
}