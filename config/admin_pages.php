<?php

use App\Tools\Misc\UserSettings;

return [
    'Dashboard' => [
        'action' => 'Admin\PageController@index',
    ],
    'Feeds' => [
        'Logs' => [
            'action' => 'Admin\PageController@logs',
            'node' => UserSettings::DEVELOPER
        ],
        'GitHub' => [
            'action' => 'Admin\PageController@github',
        ]
    ],
    'Statistics' => [
        'Short URLs' => [
            'action' => 'Admin\PageController@shortUrls',
            'node' => UserSettings::DELETE_SHORTURL
        ],
        'API Keys' => [
            'action' => 'Admin\PageController@apiKeys',
            'node' => UserSettings::VIEW_API_KEYS
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
    ],
    'Logout' => [
        'action' => 'Auth\AuthController@getLogout'
    ]
];