<?php

namespace boisson\views;

use boisson\utils\AppContainer;

class IngredientView
{
    public static function renderList($list)
    {
        $content = "<div id='lists'><h1>Liste des ingrédients</h1><table>";
        foreach ($list as $ingredient) {
            $js = "showIngredient(" . $ingredient->id . ")";
            $content .= "<tr onclick=$js><th>" . $ingredient->name . "</th></tr>";
        }
        $content .= "</table></div>";
        return (new ViewRendering())->render($content, "Liste des ingrédients");
    }

    public static function render($args)
    {
        $app = AppContainer::getInstance();

        $content = "<h2>" . $args['ingredient']->name . "</h2>";
        $content .= "<h3>Super Catégories</h3>";
        $content .= "<ul>";

        foreach ($args['sup_categorys'] as $sup) {
            $urlSup = $app->getRouteCollector()->getRouteParser()->urlFor('ingredient', array('id' => $sup->id));
            $content .= "<li><a href='$urlSup'>" . $sup->name . "</a></li>";
        }
        $content .= "</ul>";
        $content .= "<h3>Sous Catégories</h3>";
        $content .= "<ul>";

        foreach ($args['sub_categorys'] as $sub) {
            $urlSub = $app->getRouteCollector()->getRouteParser()->urlFor('ingredient', array('id' => $sub->id));
            $content .= "<li><a href='$urlSub'>" . $sub->name . "</li>";
        }
        $content .= "</ul>";
        return (new ViewRendering())->render($content, $args['ingredient']->name);
    }
}
