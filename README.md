<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Surplus API

This is repository for Backend Challange at Surplus.id. Technology or package that use are :

- Laravel Framework 10.
- MySQL Database.
- Sanctum Authentication

## Installation 
Please follow this step to install the project:

    git clone https://github.com/ramdhanrizkij/surplus-api.git
    cd surplus-api
    composer install

After download and package install successfully. Rename .env.example into .env and adjust the database connection.
    
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=surplus_db
    DB_USERNAME=root
    DB_PASSWORD=

Run this command to generate laravel key

    php artisan key:generate

Run this command to migrate the database:

    php artisan migrate

## Running
You can running the application using php artisan command: 

    php artisan serve

Default port is :8000

## Documentation
Documentation for the API is saved on *API Documentation.json* files. You can import that file using Thunderclient Extension on VS Code.
