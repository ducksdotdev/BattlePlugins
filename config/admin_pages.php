<?php

use App\Tools\Misc\UserSettings;

return [
    'Dashboard' => [
        'action' => 'Admin\PageController@index',
        'node' => UserSettings::ADMIN_PANEL
    ],
    'Feeds' => [
        'Logs' => [
            'action' => 'Admin\PageController@logs',
            'node' => UserSettings::DEVELOPER
        ],
        'GitHub' => [
            'action' => 'Admin\PageController@github',
            'node' => UserSettings::ADMIN_PANEL
        ]
    ],
    'Statistics' => [
        'Short URLs' => [
            'action' => 'Admin\PageController@shortUrls',
            'node' => UserSettings::DELETE_SHORTURL
        ]
    ],
    'User Management' => [
        'Create User' => [
            'action' => 'Admin\PageController@createUser',
            'node' => UserSettings::CREATE_USER
        ],
        'Modify User' => [
            'action' => 'Admin\PageController@modifyUser',
            'node' => UserSettings::MODIFY_USER
        ]
    ],
    'Tools' => [
        'Create Alert' => [
            'action' => 'Admin\PageController@alerts',
            'node' => UserSettings::CREATE_ALERT
        ],
        'Manage Content' => [
            'action' => 'Admin\PageController@cms',
            'node' => UserSettings::MANAGE_CONTENT
        ]
    ]
];