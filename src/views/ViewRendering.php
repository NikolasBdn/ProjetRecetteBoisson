<?php


namespace boisson\views;


use boisson\utils\AppContainer;

/**
 * Class ViewRendering
 * @package boisson\views
 */
class ViewRendering
{

    private static function createNavBar()
    {
        $app = AppContainer::getInstance();
        $ingredient_list = $app->getRouteCollector()->getRouteParser()->urlFor('ingredient_list');
        $recipe_list = $app->getRouteCollector()->getRouteParser()->urlFor('recipe_list');
        $cart = $app->getRouteCollector()->getRouteParser()->urlFor('cart');
        $search = $app->getRouteCollector()->getRouteParser()->urlFor('search');
        return <<<html
<li><form id="search-form" autocomplete="off" method="post" action="$search">
    <input id="search-input" autocomplete="off" type="text" name="search_bar">
    <button id="search-button" type="submit" name="submit" value="doSearch">🔍</button>
</form></li>
<li><a href=$ingredient_list>Listes ingredient</a></li>
<li><a href=$recipe_list>Listes recette</a></li>
<li><a href="$cart">Pannier</a></li>
<li><a href="#">S'inscrire/Se Connecter</a></li>
html;
    }

        /**
     * @param $content mixed Containing the body and the title
     * @return string The page who get send to the client
     */
    private static function render1($content)
    {
        return self::render2($content['body'], $content['title']);
    }


    /**
     * @param $body mixed The body of the page
     * @param $title mixed The title of the page
     * @return string The page who get send to the client
     */
    private static function render2($body, $title)
    {
        $template = file_get_contents('./html/template.html');
        $app = AppContainer::getInstance();

        if (!$title == "") {
            $template = str_replace_first('${title}', " - $title", $template);
        } else {
            $template = str_replace_first('${title}', "", $template);
        }
        $template = str_replace_first('${body}', $body, $template);

        $count = 8;
        $template = str_replace('${home_link}', $app->getRouteCollector()->getRouteParser()->urlFor('root'), $template, $count);

        $template = str_replace_first('${api_link}', $app->getRouteCollector()->getRouteParser()->urlFor('root'), $template);

        $template = str_replace_first('${top_nav}', self::createNavBar(), $template);

        return $template;
    }

    /**
     * @param $name string name of the function
     * @param $arguments array argument of the function
     * @return mixed Return the corresponding function `render1` or  `render2`
     */
    public function __call(string $name, array $arguments)
    {
        if ($name == 'render') {
            if (count($arguments) == 1) {
                return call_user_func_array(array($this, 'render1'), $arguments);
            } else if (count($arguments) == 2) {
                return call_user_func_array(array($this, 'render2'), $arguments);
            }
        }
        return null;
    }
}
