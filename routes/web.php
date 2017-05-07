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
//id and slug patterns
Route::pattern('id', '[0-9]+');
Route::pattern('slug', '[a-z0-9-]+');
Route::pattern('group', '^(?!.*sendcode|.*verifycode|.*success).*$');

//Auth Routes and verification
Auth::routes();
Route::post('verify-registration', 'Auth\RegisterController@smsAuth');

Route::get('verify-registration', function () {
    $result = '';
    return view('auth.verify', compact('result'));
});

//Routes for joining a group
//Search Home
Route::get('/', function () {
    return view('search.search');
});
//Display search results
Route::get('/search', 'GroupSearchController@index');
//Get group sign-up form
Route::get('join/{group}', 'GroupJoinController@getFrom')->name('join.group');
//Submit form data
Route::post('join/sendcode/{id}', 'GroupJoinController@sendCode');
//Enter verification code
Route::get('/join/verifycode', function () {
    $result = '';
    return view('sms.verify', compact('result'));
});
Route::post('join/verifycode', 'GroupJoinController@smsVerify');
//Redirect to success
Route::get('/join/success', function () {
    return view('sms.success');
})->name('join.success');


Route::group(['middleware' => 'auth'], function () {

    //Get the form
    Route::get('my-groups/new', function () {
        return view('groups.create-group');
    });
    //Create the group and redirect
    Route::post('my-groups/new', 'GroupController@store');
    //Perform actions on the new group
    //View the group
    Route::get('my-groups/view/{group}', 'GroupController@show')->name('group.new');
    //Add a user
    Route::post('my-groups/add-user/{group}', 'GroupsUserController@store');
    //Send a message
    Route::post('my-groups/send-message/{group}', 'GroupSmsController@getGroupList');
    //Sent
    Route::get('my-groups/send-message/{group}/sent', function () {
        return view('sms.group-success');
    });
    //Delete a group
    Route::delete('my-groups/delete/{group}', 'GroupController@destroy');

    //Perform actions on a group user
    //View user's info
    Route::get('my-groups/user/update/{groupsUser}', 'GroupsUserController@index')->name('user.update');
    //Update user's info
    Route::post('my-groups/user/edit/{groupsUser}', 'GroupsUserController@update');
    //Approve User
    Route::post('my-groups/user/approve/{groupsUser}', 'GroupsUserController@approve');
    //Delete User
    Route::delete('my-groups/user/delete/{groupsUser}', 'GroupsUserController@destroy');

    //Perform Actions on all groups
    //View groups
    Route::get('/dashboard', 'GroupController@index');
    //View group affiliations
    //Show the groups a user belongs to
    Route::get('affiliations', 'GroupController@affiliations');
    //Delete User Affiliation
    Route::delete('affilition/delete/{groupsUser}', 'GroupsUserController@destroyAffiliation');

    //Profile Routes
    //get Profile
    Route::get('profile', 'UserController@index');
    //Update user's profile info
    Route::post('profile/update', 'UserController@update');
    //get verify code form
    Route::get('profile/update/verifycode', 'UserController@verify');
    //verify code
    Route::post('profile/update/verifycode', 'UserController@smsVerify');
    //Delete user account
    Route::delete('profile/delete', 'UserController@destroy');
});

//the route for twilio isn't protected with CSRF since it uses twilio
//authentication process and the requests will not work with CSRF enabled
Route::post('twilio/sms', 'SmsController@smsIn')->middleware('sms');
