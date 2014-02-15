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
    ),
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
        'title' => 'Create a Paste',
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
    )
);
