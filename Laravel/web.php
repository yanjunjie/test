<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//test
Route::get('welcome', 'Front@compactAndWith');

Route::get('foo/bar', function () {
return 'Hello World';
})->name('profile');

Route::get('user/{id?}', function ($id=null) {
    return 'User '.$id;
})->where('id', '[A-Za-z]+');

Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return $postId.''.$commentId;
})->where(['postId' => '[0-9]+', 'comment' => '[a-z]+']);

/*
 * Start production
 */
//Using Anonymous method
Route::get('/', function () {
    return view('website.home');

});

//Using controller methdod
//Route::post('contact/submit', 'submitMsg')->name('store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::view('/welcome', 'welcome', ['name' => 'Taylor']);

Route::get('post/{post}/comments/{comment}', 'Front@test')->name('comment');
Route::get('abouttt', 'Front@test2')->name('aboutt');