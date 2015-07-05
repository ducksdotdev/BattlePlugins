<?php

$url = env('APP_ENV_URL');
$tlds = ['.org', '.net', '.com'];

Route::get('/logout', 'UserController@logout');

Route::group(['before' => 'csrf'], function () {
    Route::post('/login', 'UserController@login');
});

Route::group(['before' => 'auth'], function () {
    Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

if (env('APP_ENV_URL') == 'localhost')
    $tlds = [''];

foreach ($tlds as $tld) {
    $url .= $tld;

    Route::group(['domain' => $url], function () {
        Route::get('/', 'Blog\PageController@index');
        Route::group(['before' => 'csrf', 'before' => 'auth'], function () {
            Route::post('/delete/{blog}', 'Blog\BlogController@deleteBlog');
            Route::post('/create', 'Blog\BlogController@create');
            Route::post('/{id}', 'Blog\BlogController@editBlog');
        });

        Route::get('/{id}', 'Blog\PageController@getBlog');
    });

    Route::group(['domain' => 'short.' . $url], function () {
        Route::get('/', 'ShortUrls\PageController@index');

        Route::group(['before' => 'auth', 'before' => 'csrf'], function () {
            Route::post('/create', 'ShortUrls\UrlController@create');
        });

        Route::get('/{url}', 'ShortUrls\UrlController@redirect');
    });

    Route::group(['domain' => 'api.' . $url], function () {
        Route::get('/', 'API\PageController@index');

        Route::group(['prefix' => 'v1'], function () {
            Route::resource('tasks', 'API\Endpoints\TasksController');
            Route::resource('users', 'API\Endpoints\UsersController');
            Route::resource('blogs', 'API\Endpoints\BlogsController');
            Route::resource('shorturls', 'API\Endpoints\ShortUrlsController');
            Route::resource('pastes', 'API\Endpoints\PastesController');
        });

        Route::group(['before' => 'csrf', 'before' => 'auth'], function () {
            Route::post('/generateKey', 'API\PageController@generateKey');
            Route::post('/webhooks', 'API\WebhookController@create');
        });
    });

    Route::group(['domain' => 'tasks.' . $url], function () {

        Route::get('/', 'Tasks\PageController@index');
        Route::get('/refreshIssues', 'Tasks\TasksController@refreshIssues');

        Route::group(['before' => 'csrf', 'before' => 'auth'], function () {
            Route::post('/tasks/complete/{id}', 'Tasks\TasksController@completeTask');
            Route::post('/tasks/delete/{id}', 'Tasks\TasksController@deleteTask');
            Route::post('/tasks/create', 'Tasks\TasksController@createTask');
        });
    });

    Route::group(['domain' => 'paste.' . $url], function () {
        Route::get('/', 'Paste\PageController@index');

        Route::group(['before' => 'auth', 'before' => 'csrf'], function () {
            Route::post('/create', 'Paste\PasteController@createPaste');
            Route::post('/edit', 'Paste\PasteController@editPaste');
            Route::post('/togglepub/{id}', 'Paste\PasteController@togglePublic');
            Route::post('/delete/{id}', 'Paste\PasteController@deletePaste');
        });

        Route::get('/{slug}', 'Paste\PasteController@getPaste');
        Route::get('/{slug}/raw', 'Paste\PasteController@getRawPaste');
        Route::get('/{slug}/download', 'Paste\PasteController@downloadPaste');
    });

    Route::group(['domain' => 'admin.' . $url], function () {
        Route::get('/', 'Admin\PageController@index');
        Route::get('/settings', 'Admin\PageController@settings');

        Route::group(['prefix' => 'user'], function () {
            Route::get('/create', 'Admin\PageController@createUser');
            Route::get('/modify', 'Admin\PageController@modifyUser');

            Route::group(['before' => 'csrf'], function () {
                Route::post('/modify/{id}/delete', 'UserController@deleteUser');
                Route::post('/modify/{id}/admin', 'UserController@toggleAdmin');
                Route::post('/create', 'UserController@createUser');
            });
        });

        Route::group(['prefix' => 'tools'], function () {
            Route::get('/alert', 'Admin\PageController@alerts');
            Route::get('/alert/json', 'Admin\ToolsController@jsonAlerts');

            Route::get('/cms', 'Admin\PageController@cms');

            Route::get('/serverstats', 'Admin\PageController@serverStats');

            Route::group(['before' => 'csrf'], function () {
                Route::post('/alert', 'Admin\ToolsController@alert');
                Route::post('/alert/delete/{id}', 'Admin\ToolsController@deleteAlert');
                Route::post('/cms/{toggle}', 'Admin\ToolsController@toggleSetting');
            });
        });

        Route::group(['before' => 'csrf'], function () {
            Route::post('/settings', 'UserController@changeSettings');
        });

    });

    Route::group(['domain' => 'bplug.in'], function(){
        return redirect()->action('ShortUrls\PageController@index');
    });

    $url = env('APP_ENV_URL');
}