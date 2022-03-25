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
Auth::routes();

/**
 * can login with Google account
 */
// Googleアカウント選択画面との通信
Route::prefix('login')->name('login.')->group(function () {
  Route::get('/{provider}', 'Auth\LoginController@redirectToProvider')->name('{provider}');
  Route::get('/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('{provider}.callback');
});
// Googleアカウントが当サービス未登録時の登録処理
Route::prefix('register')->name('register.')->group(function () {
  Route::get('/{provider}', 'Auth\RegisterController@showProviderUserRegistrationForm')->name('{provider}');
  Route::post('/{provider}', 'Auth\RegisterController@registerProviderUser')->name('{provider}');
});

/**
 * 一覧画面
 */
Route::get('/', 'ArticleController@index')->name('articles.index');

// middleware('auth') = 直パスでログイン後に使えるようにしたい画面を表示させず、ログイン画面にリダイレクト
Route::resource('/articles', 'ArticleController')->except(['index', 'show'])->middleware('auth');

// 'show' action method のみ追加
Route::resource('/articles', 'ArticleController')->only(['show']);

// 'いいね' 機能
Route::prefix('articles')->name('articles.')->group(function () {
  Route::put('/{article}/like', 'ArticleController@like')->name('like')->middleware('auth');
  Route::delete('/{article}/like', 'ArticleController@unlike')->name('unlike')->middleware('auth');
});

// タグでの一覧表示
Route::get('/tags/{name}', 'TagController@show')->name('tags.show');

/**
 * ユーザ画面
 */
Route::prefix('users')->name('users.')->group(function () {
  Route::get('/{name}', 'UserController@show')->name('show');
  Route::get('/{name}/likes', 'UserController@likes')->name('likes');
  Route::get('/{name}/followings', 'UserController@followings')->name('followings');
  Route::get('/{name}/followers', 'UserController@followers')->name('followers');
  Route::middleware('auth')->group(function () {
    Route::put('/{name}/follow', 'UserController@follow')->name('follow');
    Route::delete('/{name}/follow', 'UserController@unfollow')->name('unfollow');
  });
});
