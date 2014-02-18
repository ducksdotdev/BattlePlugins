#!/bin/sh
php artisan down
wait
composer update
wait
composer install
wait
php artisan up
