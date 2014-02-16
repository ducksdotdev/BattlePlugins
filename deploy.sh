whoami
git stash
wait
git pull
wait
java -jar /home/tools/compiler.jar --js /home/battleplugins/git/BattlePlugins/laravel/public/assets/js/scripts.js --js_output_file /home/battleplugins/git/BattlePlugins/laravel/public/assets/js/scripts.min.js
java -jar /home/tools/compiler.jar --js /home/battleplugins/git/BattlePlugins/laravel/public/assets/js/admin.js --js_output_file /home/battleplugins/git/BattlePlugins/laravel/public/assets/js/admin.min.js
java -jar /home/tools/closure-stylesheets.jar /home/battleplugins/git/BattlePlugins/laravel/public/assets/css/style.css > style.min.css
