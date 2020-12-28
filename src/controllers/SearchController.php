<?php


namespace boisson\controllers;


use boisson\utils\AppContainer;
use boisson\views\SearchView;

class SearchController
{
    public static function search(string $elementToSearch)
    {
        $data = json_decode(file_get_contents('http://' . $_SERVER['HTTP_HOST'] . AppContainer::getInstance()->getRouteCollector()->getRouteParser()->urlFor('api_search', array('string' => $elementToSearch))));
        $data['search'] = $elementToSearch;
        return SearchView::render($data);
    }
}