<?php

//Auth
Route::get('/','GUIController@dashboard')->name('authHome');
Route::get('/login','AuthController@generateLogin')->name('login');
Route::post('/login','AuthController@authenticate');
Route::get('/register','AuthController@generateRegister')->name('register');
Route::post('/register','AuthController@create');
Route::get('/logout','AuthController@logout');

//2FA
Route::get('/2fa','AuthController@generateTwoFactorPage')->name('2fa');
Route::post('/2fa','AuthController@twoFactorVerify');
Route::get('/2faresend','AuthController@resend2FA');

//Templates
Route::get('/templates/create','GUIController@generateCreateTemplate');
Route::post('/templates/create/phish','GUIController@createNewPhishTemplate');
Route::get('/templates','GUIController@displayTemplates')->name('templates');
Route::get('/templates/{FileName}','GUIController@displayTemplate');

//CSV
Route::get('/reports/web','GUIController@generateWebsiteReportForm');
Route::get('/reports/email','GUIController@generateEmailReportForm');
Route::post('/csv/web','CSVController@generateWebsiteReport');
Route::post('/csv/email','CSVController@generateEmailReport');

//Errors
Route::get('/unauthorized','ErrorController@e401')->name('e401');
Route::get('/404','ErrorController@e404')->name('e404');

//Campaigns
Route::get('/campaigns','GUIController@displayCampaigns')->name('campaigns');
Route::get('/campaigns/{Id}','GUIController@displayCampaign');
Route::post('/campaigns/update/{Id}','GUIController@updateCampaign');

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

//Json
Route::get('/json/campaigns','JsonController@postCampaignsJson');
Route::get('/json/templates','JsonController@postTemplatesJson');

Route::get('/print',function() {
    return view('errors.500');
});