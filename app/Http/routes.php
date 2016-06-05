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
Route::get('contact', 'PagesController@getContact');
Route::resource('posts', 'PostController');
//admin
Route::get('/admin', ['uses' => 'PagesController@getAdmin',
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
 //end of admin
