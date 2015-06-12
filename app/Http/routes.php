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

get('/', 'PageController@index');
get('/blog/{blog}', 'PageController@getBlog');

get('/logout', 'UserController@logout');

Route::group(['before' => 'csrf'], function () {
	post('/login', 'UserController@login');
});

Route::group(['before' => 'auth'], function () {
	get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
	get('/delete/{blog}', 'BlogController@deleteBlog');

	Route::group(['before' => 'csrf'], function () {
		post('/blog', 'BlogController@newBlog');
		post('/{blog}', 'BlogController@editBlog');
	});
});