<?php

use App\Tools\Misc\UserSettings;

return [
    'Dashboard' => [
        'action' => 'AdminController@getIndex',
    ],
    'Feeds' => [
        'Logs' => [
            'action' => 'AdminController@getLogs',
            'node' => UserSettings::DEVELOPER
        ],
        'GitHub' => [
            'action' => 'AdminController@getGithub',
        ]
    ],
    'Statistics' => [
        'Short URLs' => [
            'action' => 'AdminController@getShortUrls',
            'node' => UserSettings::DELETE_SHORTURL
        ],
        'API Keys' => [
            'action' => 'AdminController@getApiKeys',
            'node' => UserSettings::VIEW_API_KEYS
        ]
    ],
    'Tools' => [
        'Create Alert' => [
            'action' => 'AdminController@getAlerts',
            'node' => UserSettings::CREATE_ALERT
        ],
        'Pastes' => [
            'action' => 'AdminController@getPastes',
            'node' => UserSettings::VIEW_PASTES
        ],
        'Manage Content' => [
            'action' => 'AdminController@getCms',
            'node' => UserSettings::MANAGE_CONTENT
        ],
    ],
    'User Management' => [
        'Create User' => [
            'action' => 'AdminController@getCreateUser',
            'node' => UserSettings::CREATE_USER
        ],
        'Modify User' => [
            'action' => 'AdminController@getModifyUser',
            'node' => UserSettings::MODIFY_USER
        ],
        'Permission Overview' => [
            'action' => 'AdminController@getPermissionOverview',
            'node' => UserSettings::VIEW_PERMISSIONS
        ]
    ],
    'Logout' => [
        'action' => 'Auth\AuthController@getLogout'
    ]
];