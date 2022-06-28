# API Kindred Documentation

## Introduction

L'API Kindred est un backend utilisant Symfony pour gérer les données et l'authentification des utilisateurs de l'application Kindred front en React.

Les principaux frameworks et librairies utilisées pour ce projet sont :
- [Symfony](https://symfony.com/) : framework PHP pour le développement d'applications web et de services web.
- [api-platform](https://api-platform.com/) : framework PHP pour le développement d'API REST.
- [jwt-authentication-bundle](https://github.com/lexik/LexikJWTAuthenticationBundle): bundle pour l'authentification JWT.
- [doctrine-fixtures-bundle](https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html): bundle pour gérer les fixtures.
- [maker-bundle](https://symfony.com/bundles/MakerBundle/current/index.html): bundle pour créer les entités, controller etc .


## Installation

```bash
    # clone the project
    git clone https://gitlab.com/p5187/kindred-symfony-rest-api.git
    cd kindred-symfony-rest-api
    
    # install dependencies
    composer install
    
    # create database
    php bin/console doctrine:database:create
    
    # migrate database
    php bin/console doctrine:migrations:migrate
    
    # load fixtures
    php bin/console doctrine:fixtures:load
    
```


## Lancer le serveur

```bash
    # with symfony cli
    symfony server:start
    # with php
    php -S localhost:8000 -t public
    
```
L'application sera accessible à l'adresse suivante http://localhost:8000/api

