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
Route::get('/campaign/create','GUIController@createCampaignForm')->name('createCampaign');
Route::post('/campaign/create','GUIController@createCampaign');

//Emails
Route::get('/email/generate','GUIController@generatePhishingEmailForm')->name('generatePhish');
Route::post('email/send','EmailController@sendPhishingEmail')->name('sendPhish');

//MLU
Route::get('/mailinglist/create/user','GUIController@generateNewMailingListUserForm')->name('mailingListUser');
Route::get('/mailinglist/create/group','GUIController@generateNewMailingListDepartmentForm')->name('mailingListDepartment');
Route::post('/mailinglist/create/user','GUIController@createNewMailingListUser')->name('postMailingListUser');
Route::post('/mailinglist/create/group','GUIController@createNewMailingListDepartment')->name('postMailingListDepartment');
Route::get('/mailinglist/update/user/{Id}','GUIController@generateUpdateMailingListUserForm')->name('updateMailingListUser');
Route::post('/mailinglist/update/user/{Id}','GUIController@updateMailingListUser')->name('postUpdateMailingListUser');
Route::get('/mailinglist/update/group/{Id}','GUIController@generateUpdateMLUDForm')->name('updateMailingListDepartment');
Route::post('/mailinglist/update/group/{Id}','GUIController@updateMailingListDepartment')->name('postUpdateMailingListDepartment');
Route::get('/mailinglist/users','GUIController@displayMLUs')->name('mlu');
Route::get('/mailinglist/groups','GUIController@displayMLUDs')->name('mlud');

//Users
Route::get('/user/update','GUIController@accountManagementForm')->name('accountManagement');
Route::post('/user/update','GUIController@updateUserAccountManagement')->name('updateUser');
Route::get('/user/update/{Id}','GUIController@displayUser');
Route::post('/user/update/{Id}','GUIController@updateUser')->name('adminUpdateUser');
Route::get('/users','GUIController@displayUsers')->name('users');

//Json
Route::get('/json/campaigns','JsonController@postCampaignsJson');
Route::get('/json/templates','JsonController@postTemplatesJson');
Route::get('/json/mlu','JsonController@postMLUJson');
Route::get('/json/mlud','JsonController@postMLUDJson');
Route::get('/json/users','JsonController@postUsersJson');

//Webbug
Route::get('/account={Id}/emaillogo.png','WebbugController@createAndReturnWebbug');

//Email Links
Route::get('/account={Id}/breach/password_reset','LinksController@disclosePhishingEmail');
Route::get('/account={Id}/breach/contact_us','LinksController@disclosePhishingEmail');
Route::get('/account={Id}/policy_changes','LinksController@disclosePhishingEmail');
Route::get('/deals/{Id}','LinksController@disclosePhishingEmail');
Route::get('/account={Id}/irs.gov','LinksController@disclosePhishingEmail');

//Images
Route::get('/images/black_friday.png','ImagesController@displayBlackFridayImage');
Route::get('/images/irs_logo.jpg','ImagesController@displayIRSLogo');