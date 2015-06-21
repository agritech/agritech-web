[![Build Status](https://travis-ci.org/agritech/agritech-web.svg)](https://travis-ci.org/agritech/agritech-web)
-

# AGRITECH
Bienvenu sur le site du projet AGRITECH

## Personnes concernées
AGRITECH est une initiative qui a pour but de mettre en relation :

* Les agriculteurs (cultivateurs, éleveurs, pisciculteurs, ...)
* Les acheteur qui souhaitent connaître les prix moyens des productions ;
* Les partenaires interessés d'avoir des données consolidées sur la production d'une région données sous forme de rapport consolidé et détaillé ;
* Les professionnels de l'agriculture ;
* Et les pouvoir publics et ONG qui travaillent dans l'agriculture.

## Objectifs de la plateforme AGRITECH
Aujourd'hui, la plateforme permet de :
* Avoir un écho système pour les agriculteur leur permettant d'avoir des informations sur les différents produits exploités dans leur région.
* Avoir des données consolidées aidant à la pris de décision rapide ;
* Aider les agriculteurs à réguler leur production en fonction du climat et du marché
* Cartographier les zones agricoles exploitables avec les caractéristiques liées a la zone et proposer des types de culture propice a la zone ;
* Permettre aux éleveurs et agriculteurs de connaitre les points d'eau et mettre en place un système de réservation pour faciliter l’accès a la ressource ;
* Mettre en place un système d'alerte pour faciliter la communucation des professionnels avec les agriculteurs.

## Architecture
L'architecture de l'application est composée de :
* Application SMS pour les fonctionnalités agriculteurs ;

## Développement
* Changer les paramètres de la base de données dans le fichier `/app/config/database.php`
* effectuer une migration artisan dans le but de créer la base de données
```
php artisan migrate:refresh --seed
```
* Vérifier l'URL de l'application dans le repertoire `/app/config/app.php`
* Vérifier les paramètres de l'application dans `/app/config/agritech.php`
* Mettre à jour le repertoire vendor contenant les dépendances composer
```
composer update
```
* Faire pointer Apache sur le repertoire `/public`
* Dans le fichier `.htaccess` qui se trouve dans le repertoire `/public`, 
   * utiliser la sytaxe suivante (dans le cas où le site est déployé dans le repertoire `/agritech`)
```
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On

    # Redirect Trailing Slashes...
    RewriteRule ^(.*)/$ /$1 [L,R=301]

    # Handle Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ /agritech/index.php [L]
</IfModule>
```
   * utiliser la sytaxe suivante (dans le cas où le site est déployé dans le repertoire `/`)
```
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On

    # Redirect Trailing Slashes...
    RewriteRule ^(.*)/$ /$1 [L,R=301]

    # Handle Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```


## Création de la base de données de développement
Exécuter la commande suivante depuis la racide du projet pour générer la base de données en environnement de développement :
```
php artisan migrate:install
php artisan migrate:refresh
php artisan db:seed
```

## Tests unitaires

### Principe des tests
Les tests unitaires s'effectuent à l'aide de la base de données en memoire sqllite. 
Le fichier de configuration est définit dans `/app/config/testing/database.php`.

Lors du lancement du test, la classe `/app/tests/TestCase.php` exécute le script qui initialise la base de données en mémoire.
 
### Lancer les tests
Pour lancer les tests d'intégration, il faut : 

`cd <racine du projet laravel>`

`vendor/bin/phpunit`

## Sécurité

### Rôles des utilisateurs

* Opérateur : est un utilisateur qui peut se connecter à la plateforme et voir les négociations et les alertes postées
* Super utilisateur : c'est un utilisateur qui aura accès à toutes les fonctionnailités métiers (mais pas technique comme la création des utilisateurs)
* Administrateur : c'est un administrateur qui peut tout faire et créer les utilisateurs par exemple
* Il existe des roles plus fins (comme Alerte) pour pouvoir accéder à cetaines fonctionnailités de l'application

### Utilisateurs par défaut

* admin/admin : administrateur (super utilisateur)
* agri1/agri1 : agriculteur (opérateur)
* achat1/achat1 : acheteur (opérateur)
* part1/part1 : partenaire (état, ministère de l'agriculture, ONG, ...)  (opérateur)

## En savoir plus
* [Le Wiki](https://github.com/agritech/agritech-web/wiki)
* Twitter
* ...
