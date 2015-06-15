<?php

use App\Tools\URL\Domain;

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

Route::group(['domain'=>'battleplugins.{tld}'], function(){
    Route::get('/', 'Blog\PageController@index');
    Route::get('/blog/{blog}', 'Blog\PageController@getBlog');

    Route::group(['before' => 'auth'], function () {
        Route::get('/delete/{blog}', 'Blog\Blog\BlogController@deleteBlog');

        Route::group(['before' => 'csrf'], function () {
            Route::post('/create', 'Blog\BlogController@create');
            Route::post('/blog/{blog}', 'Blog\BlogController@editBlog');
        });
    });
});

Route::group(['domain'=>'api.battleplugins.{tld}'], function(){
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

Route::get('/logout', 'UserController@logout');

Route::group(['before' => 'csrf'], function () {
    Route::post('/login', 'UserController@login');
});

Route::group(['before' => 'auth'], function () {
    Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});