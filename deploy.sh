cd /home/battleplugins/git/BattlePlugins
wait
git stash
wait
git pull
wait
echo "Git repository pulled - running compression scripts"
java -jar /home/tools/compiler.jar --js /home/battleplugins/git/BattlePlugins/laravel/public/assets/js/scripts.js --js_output_file /home/battleplugins/git/BattlePlugins/laravel/public/assets/js/scripts.min.js
java -jar /home/tools/compiler.jar --js /home/battleplugins/git/BattlePlugins/laravel/public/assets/js/admin.js --js_output_file /home/battleplugins/git/BattlePlugins/laravel/public/assets/js/admin.min.js
chmod 755 /home/battleplugins/git/BattlePlugins/deploy.sh
echo "Done"
