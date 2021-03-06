<?php

namespace boisson\views;

use boisson\utils\AppContainer;

class CartView
{
    public static function render($args)
    {
        $app = AppContainer::getInstance();

        $content = "<div id='lists'><h1>Mon panier</h1>";
        $content .= "<table>";
        foreach ($args as $recipe) {
            $js = "showRecipe(" . $recipe->id . ")";
            $content .= "<tr onclick=$js><th>" . $recipe->title . "</th></tr>";
            //$content.="<tr><th>".$recipe->title."</th></tr>";
        }
        $content .= "</table></div>";
        return (new ViewRendering())->render($content, "Panier");
    }
}
