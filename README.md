[![Build Status](https://travis-ci.org/agritech/agritech-web.svg)](https://travis-ci.org/agritech/agritech-web)
-

# dossoagri
Bienvenu sur le site du projet DOSSIAGRI

## Personnes concernées
DOSSO Agri est une initiative qui a pour but de mettre en relation :

* Les petits agriculteurs ;
* Les acheteur finaux ;
* Et les pouvoir publics et ONG qui travaillent dans l'agriculture.

## Objectifs de la plateforme DOSSOAGRI
Aujourd'hui, la plateforme permet de :
* Aider les agriculteurs à réguler leur production en fonction du climat et du marché
* Cartographier les zones agricoles exploitables du Niger avec les caractéristiques liées a la zone et proposer des types de culture propice a la zone
* Permettre aux éleveurs et agriculteurs de connaitre les points d'eau et mettre en place un système de réservation pour faciliter l’accès a la ressource.

## Architecture
Pour l'architecture, rien de mieux que les [micro services] Il faut faire plein de petites appli avec plein de langages et les faire communiquer par Web services. C'est fini les grosses appli avec 50us.

Du coup pour le premier pavé voici la vision (à mettre-à-jour) :
* Application SMS pour les fonctionnalités agriculteurs ;
* Application Web pour les internautes (négociation de prix des recoltes postés) ;
* Application autre pour le reste (par exemple le template WPF d'Alain )

## Production

* Lavravel fonctionnel avec PHP > =5.4.0

## Développement
* Exécuter la base de données `/dev.sql` sur le serveur de données MySQL
* Changer les paramètres de la base de données dans le fichier `/app/config/database.php`
* Vérifier l'URL de l'application dans le repertoire `/app/config/app.php`
* Mettre à jour le repertoire vendor contenant les dépendances composer
```
composer update
```
* Faire pointer Apache sur le repertoire `/public`
* Dans le fichier `.htaccess` qui se trouve dans le repertoire `/public`, 
   * utiliser la sytaxe suivante (dans le cas où le site est déployé dans le repertoire `/dossoagri`)
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
    RewriteRule ^ /dossoagri/index.php [L]
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
* vend1/vend1 : acheteur (opérateur)
* part1/part1 : partenaire (état, ministère de l'agriculture, ONG, ...)  (opérateur)

## En savoir plus
* [Le Wiki](https://github.com/agritech/agritech-web/wiki)
* Twitter
* ...
