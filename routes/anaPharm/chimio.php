<?php
Route::get('/addProtocole', 'Chimio\MaladieController@addProtocoole')->middleware('auth');


//========= Maladie ================
Route::resource('chimio/listMaladie', 'Chimio\MaladieController')->middleware('auth');
Route::post('chimio/listMaladie', 'Chimio\MaladieController@store')->name('addMaladie')->middleware('auth');
Route::post('chimio/listMaladie/{id}', 'Chimio\MaladieController@destroy')->middleware('auth');
Route::post('chimio/listMaladie/edit/{id}', 'Chimio\MaladieController@edit')->name('modMaladie')->middleware('auth');
Route::post('chimio/listMaladie/info/{id}', 'Chimio\MaladieController@getDetailPathologie')->middleware('auth');
Route::post('chimio/listMaladie/info/tag/{id}', 'Chimio\MaladieController@getDetailPathologieTag')->middleware('auth');
Route::post('/maladie', 'Chimio\MaladieController@getPathologieNom')->middleware('auth');
Route::post('/protocolesPathologie', 'Chimio\MaladieController@getProtocolePathologie')->middleware('auth');
Route::get('/tags', 'Chimio\MaladieController@getTag')->middleware('auth')->name('tag');

// ================ protocole ================
Route::resource('chimio/protocole', 'Chimio\ProtocoleController')->middleware('auth');
Route::get('chimio/listProtocole', 'Chimio\ProtocoleController@show')->middleware('auth')->name('listProtocole');
Route::get('chimio/detailProtocole/{id}', 'Chimio\ProtocoleController@showDetail')->middleware('auth')->name('detailProtocole');
Route::get('chimio/addProtocole', 'Chimio\ProtocoleController@add')->middleware('auth')->name('addProtocole');
Route::post('chimio/protocole/{id}', 'Chimio\ProtocoleController@destroy')->middleware('auth');

// ================ Traitement ================
//Route::resource('chimio/traitement','Chimio\TraitementController')->middleware('auth');
Route::post('/chimio/addTraitement', 'Chimio\TraitementController@store')->middleware('auth')->name('addTraitement');
Route::get('/chimio/traitement/{id}', 'Chimio\TraitementController@showAdd')->middleware('auth')->name('po');
Route::post('/getRemarquesProtocole/{id}', 'Chimio\ProtocoleController@findById')->middleware('auth');
Route::get('chimio/traitement/delete/{id}', 'Chimio\TraitementController@destroy')->middleware('auth');
Route::get('chimio/traitement/arrete/{id}', 'Chimio\TraitementController@arrete')->middleware('auth');
Route::get('/countCure/{id}', 'Chimio\TraitementController@countCure')->middleware('auth');
Route::post('/addCure', 'Chimio\TraitementController@addCure')->middleware('auth')->name('addCure');
Route::get('/getDateCure/{id}', 'Chimio\TraitementController@getDateCure')->middleware('auth')->name('fff');

//================prescription ================
Route::get('/prescriptionDelete/{id}', 'Chimio\PrescriptionController@destroy')->middleware('auth')->name('dddd');
Route::get('/chimio/prescription/{id}', 'Chimio\PrescriptionController@show')->middleware('auth')->name('pres');
Route::post('/chimio/prescription/edit', 'Chimio\PrescriptionController@edit')->middleware('auth')->name('edit');
Route::get('/chimio/sequence/arrete/{id}', 'Chimio\PrescriptionController@arreter')->middleware('auth');
Route::get('/dispenser/', 'Chimio\PrescriptionController@dis')->middleware('auth');
Route::get('/encours/', 'Chimio\PrescriptionController@encours')->middleware('auth');

//================preparation ================
Route::resource('chimio/preparation', 'Chimio\PreparationController')->middleware('auth');


//================parametres ================
Route::get('chimio/parametres', 'Chimio\UnitePosologieController@index')->middleware('auth')->name('para');
Route::post('chimio/activer', 'Chimio\UnitePosologieController@activerFormule')->middleware('auth')->name('activerFormule');
Route::post('chimio/addformule', 'Chimio\UnitePosologieController@addFormule')->middleware('auth')->name('addFormule');
Route::post('chimio/addUnite', 'Chimio\UnitePosologieController@addUnite')->middleware('auth')->name('addunite');
Route::post('chimio/para', 'Chimio\UnitePosologieController@addpara')->middleware('auth')->name('addpara');
Route::post('chimio/deleteunite/{id}', 'Chimio\UnitePosologieController@deleteunite')->middleware('auth')->name('deleteunite');



Route::get('/blank', 'Chimio\MaladieController@blank')->middleware('auth');
