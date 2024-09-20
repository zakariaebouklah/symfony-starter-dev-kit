# SETUP the project locally
## Build and start containers

run the command:

```
docker compose up -d --build
```

this will build and start containers. if you have issues with ports, please choose other ports in the `docker-compose.yaml` file and retry.

once finished, try to run:

```
docker compose ps
```

to make sure that all containers are `up`

to enter the container, please run the command:

```
docker exec -it <the service name> sh
```

or with:

```
docker compose exec <the service name> sh
```

tape `exit` if you want to quit the container and go back to host.

![alt text](doc/image.png)

to stop the containers, run:

```
docker compose stop
```

to restart the containers without rebuilding them:

```
docker compose up -d 
```

> from now on, all symfony commands (like make commands) must be run inside the `php` container

## Install Symfony and dependencies

```
# start the containers if not already started

docker compose up -d
```

```
# enter the php container

docker exec -it php sh
```

now that you are inside the `php` container, run the following commands inside the `php` container

```
composer self-update
composer install
```

this project contains :

- Empty Symfony project with the latest version (7.1.4)
- Setup for frontend using webpack-encore bundle: https://symfony.com/doc/current/frontend.html#webpack-encore

## Configure the project

inside the `php` container, run the command:

```
composer dump-env dev
```

this will create a `.env.local.php` file. the content of this file should look like the following

```
<?php

return array (
  'APP_ENV' => 'dev',
  'APP_SECRET' => 'f693cb9d977ca50c10babcc0dcc31ec0',
  'DATABASE_URL' => 'postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8',
  'MESSENGER_TRANSPORT_DSN' => 'doctrine://default?auto_setup=0',
);

```

please change the `DATABASE_URL` value with ***'postgresql://root:password@127.0.0.1:5432/main_db/XXX?serverVersion=16&charset=utf8'***

the docker setup has already created an empty database called `database`. if you want to change it, change the value of `DATABASE_URL` like

```
'DATABASE_URL' => 'postgresql://root:password@127.0.0.1:5432/main_db/XXX?serverVersion=16&charset=utf8',
``` 
where `XXX` is the new database name. then, run the command:

```
php bin/console doctrine:database:create
```

to create the new database.

**PS**: 
you can also simply make copy of the existing `.env` file and rename it to `.env.local` and customize settings like database config as shown above.

## Compile your frontend assets (JS & CSS) using webpack

always inside the `php` container just run the command below:

```
# compile assets and auto re-compile when files change

npm run watch
```

for more useful commands checkout the below links:

- https://symfony.com/doc/current/frontend/encore/index.html
- https://symfony.com/doc/current/frontend/encore/installation.html
- https://symfony.com/doc/current/frontend/encore/simple-example.html

## Create a new controller

to create a new Controller / pages, you need to run the following command:

```
php bin/console make:controller
```

## Create entities

to create (or update) entities, run the following command:

```
php bin/console make:entity
```

## Create migration

to create  and apply migrations, run the following commands:

```
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

## Create a new Foundry factory

to create a Foundry factory, run the following command:

```
php bin/console make:factory
```

## Load fixtures

to load data in the database, run the command:

```
php bin/console doctrine:fixtures:load
```

and answer `yes`.

## PHP coding standards and best practices tracking

### PHPStan:
from docs: https://phpstan.org/ - https://github.com/phpstan/phpstan
> ...PHPStan focuses on finding errors in your code without actually running it. It catches whole classes of bugs even before you write tests for the code. It moves PHP closer to compiled languages in the sense that the correctness of each line of the code can be checked before you run the actual line.

- use PHPStan running the command:

```
composer phpstan
```

### PHPCSFixer:
from docs: https://cs.symfony.com/ - https://github.com/PHP-CS-Fixer/PHP-CS-Fixer
> The PHP Coding Standards Fixer (PHP CS Fixer) tool fixes your code to follow standards; whether you want to follow PHP coding standards as defined in the PSR-1, PSR-2, etc., or other community driven ones like the Symfony one. You can also define your (team's) style through configuration.

- use PHPCSFixer with:

```
composer cs-fixer
```

- or with:

```
# PHP CS Fixer to perform a dry run. 
# In a dry run, PHP CS Fixer will simulate making the changes without actually modifying the files.

composer cs-fixer-dry
```