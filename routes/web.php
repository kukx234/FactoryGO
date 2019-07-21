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

Route::middleware('userStatus:Active')->group(function(){
    
    //administration
    Route::middleware(['auth','role:Admin'])->group(function(){
        //add user
        Route::name('addUser')->get('addUser','ProductiveUsersController@addUserList');
        Route::name('search')->post('addUser', 'ProductiveUsersController@find');
        Route::name('saveNewUser')->get('save/{id}', 'ProductiveUsersController@saveNewUser');

        //Edit user
        Route::name('editUser')->get('editUser/{id}', 'UsersController@showEditForm');
        Route::name('updateUser')->patch('editUser/{id}', 'UsersController@update');
    });

    Route::middleware(['auth', 'role:Admin,Approver'])->group(function(){
        //all users vacations requests
        Route::name('allVacationRequests')->get('vacationRequests', 'VacationController@allVacationRequests');
        Route::name('requestDetails')->get('details/{id}', 'VacationController@requestDetails');
        Route::name('approveRequest')->post('vacation/{id}', 'VacationController@approve');
        Route::name('waitingOtherApprovers')->get('requestsForOtherApprover', 'VacationController@waitingOtherApprovers');
    
        //all finished requests
        Route::name('allFinishedRequests')->get('allFinishedRequests', 'VacationController@allFinishedRequests');
        Route::name('allFinishedRequestDetails')->get('allFinishedRequestDetails/{id}', 'VacationController@allFinishedRequestDetails');
        
        //all users
        Route::name('allUsers')->get('allUsers', 'UsersController@showAllUsers');
        Route::name('userInfo')->get('userInfo/{id}', 'UsersController@userInfo');
    });

    //my vacations requests

    Route::middleware('auth')->group(function(){
        //My Requests
        Route::name('newRequestForm')->get('newRequest', function(){
            return view('vacations.newRequest');
        });
        Route::name('newRequest')->post('newRequest','VacationController@create');
        Route::name('pendingRequests')->get('pendingRequests','VacationController@showMyRequests');
        Route::name('deleteRequest')->get('delete/{id}','VacationController@deleteRequest');
        Route::name('myFinishedRequests')->get('myFinishedRequests', 'VacationController@myFinishedRequests');
        Route::name('myFinishedRequestDetails')->get('myFinishedRequestDetails/{id}', 'VacationController@myFinishedRequestDetails');
        
    });


});



    

