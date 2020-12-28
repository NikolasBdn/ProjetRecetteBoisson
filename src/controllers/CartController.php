<?php


namespace boisson\controllers;

// use boisson\models\Cart;
use boisson\models\Recette;
use boisson\views\CartView;
use boisson\utils\AppContainer;

class CartController
{
  public static function cart() {
      $arg = array();

      if (isset($_COOKIE['cart'])) {
        $cart = json_decode($_COOKIE['cart']);
        foreach ($cart as $id) {
            $recette = Recette::where('id', '=', $id)->first();
            array_push($arg, $recette);
        }
      }
      return CartView::render($arg);
  }

  public static function add($id) {
      if (isset($_COOKIE['cart'])) {
          if (!in_array($id, json_decode($_COOKIE['cart']))) {
              echo "put in cart";
              $cart = json_decode($_COOKIE['cart']);
              array_push($cart, $id);
              setcookie('cart',  json_encode($cart), time()+3600*24*365, '/',  $_SERVER['HTTP_HOST']);
          }
      }else {
          $cart = array();
          array_push($cart, $id);
          setcookie('cart',  json_encode($cart), time()+3600*24*365, '/',  $_SERVER['HTTP_HOST']);
      }

      printf($_COOKIE['cart']);
      echo $_SERVER['HTTP_HOST']."/recipe/".$id;
      // header("Location: http://".$_SERVER['HTTP_HOST']."/recipe/".$id);
      // exit();

      return "";
  }

  public static function delete($id) {
      if (isset($_COOKIE['cart']) && in_array($id, json_decode($_COOKIE['cart']))) {
          $cart = json_decode($_COOKIE['cart']);
          $cart = array_diff($cart, array($id));
          setcookie('cart',  json_encode($cart), time()+3600*24*365, '/',  $_SERVER['HTTP_HOST']);
    }
    printf($_COOKIE['cart']);

    header("Location: http://".$_SERVER['HTTP_HOST']."/recipe/".$id);
    exit();

    return "";
  }
}
