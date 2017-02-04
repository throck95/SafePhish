<?php

//Authentication
Route::get('/login','GUIController@generateLogin')->name('login');
Route::post('/login','AuthController@authenticate');
Route::get('/register','GUIController@generateRegister')->name('register');
Route::post('/register','AuthController@create');
Route::get('/auth/check','AuthController@check');
Route::get('/logout','AuthController@logout');
Route::get('/2fa',function() {return view('auth.2fa');})->name('2fa');
Route::post('/2fa','AuthController@twoFactorVerify');
Route::get('/2faresend','AuthController@resend2FA');

//Templates
Route::get('/templates/create','GUIController@generateCreateTemplate');
Route::post('/templates/create/phish','GUIController@createNewPhishTemplate');
Route::get('/templates/all', function() {return view('displays.showAllTemplates');});
Route::get('/templates/{FileName}','GUIController@displayTemplate');

//Results
Route::get('/websitedata/json','DataController@postWebsiteJson');
Route::get('/emaildata/json','DataController@postEmailJson');
Route::get('/reportsdata/json','DataController@postReportsJson');
Route::get('/',function() {return view('displays.dashboard');})->name('authHome');
Route::get('/reports/web','GUIController@generateWebsiteReportForm');
Route::get('/reports/email','GUIController@generateEmailReportForm');
Route::post('/csv/web','DataController@websiteTrackingCSV');
Route::post('/csv/email','DataController@emailTrackingCSV');

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
Route::get('/json/campaigns','DataController@postCampaignsJson');
Route::get('/json/templates','DataController@postTemplatesJson');

Route::get('/print',function() {
    return view('errors.500');
});