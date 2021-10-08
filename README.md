# Api Ekskul.co.id

## Installation

``` bash
# clone the repo
$ git clone git@github.com:Ekskul-co-id/api-ekskul.git

# go into app's directory
$ cd api-ekskul

# move to branch staging
$ git branch dev

# install app's dependencies
$ composer install

# Copy file ".env.example", and change its name to ".env".
$ cp .env.example .env

# generate laravel APP_KEY
$ php artisan key:generate

# Then in file ".env" complete the database configuration

# run database migration and seed
$ php artisan migrate:refresh --seed

# start local server
$ php artisan serve

# test
$ php vendor/bin/phpunit
```