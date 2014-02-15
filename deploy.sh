cd /home/battleplugins/git/BattlePlugins
git pull
echo "Git repository pulled - running compression scripts"
java -jar /home/tools/compiler.jar --js /home/battleplugins/website/laravel/public/assets/js/scripts.js --js_output_file /home/battleplugins/website/laravel/public/assets/js/scripts.min.js
java -jar /home/tools/compiler.jar --js /home/battleplugins/website/laravel/public/assets/js/admin.js --js_output_file /home/battleplugins/website/laravel/public/assets/js/admin.min.js
echo "Done"
