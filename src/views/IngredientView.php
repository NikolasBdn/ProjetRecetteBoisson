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

        $content = "<div id='items'><h1>" . $args['ingredient']->name . "</h1>";
        $content .= "<h3>Super Catégories</h3><p>";

        foreach ($args['sup_categorys'] as $sup) {
            $urlSup = $app->getRouteCollector()->getRouteParser()->urlFor('ingredient', array('id' => $sup->id));
            $content .= "<a class='list_item' href='$urlSup'>" . $sup->name . "</a>";
        }
        $content .= "</p><h3>Sous Catégories</h3><p>";

        foreach ($args['sub_categorys'] as $sub) {
            $urlSub = $app->getRouteCollector()->getRouteParser()->urlFor('ingredient', array('id' => $sub->id));
            $content .= "<a class='list_item' href='$urlSub'>" . $sub->name . "</a>";
        }
        $content .= "</p></div>";
        return (new ViewRendering())->render($content, $args['ingredient']->name);
    }
}
