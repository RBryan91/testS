# testS

### Prérequis
Symfony

## Installation
Tout d'abord, cloner le repository.

Aller dans le dossier "my_project_directory".
```sh
cd my_project_directory
```
Executer :
```sh
Composer install.
```
Dans le .env, configurer vos identifiants de connexion à votre base de données.
```sh
DATABASE_URL="mysql://user:user@127.0.0.1:3306/BDDTEST"
```
Créer la base de données BDDTEST dans votre phpmyadmin.
Une fois la base de données créée, effectuer les migrations.
```sh
php bin/console make:migration
```
```sh
php bin/console doctrine:migrations:migrate
```
Pour remplir la base de données, effectuer :
```sh
php bin/console doctrine:fixtures:load
```
Enfin... lancer votre serveur.
```sh
symfony serve
```
En vous rendant sur le site http://localhost:8000/ vous devriez voir apparaitre le systeme de connexion.

Bonne visite !
