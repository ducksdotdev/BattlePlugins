#!/bin/sh
whoami
git stash
wait
git pull
wait
java -jar /home/tools/compiler.jar --js laravel/public/assets/js/scripts.js --js_output_file laravel/public/assets/js/scripts.min.js
java -jar /home/tools/compiler.jar --js laravel/public/assets/js/admin.js --js_output_file laravel/public/assets/js/admin.min.js
java -jar /home/tools/closure-stylesheets.jar laravel/public/assets/css/style.css > laravel/public/assets/css/style.min.css
