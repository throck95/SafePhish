<?php

//Authentication
Route::get('/login','GUIController@generateLogin')->name('login');
Route::post('/login','AuthController@authenticate');
Route::get('/register','GUIController@generateRegister')->name('register');
Route::post('/register','AuthController@create');
Route::get('/auth/check','AuthController@check');
Route::get('/logout','AuthController@logout')->name('logout');

//Templates
Route::get('/templates/create','GUIController@generateCreateTemplate');
Route::post('/templates/create/phish','GUIController@createNewPhishTemplate');
Route::get('/templates/display/all','GUIController@generateDisplayTemplatesForm');

//Results
Route::get('/websitedata/json','DataController@postWebsiteJson');
Route::get('/emaildata/json','DataController@postEmailJson');
Route::get('/reportsdata/json','DataController@postReportsJson');
Route::get('/','GUIController@displayResults')->name('authHome');

//Errors
Route::get('/unauthorized','ErrorController@e401')->name('e401');

//Projects

//Emails
Route::get('/email/generate','GUIController@generatePhishingEmailForm');
Route::post('email/send','EmailController@sendEmail')->name('sendEmail');

//MLU
Route::get('/mailinglist/create/user','GUIController@generateNewMailingListUserForm')->name('mailingListUser');
Route::post('/mailinglist/create/user','GUIController@createNewMailingListUser')->name('postMailingListUser');