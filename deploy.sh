git stash
wait
git pull
wait
echo "Git repository pulled - running compression scripts"
java -jar /home/tools/compiler.jar --js /home/battleplugins/git/BattlePlugins/laravel/public/assets/js/scripts.js --js_output_file /home/battleplugins/git/BattlePlugins/laravel/public/assets/js/scripts.min.js
java -jar /home/tools/compiler.jar --js /home/battleplugins/git/BattlePlugins/laravel/public/assets/js/admin.js --js_output_file /home/battleplugins/git/BattlePlugins/laravel/public/assets/js/admin.min.js
chown -R lducks:deploy /home/battleplugins
chmod -R 774 /home/battleplugins
echo "Done"
