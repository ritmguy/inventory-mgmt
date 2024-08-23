<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>
<h1 align="center">Laravel based Inventory Management System</h1>
<hr>

## Requirements
- PHP 8.0|8.1|8.2
- Debian 11.x
- Composer 2.x

Dockerfile is included for quick turn up.

## Quick Installation

    git clone https://github.com/ritmguy/inventory-mgmt.git

    cd inventory-mgmt
    
### Composer

    composer update
    
    
### Create Environment Variable File
 
    cp .env.example .env
- Make sure to replace variables with correct configs 
    
### Migrate database tables
 
    php artisan migrate
    
### Server Up
- Artisan:
        ```
        php artisan serve --port 8080
        ```

- Docker:
        ```
        docker build -t ims:latest . && docker run --env-file .env -d -t -p 8080:8080 -name ims ims:latest
        ```
- Connect: ```http://127.0.0.1:8080/```

