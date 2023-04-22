# testS

### Prérequis
Symfony

## Installation
Tout d'abord clonez le repository

Allez dans le dossier "my_project_directory" 
```sh
cd my_project_directory
```
executez :
```sh
composer install
```
Dans le .env configurer vos identifiant de connection a votre base de données.
```sh
DATABASE_URL="mysql://user:user@127.0.0.1:3306/BDDTEST"
```
Crée la base de données BDDTEST dans votre phpmyadmin.
Une fois la base de données crée effectuer les migrations.
```sh
php bin/console make:migration
```
```sh
php bin/console doctrine:migrations:migrate
```
Pour remplir la base de donnée effectuer :
```sh
php bin/console doctrine:fixtures:load
```
Enfin lancez votre serveur 
```sh
symfony serve
```
Si vous vous rendez sur le site http://localhost:8000/ vous devriez voir apparaitre le systeme de connexion.

Bonne visite !
