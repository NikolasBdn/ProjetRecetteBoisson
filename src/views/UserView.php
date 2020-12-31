<?php


namespace boisson\views;


use boisson\utils\AppContainer;

class UserView
{

    public static function errorPost()
    {
        return (new ViewRendering())->render("<h3 class=\"post-code\">Une erreur lors de la récupération des données saisies</h3>", "Error");
    }

    public static function userExsitePost()
    {
        return (new ViewRendering())->render("<h3 class=\"post-code\">L'utilisateur est déjà enregistré</h3>", "Error");
    }

    public static function accountRegisterAndLogin()
    {
        $app = AppContainer::getInstance();
        $register = $app->getRouteCollector()->getRouteParser()->urlFor('register');
        $login = $app->getRouteCollector()->getRouteParser()->urlFor('login');
        return (new ViewRendering())->render(<<<BODY
<div id="user-form">
    <div id="register-div" class="user-form">
        <h2>Creation d'un compte</h2>
        <form method="post" action=$register>
            <label>Nom d'utilisateur :</label><br>
            <input type="text" name="username" required><br>
            <label>Mot de passe :</label><br>
            <input type="password" name="password" required><br>
            <label>Confirmer le mot de passe :</label><br>
            <input type="password" name="password-confirm" required><br>
            <button type="submit" name="submit" value="doRegister">Créer mon compte</button>
        </form>
    </div>
    
    <div id="login-div" class="user-form">
        <h2>Connection a un compte</h2>
        <form id="register" method="post" action=$login>
            <label>Nom d'utilisateur :</label><br>
            <input type="text" name="username" required><br>
            <label>Mot de passe :</label><br>
            <input type="password" name="password" required><br><br>
            <button type="submit" name="submit" value="doLogin">Se connecter</button>
        </form>
    </div>
</div>
BODY
            , "Connection");
    }
}