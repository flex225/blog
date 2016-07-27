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

Route::get('/', 'PagesController@getIndex');
Route::get('about', 'PagesController@getAbout');
Route::get('/agreement', [
    'uses' => 'PagesController@getContact',
    'as' => 'contacts',
]);
Route::resource('posts', 'PostController');

Route::get('deletePost/{id}', [
    'uses' => 'PostController@deletePost',
    'as' => 'deletePost']);
Route::get('getSubcategories', [
    "uses" => 'PostController@getSubcategories',
    "as" => 'getSubcategories'
]);
Route::get('/fullagreement', [
    'uses' => 'PagesController@getFullAgreement',
    'as' => 'fullagreement',
]);

//user
Route::get('profile/{id}', [
    'uses' => 'PagesController@getUserInfo',
    'as' => 'getUserInfo',
    'middleware' => 'auth',
]);
Route::post('leaveFeedback', [
    'uses' => 'PagesController@leaveFeedback',
    'as' => 'leaveFeedback'
]);
//end user

Route::get('/myposts', 'PostController@getMyPosts');
Route::post('/updatePosts', [
    'uses' => 'PostController@updateFilter',
    'as' => 'updateFilter',
    'middleware' => 'auth',]);

//Auth
Route::get('login', [
    'uses' => 'Auth\AuthController@getLogin',
    'as' => 'login']);
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

Route::get('register', [
    'uses' => 'Auth\AuthController@getRegister',
    'as' => 'register']);
Route::post('register', 'Auth\AuthController@postRegister');
//end of Auth

//admin
Route::get('jxq/admin', ['uses' => 'PagesController@getAdmin',
    'as' => 'admin']);
Route::post('/admin', [
    'uses' => 'AdminController@adminSingin',
    'as' => 'adminLogin']);
Route::get('/admin/controlpage', [
    'uses' => 'AdminController@getAdminPage',
    'as' => 'controlpage',
    'middleware' => 'auth']);
Route::get('/logout', [
    'uses' => 'AdminController@getLogout',
    'as' => 'logout'
]);
Route::post('addpostype', [
    'uses' => 'AdminController@createPostType',
    'as' => 'createPostType']);

Route::post('addpostsubtype', [
    'uses' => 'AdminController@createPostSubType',
    'as' => 'createPostSubType']);

Route::post('deleteposttype', [
    'uses' => 'AdminController@deletePostType',
    'as' => 'deleteposttype'
]);

Route::post('deletepostsubtype', [
    'uses' => 'AdminController@deletePostSubtype',
    'as' => 'deletepostsubtype'
]);

Route::get('/admin/adminPosts', [
    'uses' => 'AdminController@getAllPosts',
    'as' => 'getposts',
    'middleware' => 'auth'
]);

Route::get('/admin/adminUsers', [
    'uses' => 'AdminController@getAllUsers',
    'as' => 'getusers',
    'middleware' => 'auth'
]);
Route::post('/admin/delete/{id}', [
    'uses' => 'AdminController@deleteUser',
    'as' => 'delete.user',
]);
Route::post('/admin/recover/{id}', [
    'uses' => 'AdminController@recoverUser',
    'as' => 'recover.user',
]);
Route::post('/admin/addAge', [
    'uses' => 'AdminController@addAge',
    'as' => 'add.age',
]);
Route::post('/admin/removeAge', [
    'uses' => 'AdminController@removeAge',
    'as' => 'remove.age',
]);
Route::post('/admin/addState', [
    'uses' => 'AdminController@addState',
    'as' => 'add.state',
]);
Route::post('/admin/removeState', [
    'uses' => 'AdminController@removeState',
    'as' => 'remove.state',
]);
 //end of admin
