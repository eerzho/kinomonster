<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('main');
//}) ->name('main');

//Route::resource('/', 'HomeController')
//    ->except('store')
//    ->names('home');
Auth::routes();

Route::get('/', 'HomeController@index')->name('home.index');
Route::get('/show/{slug}', 'HomeController@show')->name('home.show');
Route::get('/list/{id}', 'HomeController@list')->name('home.list');
Route::get('/search', 'HomeController@search')->name('home.search');
//Route::get('/profile', 'HomeController@profile')->name('home.profile');
Route::resource('profile', 'ProfileController')->only('index', 'destroy')->names('profile');
Route::patch('profile/change/password/{id}', 'ProfileController@updatePassword')->name('profile.change.password');
Route::patch('profile/change/name/{id}', 'ProfileController@updateName')->name('profile.change.name');
$groupData = [
    'namespace' => 'Admin',
    'prefix' => 'admin',
    ];
Route::group($groupData, function () {
    Route::get('post/restore/{id}', 'PostController@restore')->name('admin.restore');
    Route::get('post/trash','PostController@trash')->name('admin.trash');
    Route::get('user','UserController@index')->name('admin.user');
    Route::delete('user/destroy/{id}','UserController@destroy')->name('admin.user.destroy');
    Route::resource('post', 'PostController')
        ->names('admin');

});
Route::post('/comment/{post_id}', 'CommentController@store')->name('user.comment.store');
Route::delete('admin/comment/{comment_id}', 'CommentController@deleteComment')->name('admin.comment.destroy');
Route::post('/user/favorite/add/{post_id}', 'FavoriteController@add')->name('user.favorite.add');
Route::get('/user/favorite/show', 'FavoriteController@show')->name('user.favorite.show');
Route::delete('user/favorite/delete/{post_id}', 'FavoriteController@delete')->name('user.favorite.delete');
