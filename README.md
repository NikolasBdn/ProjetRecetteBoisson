# ProjetRecetteBoisson

## C'est quoi ?

ProjetRecetteBoisson est un projet universitaire composé de :
+ **Pierre Marcolet** *(AlasDiablo)*
+ **Nicolas Baudon** *(NikolasBdn)*

## Comment l'installer

1) Clonez le depôt git dans un serveur apache avec `PHP-7.2.0` ou supérieur.

2) Après ceci faire la commande `composer install`, si vous ne l'avez pas, référez vous à [getcomposer.org](https://getcomposer.org/).

3) Pour la création de la base de données, récupérez le fichier SQL situé dans le dossier 'sql' et éxécutez-le sur votre serveur MySQL/MariaDB

4) Pour finir l'installation, créez un fichier `conf.ini` dans `src/conf/` et insérez les données suivantes:
    ```ini
    driver=VosDrivers
    username=VotreUsername
    password=VotreMotdepasse
    host=VotreIp
    database=VotreBaseDeDonnées
    ```

## Lien d'utilisation

+ [Hydris](#)
+ Statut du Deploiement:
    + [ ] Site web
    + [ ] Base de données


## Tâches à faire/en cours

+ [ ] 1 - Texte