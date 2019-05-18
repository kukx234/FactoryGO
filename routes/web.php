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

Route::name('register')->post('home','RegisterController@register');

Route::get('/home', 'HomeController@index')->name('home');

//sign up with productive
Route::name('signUpWithProductiveForm')->get('signUpWithProductive',function(){
    return view('auth.productive');
});
Route::name('signUpProducitve')->post('home','SignUpProductiveController@signUp');

//change password
Route::name('changePasswordForm')->get('changePassword', function(){
    return view('auth.passwords.changePassword');
});
Route::name('password.change')->post('changePassword','PasswordController@changePassword');
