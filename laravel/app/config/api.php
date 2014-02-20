<?php

use BattleTools\BattleTracker\Actions;
use BattleTools\UserManagement\UserGroups;
use BattleTools\Util\ListSentence;
use Illuminate\Support\Facades\DB;

$actions = Actions::getAll();
foreach($actions as $action){
    $actionString[] = '<strong>'.Actions::getActionName($action).' (action ID: '.$action.')</strong>';
}

$actionString = ListSentence::toSentence($actionString, 'or');

$plugins = DB::table('plugins')->get();
foreach($plugins as $plugin){
    $pluginsList[] = $plugin->name;
}

$pluginsList = ListSentence::toSentence($pluginsList, 'or');

return array(
    //  Basic API methods
    array(
        'name' => 'minecraft',
        'methods' => array(
            array(
                'title' => 'Minecraft Skin Faces',
                'url' => '/api/minecraft/face/{name}/{size?}',
                'methods' => array(
                    array(
                        'name'=>'get',
                        'color'=>'info'
                    ),
                ),
                'example' => '',
                'description' => 'This endpoint will give you a Content-Type image/png of the {user}\'s minecraft skin face. An example of this can be found on a user profile. This does not require an API key for access. These requests do not effect your timeout limitations.',
                'params' => '',
                'group' => UserGroups::getAll()
            ),
            array(
                'title' => 'Get Minecraft Server Information',
                'url' => '/api/minecraft/server/{ip}/{port?}',
                'methods' => array(
                    array(
                        'name'=>'get',
                        'color'=>'info'
                    ),
                ),
                'example' => '{"ip":"192.168.1.1","port":"25565","online":"true","motd":"Welcome to our server","curPlayers":"2","maxPlayers":"10"}',
                'description' => 'Gets all the information about a Minecraft server.',
                'params' => '',
                'group' => UserGroups::getAll()
            ),
        ),
        array(
            'name' => 'jenkins',
            array(
                'title' => 'Get CI Build',
                'url' => '/api/jenkins/{pluginName}',
                'methods' => array(
                    array(
                        'name' => 'get',
                        'color' => 'info'
                    )
                ),
                'example' => '{"job":"http:\/\/ci.battleplugins.com\/job\/BattleArena","build":"87","build_link":"http:\/\/ci.battleplugins.com\/job\/BattleArena\/87"}',
                'description' => 'Retrieves the job link, latest build, and build link for the specified plugin\'s most recent successful build. The only accepted {pluginName} variables are '.$pluginsList,
                'params' => '',
                'group' => UserGroups::getAll()
            )
        ),
    ),

    array(
        'name' => 'website',
        'methods' => array(
            array(
                'title' => 'Retrieve Blog Post',
                'url' => '/api/web/blog/{id|all|newest}',
                'methods' => array(
                    array(
                        'name'=>'get',
                        'color'=>'info'
                    ),
                ),
                'example' => '[{"id":"1","title":"Example Title","author":"1","content":"Some article text","created_at":"2014-02-10 19:59:03"}]',
                'description' => 'Retrieves a specific, newest, or all of the blog entries on our website.',
                'params' => '',
                'group' => UserGroups::getAll()
            ),
            array(
                'title' => 'Create Paste',
                'url' => '/api/web/paste/create',
                'methods' => array(
                    array(
                        'name'=>'post',
                        'color'=>'warning'
                    ),
                ),
                'example' => '{"id": "z0QtkP"}',
                'description' => 'Creates a paste under your account name. The output is the ID of your paste which you can use to access pastes at <code>/paste/{id}</code>',
                'params' => array('title (VARCHAR 32)','content (TEXT) REQUIRED','delete (TIMESTAMP)','private (BOOLEAN)','lang (VARCHAR 11)'),
                'group' => UserGroups::getAll()
            ),
            array(
                'title' => 'Retrieve Paste',
                'url' => '/api/web/paste/{id|all}/{author}',
                'methods' => array(
                    array(
                        'name'=>'get',
                        'color'=>'info'
                    ),
                ),
                'example' => '[{"id":"dGszJE","author":"4","title":"BattlePaste test","content":"Example content","lang":"java","created_on":"2014-02-11 19:17:57"}]',
                'description' => 'Retrieves a specific or all pastes. This will not retrieve pastes that are marked as private or that have an expiration date. This is in order to protect the privacy of these pastes.',
                'params' => '',
                'group' => UserGroups::getAll()
            ),
            array(
                'title' => 'Delete Paste',
                'url' => '/api/web/paste/delete/{id}',
                'methods' => array(
                    array(
                        'name'=>'get',
                        'color'=>'info'
                    ),
                ),
                'example' => '["success"]',
                'description' => 'Deletes a paste. You can only delete pastes that belong to you. Admins can delete any pastes regardless of ownership.',
                'params' => '',
                'group' => UserGroups::getAll()
            ),
            array(
                'title' => 'Get Plugins',
                'url' => '/api/web/plugins/{name|all}',
                'methods' => array(
                    array(
                        'name'=>'get',
                        'color'=>'info'
                    ),
                ),
                'example' => '[{"name":"ArenaCTF","author":"5","bukkit":"http:\/\/dev.bukkit.org\/server-mods\/arenactf\/"}]',
                'description' => 'Get\'s the name, author, and Bukkit URL of all or a specific plugin. Authors are represented by their User IDs.',
                'params' => '',
                'group' => UserGroups::getAll()
            ),
            array(
                'title' => 'Deploy From Github',
                'url' => '/api/web/deploy',
                'methods' => array(
                    array(
                        'name'=>'get',
                        'color'=>'info'
                    ),
                    array(
                        'name'=>'post',
                        'color'=>'warning'
                    ),
                ),
                'example' => '{"output":"www-data\nNo local changes to save\nUpdating f74f466..e40111a\nFast-forward\n laravel\/app\/views\/forgot.blade.php | 4 ++--\n 1 file changed, 2 insertions(+), 2 deletions(-)\n","errors":"From github.com:lDucks\/BattlePlugins\n   f74f466..e40111a  master     -> origin\/master\n"}',
                'description' => 'Downloads the GitHub BattlePlugins website repo, deploys it to the website and compresses CSS and JS. <strong>Please refrain from using this without good reason. This method automatically puts the website under maintenance during deploy</strong>. The POST method is mainly used for GitHub.',
                'params' => array('payload MUST BE FROM GITHUB', 'timeout (SECONDS)'),
                'group' => array(UserGroups::ADMINISTRATOR, UserGroups::DEVELOPER)
            ),
        ),
    ),

    array(
        'name' => 'battletracker',
        'methods' => array(
            array(
                'title' => 'Add BattleTracker Information',
                'url' => '/api/battletracker/user/set',
                'methods' => array(
                    array(
                        'name'=>'post',
                        'color'=>'warning'
                    ),
                ),
                'example' => '{"action":"completed","server":"192.168.1.1:25565"}',
                'description' => 'Adds information about a specific user to BattleTracker. Possible "action" types are '.$actionString.'. Please use their action ID for the ID param. This function can only be called from an IP linked to a Minecraft server. This is for validation reasons.',
                'params' => array('action (INT) REQUIRED','action_by (VARCHAR 16) REQUIRED','action_to (VARCHAR 16) REQUIRED'),
                'group' => UserGroups::getAll()
            ),
            array(
                'title' => 'Get BattleTracker Information',
                'url' => '/api/battletracker/user/get/{username}/{action?}',
                'methods' => array(
                    array(
                        'name'=>'get',
                        'color'=>'info'
                    ),
                ),
                'example' => '[{"action":"1","action_by":"lDucks","action_to":"alkarin_v","server":"192.168.1.1:25565","created_on":"0000-00-00 00:00:00"}]',
                'description' => 'Gets information about a specific user from BattleTracker. Possible "action" types are '.$actionString.'. Please use their action ID for the action param.',
                'params' => '',
                'group' => UserGroups::getAll()
            ),
        ),
    ),

    array(
        'name' => 'statistics',
        'methods' => array(
            array(
                'title' => 'Set Statistic',
                'url' => '/statistics/set',
                'methods' => array(
                    array(
                        'name'=>'post',
                        'color'=>'warning'
                    ),
                ),
                'example' => '',
                'description' => 'Sets a statistic for a plugin and server. Leaving \'value\' blank will delete the key/value pair. This does not impact limitations and does not require an API key. Requests must come from a Minecraft server.',
                'params' => array('key (VARCHAR 16) REQUIRED', 'value (VARCHAR 256)', 'plugin (VARCHAR 64)'),
                'group' => array(UserGroups::ADMINISTRATOR, UserGroups::DEVELOPER)
            ),
            array(
                'title' => 'Get Statistic',
                'url' => '/statistics/get',
                'methods' => array(
                    array(
                        'name'=>'post',
                        'color'=>'warning'
                    ),
                ),
                'example' => '[{"server":"198.168.1.109","plugin":"Bukkit","key":"bPlayers","value":"10"}]',
                'description' => 'Gets a statistic for a plugin and server. This does not impact limitations and does not require an API key.',
                'params' => array('key (VARCHAR 16) REQUIRED', 'server (VARCHAR 16)'),
                'group' => array(UserGroups::ADMINISTRATOR, UserGroups::DEVELOPER)
            ),
        )
    )
);
