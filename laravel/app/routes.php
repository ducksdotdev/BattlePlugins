<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'PageController@getIndex');
Route::get('/w', 'PageController@getWiki');
Route::get('/ci', 'PageController@getCI');
Route::get('/plugins', 'PageController@getPlugins');
Route::get('/register', 'UserController@getRegistrationPage')->before('guest');
Route::get('/tos', 'PageController@tos');
Route::get('/privacy', 'PageController@privacy');

Route::get('/profile/{name?}', 'UserController@getProfile');

Route::get('/blog/all', 'PageController@getBlog');
Route::get('/blog/{id?}', 'PageController@getBlogPost');

Route::get('/donate/cancel', 'PageController@getDonateCancel');
Route::get('/donate/thanks', 'PageController@getDonateThanks');

Route::group(array('before' => 'guest'), function () {
    Route::get('/login', 'UserController@getLoginPage');
    Route::get('/login/help', 'UserController@forgotPage');
    Route::get('/login/help/reset', 'UserController@resetPasswordPage');

    Route::group(array('before' => 'csrf'), function () {
        Route::post('/login/help/username', 'UserController@retrieveWithUsername');
        Route::post('/login/help/email', 'UserController@retrieveWithEmail');
        Route::post('/login/help/reset', 'UserController@resetPassword');

        Route::post('/login', 'UserController@loginUser');

        Route::post('/register', 'UserController@register');
    });

});

Route::group(array('before' => 'auth'), function(){
    Route::get("/api", "APIController@getDocumentation");
    Route::get('/api/generateKey', 'APIController@userGenerateKey');

    Route::get('/logout', 'UserController@logoutUser');
    Route::get("/user/settings", "UserController@getSettingsPage");

    Route::get('/paste/create', 'PasteController@getCreatePage');

    Route::get('/admin/blog', 'AdminController@getBlog');

    Route::get('/admin/manageUsers', 'AdminController@manageUsers');

    Route::get('/developer/statistics', 'DeveloperController@getStatistics');
    Route::get('/developer/statistics/clear/apiRequests', 'DeveloperController@clearAPIRequests');

    Route::get('/plugins/help', 'PageController@getPluginsHelp');

    Route::group(array('before'=>'csrf'), function(){
        Route::post("/user/settings", "UserController@changeSettings");

        Route::post('/paste/create', 'PasteController@createPaste');
        Route::post('/paste/delete', 'PasteController@deletePaste');
        Route::post('/paste/edit/getForm', 'PasteController@getEditForm');
        Route::post('/paste/edit', 'PasteController@editPaste');

        Route::post('/admin/blog', 'AdminController@saveBlog');
        Route::post('/admin/blog/edit', 'AdminController@editBlog');
        Route::post('/admin/blog/delete', 'AdminController@deleteBlog');

        Route::post('/admin/manageUsers/groups/get', 'AdminController@getUserGroupsForm');
        Route::post('/admin/manageUsers/groups/change', 'AdminController@changeUserGroups');

        Route::post('/admin/manageUsers/settings/get', 'AdminController@getSetting');
        Route::post('/admin/manageUsers/settings/set', 'AdminController@setSetting');
    });
});

Route::get('/paste/{id}/raw', 'PasteController@getRawPaste');
Route::get('/paste/{id}', 'PasteController@getPaste');

// API
Route::get("/api/web/blog/{id?}", 'APIController@getBlog');

Route::post("/api/web/paste/create", 'APIController@createPaste');
Route::post("/api/web/paste/delete/{id}", 'APIController@deletePaste');
Route::get("/api/web/paste/{id?}/{author?}", 'APIController@getPaste');

Route::get('/api/web/plugins/{name?}', 'APIController@getPlugins');

Route::get('/api/web/deploy', 'APIController@deployWebsite');
Route::post('/api/web/deploy', 'APIController@deployWebsite');

Route::get("/api/jenkins/{pluginName}", 'APIController@getJenkins');

Route::get('/api/battletracker/user/get/{username}/{action?}', 'APIController@getBattleTracker');
Route::post('/api/battletracker/user/set', 'APIController@setBattleTracker');

Route::get("/api/minecraft/face/{name?}/{size?}", 'APIController@getMinecraftFace');
