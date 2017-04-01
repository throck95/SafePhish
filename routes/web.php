<?php

//Auth
Route::get('/','GetController@dashboard')->name('authHome');
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
Route::get('/templates','GetController@displayTemplates')->name('templates');
Route::get('/templates/{fileName}','GetController@displayTemplate');
Route::get('/template/create','GetController@createTemplate');
Route::post('/template/create','PostController@createTemplate')->name('createTemplate');

//CSV
Route::get('/reports/web','GetController@generateWebsiteReportForm');
Route::get('/reports/email','GetController@generateEmailReportForm');
Route::post('/csv/web','CSVController@generateWebsiteReport');
Route::post('/csv/email','CSVController@generateEmailReport');

//Campaigns
Route::get('/campaigns','GetController@displayCampaigns')->name('campaigns');
Route::get('/campaigns/{id}','GetController@displayCampaign');
Route::post('/campaigns/update/{id}','PostController@updateCampaign');
Route::get('/campaign/create','GetController@createCampaignForm');
Route::post('/campaign/create','PostController@createCampaign')->name('createCampaign');

//Emails
Route::get('/campaign/start','GetController@displayPhishingEmailForm')->name('generatePhish');
Route::post('/campaign/send','EmailController@sendPhishingEmail')->name('sendPhish');

//MLU
Route::get('/mailinglist/create/user','GetController@createMailingListUserForm');
Route::get('/mailinglist/create/group','GetController@createMailingListGroupForm');
Route::post('/mailinglist/create/user','PostController@createMailingListUser')->name('postMailingListUser');
Route::post('/mailinglist/create/group','PostController@createMailingListGroup')->name('postMailingListGroup');
Route::get('/mailinglist/update/user/{id}','GetController@updateMailingListUserForm');
Route::get('/mailinglist/update/group/{id}','GetController@updateMailingListGroupsForm');
Route::post('/mailinglist/update/user/{id}','PostController@updateMailingListUser')->name('postUpdateMailingListUser');
Route::post('/mailinglist/update/group/{id}','PostController@updateMailingListGroup')->name('postUpdateMailingListDepartment');
Route::get('/mailinglist/users','GetController@displayMailingListUsers')->name('mailingListUser');
Route::get('/mailinglist/groups','GetController@displayMailingListGroups')->name('mailingListGroup');

//Users
Route::get('/user/update','GetController@accountManagementForm');
Route::post('/user/update','PostController@updateUserAccountManagement')->name('updateUser');
Route::get('/user/update/{id}','GetController@displayUser');
Route::post('/user/update/{id}','PostController@updateUser')->name('adminUpdateUser');
Route::get('/users','GetController@displayUsers')->name('users');

//Json
Route::get('/json/campaigns','JsonController@postCampaignsJson');
Route::get('/json/templates','JsonController@postTemplatesJson');
Route::get('/json/mlu','JsonController@postMLUJson');
Route::get('/json/groups','JsonController@postGroupsJson');
Route::get('/json/users','JsonController@postUsersJson');

//Webbug
Route::get('/account={id}/emaillogo.png','WebbugController@createAndReturnWebbug');

//Email Links
Route::get('/account={id}/breach/password_reset','LinksController@disclosePhishingEmail');
Route::get('/account={id}/breach/contact_us','LinksController@disclosePhishingEmail');
Route::get('/account={id}/policy_changes','LinksController@disclosePhishingEmail');
Route::get('/deals/{id}','LinksController@disclosePhishingEmail');
Route::get('/netflix/{id}','LinksController@disclosePhishingEmail');
Route::get('/account={id}/irs.gov','LinksController@disclosePhishingEmail');

//Images
Route::get('/images/black_friday.png','ImagesController@displayBlackFridayImage');
Route::get('/images/free_netflix.png','ImagesController@displayFreeNetflixImage');
Route::get('/images/irs_logo.jpg','ImagesController@displayIRSLogo');

//CampaignEmailAddresses
Route::get('/campaign/emails','GetController@createCampaignEmailAddress')->name('createCampaignEmails');
Route::post('/campaign/emails','PostController@createCampaignEmailAddress');

//Documentation
Route::get('/documentation','GetController@documentation');

//Company
Route::get('/company/create','GetController@createCompanyForm');
Route::post('/company/create','PostController@createCompany')->name('createCompany');