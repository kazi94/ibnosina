<?php
//*******************Divers*******************************
Route::resource('/appointement', 'AppointementController')->middleware('auth');
Route::post('/appointement/storePatient', 'AppointementController@storePatient')->middleware('auth');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/help', 'ConfigController@help')->name('help');
Route::get('/admin/settings', 'ConfigController@settings')->middleware('auth');
//

Route::get('/app', 'ConfigController@getApp');
Route::get('/bugs_report', 'ReportController@bugs');
Route::post('bugs_report', 'ReportController@reportBug')->name('report_bug');
//
require_once "admin.php";
//
require_once "patient.php";
//
require_once "export.php";
//
require_once "chimio.php";
//
require_once "chat.php";
