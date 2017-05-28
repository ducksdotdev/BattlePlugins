<?php

use App\Tools\UserSettings;

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
    'Blog' => [
        'Blog Posts' => [
            'action' => 'AdminController@getEditBlogPosts',
            'node' => UserSettings::MODIFY_BLOG
        ],
        'Create Post' => [
            'action' => 'AdminController@getCreateBlogPost',
            'node' => UserSettings::CREATE_BLOG
        ]
    ],
    'Tasks' => [
        'View Tasks' => [
            'action' => 'AdminController@getTasks',
            'node' => UserSettings::VIEW_TASK
        ],
        'Create Task' => [
            'action' => 'AdminController@getCreateTask',
            'node' => UserSettings::CREATE_TASK
        ]
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
        ],
        'API Keys' => [
            'action' => 'AdminController@getApiKeys',
            'node' => UserSettings::VIEW_API_KEYS
        ]
    ],
    'Logout' => [
        'action' => 'Auth\AuthController@getLogout'
    ]
];