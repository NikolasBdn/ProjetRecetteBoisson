<?php


namespace boisson\controllers;

use boisson\models\Recette;
use boisson\models\User;
use boisson\utils\AppContainer;
use boisson\utils\Authentication;
use boisson\views\CartView;

class CartController
{
    public static function cart()
    {
        $out = array();
        if (Authentication::isLogging()) {
            $cart = User::where('username', '=', Authentication::getUserName())->first()->basket()->get();
            foreach ($cart as $recette) {
                array_push($out, $recette);
            }
        } else {
            if (isset($_COOKIE['cart'])) {
                $cart = json_decode($_COOKIE['cart']);
                foreach ($cart as $id) {
                    $recette = Recette::where('id', '=', $id)->first();
                    array_push($out, $recette);
                }
            }
        }
        return CartView::render($out);
    }

    public static function add($id)
    {
        if (Authentication::isLogging()) {
            $cart = User::where('username', '=', Authentication::getUserName())->first()->basket();
            $recette = Recette::where('id', '=', $id)->first();
            if (isset($recette)) {
                $cart->attach($recette);
            }
        } else {
            if (isset($_COOKIE['cart'])) {
                if (!in_array($id, json_decode($_COOKIE['cart']))) {
                    $cart = json_decode($_COOKIE['cart']);
                    array_push($cart, $id);
                    setcookie('cart', json_encode($cart), time() + 3600 * 24 * 365, '/', $_SERVER['HTTP_HOST']);
                }
            } else {
                $cart = array();
                array_push($cart, $id);
                setcookie('cart', json_encode($cart), time() + 3600 * 24 * 365, '/', $_SERVER['HTTP_HOST']);
            }
        }
        self::returnToCart();
    }

    public static function delete($id)
    {
        if (Authentication::isLogging()) {
            $cart = User::where('username', '=', Authentication::getUserName())->first()->basket();
            $recette = Recette::where('id', '=', $id)->first();
            if (isset($recette)) {
                $cart->detach($recette);
            }
        } else {
            if (isset($_COOKIE['cart']) && in_array($id, json_decode($_COOKIE['cart']))) {
                $cart = json_decode($_COOKIE['cart']);
                $index = array_search($id, $cart);
                array_splice($cart, $index, ++$index);
                setcookie('cart', json_encode($cart), time() + 3600 * 24 * 365, '/', $_SERVER['HTTP_HOST']);
            }
        }
        self::returnToCart();
    }

    public static function isInCart($id)
    {
        if (Authentication::isLogging()) {
            $recettes = User::where('username', '=', Authentication::getUserName())->first()->basket()->get();
            foreach ($recettes as $recette) {
                if ($recette->id == $id) return true;
            }
            return false;
        }
        return isset($_COOKIE['cart']) && in_array($id, json_decode($_COOKIE['cart']));
    }

    private static function returnToCart()
    {
        $url = AppContainer::getInstance()->getRouteCollector()->getRouteParser()->urlFor('cart');
        header("Location: $url");
        exit();
    }

}
