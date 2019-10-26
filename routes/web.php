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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function () {
    //photo
    Route::get('/photos', 'ImageController@index')->name('photos');
    Route::get('/photos-add', 'ImageController@create')->name('photos.add');
    Route::post('/photos-add', 'ImageController@store')->name('photos.store');
    Route::get('/photos-delete', 'ImageController@destroy')->name('photos.delete');
    Route::get('/photos-setprofile', 'ImageController@setProfile')->name('photos.setProfile');

    //user
    Route::get('/profile', 'UserController@profile')->name('profile');

    //friends
    Route::get('/friends', 'FriendController@index')->name('friend.index');

    Route::get('/friends-add/{username}', 'FriendController@addFriend')->name('friends.add');
    Route::get('/friends-accept/{username}', 'FriendController@acceptFriendReq')->name('friends.accept');
    Route::get('/friends-reject/{username}', 'FriendController@rejectFriendReq')->name('friends.reject');

    //message
//    Route::get('/messages', 'MessageController@index')->name('messages');
    Route::get('/messages-send/{user}', 'MessageController@createMessage')->name('message.create');
    Route::post('/messages-send/{user}', 'MessageController@sendMessage')->name('message.send');

    //notification
    Route::get('mark-as-read', function() {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('markRead');
});

//users
Route::get('/people', 'UserController@index')->name('people');
