<?php

namespace boisson\views;
use boisson\utils\AppContainer;

class IngredientView
{
  public static function renderList($list){
    $app = AppContainer::getInstance();

    $content = "<h3>Liste des ingrédients</h3><ul>";
    foreach ($list as $ingredient) {
      $url = $app->getRouteCollector()->getRouteParser()->urlFor('ingredient', array('id' => $ingredient->id));
      $content .= "<li><a href='$url'>".$ingredient->name."</li>";
    }
    $content.= "</ul>";
    return (new ViewRendering())->render($content, "Liste des ingrédients");
  }

  public static function render($args){
    $app = AppContainer::getInstance();

    $content = "<h2>".$args['ingredient']->name."</h2>";
    $content .= "<h3>Super Catégories</h3>";
    $content.= "<ul>";

    foreach ($args['sup_categorys'] as $sup) {
      $urlSup = $app->getRouteCollector()->getRouteParser()->urlFor('ingredient', array('id' => $sup->id));
      $content .= "<li><a href='$urlSup'>".$sup->name."</a></li>";
    }
    $content.= "</ul>";
    $content .= "<h3>Sous Catégories</h3>";
    $content.= "<ul>";

    foreach ($args['sub_categorys'] as $sub) {
      $urlSub = $app->getRouteCollector()->getRouteParser()->urlFor('ingredient', array('id' => $sub->id));
      $content .= "<li><a href='$urlSub'>".$sub->name."</li>";
    }
    $content.= "</ul>";
    return (new ViewRendering())->render($content, $args['ingredient']->name);
  }
}
