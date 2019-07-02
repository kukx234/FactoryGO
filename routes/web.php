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
Route::name('signUpProducitve')->post('home','ProductiveUsersController@signUp');

//change password
Route::name('changePasswordForm')->get('changePassword', function(){
    return view('auth.passwords.changePassword');
})->middleware('auth');
Route::name('password.change')->post('changePassword','PasswordController@changePassword');



//administration
Route::middleware(['auth','role:1'])->group(function(){
    //add user
    Route::name('addUser')->get('addUser','ProductiveUsersController@addUserList');
    Route::name('search')->post('addUser', 'ProductiveUsersController@find');
    Route::name('saveNewUser')->get('save/{id}', 'ProductiveUsersController@saveNewUser');

    //Edit user
    Route::name('editUser')->get('editUser/{id}', 'UsersController@edit');
    Route::name('updateUser')->patch('editUser/{id}', 'UsersController@update');

    Route::name('allUsers')->get('allUsers', 'UsersController@showAllUsers');
});

Route::middleware(['auth', 'role:1,2'])->group(function(){
    //all users vacations requests
    Route::name('allVacationRequests')->get('vacationRequests', 'VacationController@allVacationRequests');
    Route::name('requestDetails')->get('details/{id}', 'VacationController@requestDetails');
    Route::name('approveRequest')->post('vacation/{id}', 'VacationController@approve');
});

//my vacations requests
Route::name('newRequestForm')->get('newRequest', function(){
    return view('vacations.newRequest');
});
Route::name('newRequest')->post('newRequest','VacationController@create');
Route::name('pendingRequests')->get('pendingRequests','VacationController@showMyRequests');
Route::name('deleteRequest')->get('delete/{id}','VacationController@deleteRequest');


    

