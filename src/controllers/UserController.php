<?php


namespace boisson\controllers;


use boisson\models\User;
use boisson\utils\AppContainer;
use boisson\views\UserView;

class UserController
{
    public static function logout()
    {
        session_destroy();
        $url = AppContainer::getInstance()->getRouteCollector()->getRouteParser()->urlFor('root');
        header("Location: $url");
        exit();
    }

    public static function registerPost()
    {
        if (isset($_POST['submit'])) if ($_POST['submit'] == 'doRegister') {

            $user_data = array();

            // check du nom d'utilisateur
            if (isset($_POST['username'])) {
                $val = filter_var($_POST['username'], FILTER_DEFAULT);
                if ($val != FALSE) {
                    $user_data['username'] = $val;
                } else {
                    return UserView::errorPost();
                }
            } else {
                return UserView::errorPost();
            }

            // check du mot de passe
            if (isset($_POST['password'])) {

                $val = filter_var($_POST['password'], FILTER_DEFAULT);
                if ($val != FALSE) {
                    $user_data['password'] = $val;
                } else {
                    return UserView::errorPost();
                }
            } else {
                return UserView::errorPost();
            }

            // check du mot de passe de verification
            if (isset($_POST['password-confirm'])) {

                $val = filter_var($_POST['password-confirm'], FILTER_DEFAULT);
                if ($val != FALSE) {
                    $user_data['password-confirm'] = $val;
                } else {
                    return UserView::errorPost();
                }
            } else {
                return UserView::errorPost();
            }

            // Check si les mot de passe sont identique
            if ($user_data['password'] != $user_data['password-confirm']) {
                return UserView::errorPost();
            }

            if (self::checkIfUsernameExsite($user_data['username'])) {
                $user = new User();
                $user->username = $user_data['username'];
                $user->password = password_hash($user_data['password'], PASSWORD_DEFAULT);
                $user->save();
                self::createSession($user_data['username']);
            } else {

                return UserView::userExsitePost();
            }

            $url = AppContainer::getInstance()->getRouteCollector()->getRouteParser()->urlFor('root');
            header("Location: $url");
            exit();
        }
        return UserView::errorPost();
    }


    public static function loginPost()
    {
        if (isset($_POST['submit'])) if ($_POST['submit'] == 'doLogin') {
            $user_data = array();
            // check du nom d'utilisateur
            if (isset($_POST['username'])) {
                $val = filter_var($_POST['username'], FILTER_DEFAULT);
                if ($val != FALSE) {
                    $user_data['username'] = $val;
                } else {
                    return UserView::errorPost();
                }
            } else {
                return UserView::errorPost();
            }
            // check du mot de passe
            if (isset($_POST['password'])) {
                $val = filter_var($_POST['password'], FILTER_DEFAULT);
                if ($val != FALSE) {
                    $user_data['password'] = $val;
                } else {
                    return UserView::errorPost();
                }
            } else {
                return UserView::errorPost();
            }
            if (!self::checkIfUsernameExsite($user_data['username'])) {
                if (password_verify($user_data['password'], User::select('password')->where('username', '=', $user_data['username'])->first()->password)) {
                    self::createSession($user_data['username']);
                    $url = AppContainer::getInstance()->getRouteCollector()->getRouteParser()->urlFor('root');
                    header("Location: $url");
                    exit();
                } else {
                    return UserView::errorPost();
                }
            } else {
                return UserView::errorPost();
            }
        }
        return UserView::errorPost();
    }

    private static function createSession($username)
    {
        $_SESSION['username'] = $username;
    }

    private static function checkIfUsernameExsite($username)
    {
        $value = User::where('username', '=', $username)->get();
        if (isset($value)) {
            return count($value) == 0;
        } else {
            return true;
        }
    }
}