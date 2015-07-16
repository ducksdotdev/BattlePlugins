<?php

return [
    'all' => [
        'Dashboard' => 'Admin\PageController@index',
        'Feeds' => [
            'Logs' => 'Admin\PageController@logs',
            'GitHub' => 'Admin\PageController@github'
        ],
        'Statistics' => [
            'Short URLs' => 'Admin\PageController@shortUrls'
        ]
    ],
    'admin' => [
        'User Management' => [
            'Create User' => 'Admin\PageController@createUser',
            'Modify User' => 'Admin\PageController@modifyUser'
        ],
        'Tools' => [
            'Create Alert' => 'Admin\PageController@alerts',
            'Manage Content' => 'Admin\PageController@cms'
        ]
    ]
];