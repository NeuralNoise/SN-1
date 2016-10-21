<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('/', function () {
	return view('welcome');
})->middleware('guest');
Auth::routes();
Route::group(['middleware' => 'auth'], function () {
	//user
	Route::get('/dashboard')->uses('UserController@getDashboard')->name('dashboard');
	Route::get('logout')->uses('Auth\LoginController@logout')->name('logout');
	//posts
	Route::post('/createpost')->uses('PostController@postCreatePost')->name('post.create');
	Route::get('/postDelete/{post_id}')->uses('PostController@getDeletePost')->name('post.delete');
	Route::post('/edit')->uses('PostController@postEditPost')->name('edit');
	Route::get('/account')->uses('UserController@getAccount')->name('account');
	Route::post('saveAccount')->uses('UserController@postSaveAccount')->name('account.save');
	Route::get('userimage/{filename}')->uses('UserController@getUserImage')->name('account.image');
	Route::post('/like')->uses('PostController@postLikePost')->name('like');
}
);
