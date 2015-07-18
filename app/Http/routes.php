<?php

$url = env('APP_ENV_URL');

Route::get('/login', 'UserController@getLogin');
Route::get('/logout', 'UserController@logout');

Route::group(['before' => 'csrf'], function () {
    Route::post('/login', 'UserController@login');

    // Password reset link request routes...
    Route::post('/password/email', 'PasswordController@postEmail');
    // Password reset routes...
    Route::post('/password/reset', 'PasswordController@postReset');
});

// Password reset link request routes...
Route::get('/password/email', 'PasswordController@getEmail');
// Password reset routes...
Route::get('/password/reset/{token}', 'PasswordController@getReset');

Route::group(['domain' => $url], function () {
    Route::group(['before' => 'csrf', 'before' => 'auth'], function () {
        Route::post('/delete/{blog}', 'Blog\BlogController@deleteBlog');
        Route::post('/create', 'Blog\BlogController@create');
        Route::post('/{id}', 'Blog\BlogController@editBlog');
    });

    Route::get('/{id?}', 'Blog\PageController@index');
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

Route::group(['domain' => 'dl.' . $url], function () {
    Route::get('/', 'Download\PageController@index');
    Route::any('/update/{event?}', 'Download\JenkinsController@updateJenkins');

    Route::group(['prefix' => 'job'], function () {
        Route::get('/{job?}', 'Download\PageController@index');
        Route::get('/{job}/download/{build?}', 'Download\JenkinsController@download');
        Route::get('/{job}/latestVersionImage/{w?}/{h?}/{font_size?}', 'Download\PageController@getLatestVersionImage');
        Route::get('/{job}/latestStableVersionImage/{w?}/{h?}/{font_size?}', 'Download\PageController@getLatestStableVersionImage');

        Route::group(['before' => 'csrf', 'before' => 'auth'], function () {
            Route::post('/{job}/production', 'Download\JenkinsController@toggleProduction');
        });
    });
});

Route::group(['domain' => 'admin.' . $url], function () {
    Route::get('/', 'Admin\PageController@index');
    Route::get('/settings', 'Admin\PageController@settings');

    Route::group(['prefix' => 'feeds'], function () {
        Route::get('/github', 'Admin\PageController@github');
        Route::get('/logs/{name?}/{currPage?}/{perPage?}', 'Admin\PageController@logs');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/create', 'Admin\PageController@createUser');
        Route::get('/modify', 'Admin\PageController@modifyUser');

        Route::group(['before' => 'csrf'], function () {
            Route::post('/modify/{id}/delete', 'UserController@deleteUser');
            Route::post('/modify/{id}/admin', 'UserController@toggleAdmin');
            Route::post('/create', 'UserController@createUser');
        });
    });

    Route::group(['prefix' => 'statistics'], function () {
        Route::get('/shorturls/{currPage?}/{perPage?}', 'Admin\PageController@shortUrls');

        Route::group(['before' => 'csrf'], function () {
            Route::post('/shorturls/delete/{id}', 'Admin\StatisticsController@deleteShortUrl');
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

Route::group(['domain' => 'short.' . $url], function () {
    Route::group(['before' => 'csrf'], function () {
        Route::post('/create', 'ShortUrls\PageController@create');
    });

    Route::get('/', 'ShortUrls\PageController@index');
});

Route::group(['domain' => 'voice.' . $url], function () {
    Route::get('/', 'Voice\PageController@index');
    Route::get('/feed', 'Voice\PageController@feed');
});


Route::group(['domain' => 'bplug.in'], function () {
    Route::get('/', function () {
        return redirect()->action('ShortUrls\PageController@index');
    });

    Route::get('/{url}', 'ShortUrls\PageController@redirect');
});