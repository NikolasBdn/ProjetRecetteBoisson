<?php


namespace boisson\utils;


use boisson\models\User;

class Authentication
{
    public static function isLogging()
    {
        return isset($_SESSION['username']);
    }

    public static function getUserName()
    {
        return self::isLogging() ? $_SESSION['username'] : '';
    }
}