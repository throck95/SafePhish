<?php

//Authentication
Route::get('/login','GUIController@generateLogin')->name('login');
Route::post('/login','AuthController@authenticate');
Route::get('/register','GUIController@generateRegister')->name('register');
Route::post('/register','AuthController@create');
Route::get('/auth/check','AuthController@check');
Route::get('/logout','AuthController@logout')->name('logout');
Route::get('/2fa',function() {return view('auth.2fa');})->name('2fa');
Route::post('/2fa','AuthController@twoFactorVerify');

//Templates
Route::get('/templates/create','GUIController@generateCreateTemplate');
Route::post('/templates/create/phish','GUIController@createNewPhishTemplate');
Route::get('/templates/display/all','GUIController@generateDisplayTemplatesForm');

//Results
Route::get('/websitedata/json','DataController@postWebsiteJson');
Route::get('/emaildata/json','DataController@postEmailJson');
Route::get('/reportsdata/json','DataController@postReportsJson');
Route::get('/','GUIController@displayResults')->name('authHome');
Route::post('/websitecsv','DataController@websiteTrackingCSV');
Route::post('/emailcsv','DataController@emailTrackingCSV');

//Errors
Route::get('/unauthorized','ErrorController@e401')->name('e401');
Route::get('/404','ErrorController@e404')->name('e404');

//Projects

//Emails
Route::get('/email/generate','GUIController@generatePhishingEmailForm');
Route::post('email/send','EmailController@sendEmail')->name('sendEmail');

//MLU
Route::get('/mailinglist/create','GUIController@generateNewMailingListUserForm')->name('mailingListUser');
Route::post('/mailinglist/create','GUIController@createNewMailingListUser')->name('postMailingListUser');
Route::get('/mailinglist/update','GUIController@generateUpdateMailingListUserForm')->name('updateMailingListUser');
Route::post('/mailinglist/update','GUIController@updateMailingListUser')->name('postUpdateMailingListUser');

//Users
Route::post('/updateUser','GUIController@updateUser')->name('updateUser');

Route::get('/print',function() {
    return view('auth.2fa');
});