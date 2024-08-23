<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>
<h1 align="center">Laravel based Inventory Management System</h1>
<hr>

## Requirements
- PHP 8.0 | PHP 8.1
- Debian 11.x

Dockerfile is included for quick turn up.

## Quick Installation

    git clone https://github.com/ritmguy/inventory-mgmt.git

    cd inventory-mgmt
    
### Composer

    composer update
    
    
### For Environment Variable Create
 
    cp .env.example .env
 
    
### For Migration table in database [Create database name as ```IMS```]
 
    php artisan migrate
    
### Server ON ```url: http://127.0.0.1:8000/```

    php artisan serve


