<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$url = env('APP_ENV_URL');

Route::get('/logout', 'UserController@logout');

Route::group(['before' => 'csrf'], function () {
    Route::post('/login', 'UserController@login');
});

Route::group(['before' => 'auth'], function () {
    Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

Route::group(['domain' => $url], function () {
    Route::get('/', 'Blog\PageController@index');
    Route::group(['before' => 'auth'], function () {
        Route::get('/delete/{blog}', 'Blog\Blog\BlogController@deleteBlog');

        Route::group(['before' => 'csrf'], function () {
            Route::post('/create', 'Blog\BlogController@create');
            Route::post('/{id}', 'Blog\BlogController@editBlog');
        });
    });

    Route::get('/{id}', 'Blog\PageController@getBlog');
});

Route::group(['domain' => 'api.' . $url], function () {
    Route::get('/', 'API\PageController@index');

    Route::group(['prefix'=>'v1'], function() {
        Route::resource('tasks', 'API\Endpoints\TasksController');
        Route::resource('users', 'API\Endpoints\UsersController');
        Route::resource('blogs', 'API\Endpoints\BlogsController');
        Route::resource('shorturls', 'API\EndpointsAPI\ShortUrlsController');
    });

    Route::group(['before' => 'auth'], function () {
        Route::get('/generateKey', 'API\PageController@generateKey');

        Route::group(['before'=>'csrf'], function(){
            Route::post('/webhooks', 'API\WebhookController@create');
        });

    });

});

if (env('APP_ENV_URL') == 'localhost')
    $shurl = 'bplugin.localhost';
else
    $shurl = 'bplug.in';

Route::group(['domain' => $shurl], function () {
    Route::get('/', 'ShortUrls\PageController@index');

    Route::group(['before' => 'auth'], function () {
        Route::group(['before' => 'csrf'], function () {
            Route::post('/create', 'ShortUrls\UrlController@create');
        });
    });

    Route::get('/{url}', 'ShortUrls\UrlController@redirect');
});

Route::group(['domain' => 'tasks.' . $url], function () {

    Route::get('/', 'Tasks\PageController@index');

    Route::post('/tasks/create/github', 'Tasks\TasksController@gitHubCreate');

    Route::group(['before' => 'auth'], function () {
        Route::get('/tasks/complete/{id}', 'Tasks\TasksController@completeTask');
        Route::get('/tasks/delete/{id}', 'Tasks\TasksController@deleteTask');

        Route::group(['before' => 'csrf'], function () {
            Route::post('/tasks/create', 'Tasks\TasksController@createTask');
        });
    });
});