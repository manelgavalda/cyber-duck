# Cyber-Duck

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/6.x/installation#installation)

Clone the repository

    git clone git@github.com:manelgavalda/cyber-duck.git

Switch to the repo folder

    cd cyber-duck

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

You can also run the migration with the `--seed` flag in order to create some fake data for the application

    php artisan migrate:fresh --seed

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

## Testing

This project uses `phpunit` (**installed with composer**) to test the application backend

    ./vendor/phpunit/phpunit/phpunit
