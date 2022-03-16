<?php
/*BDDM APP*/
Route::get('/','bddm_app\bddmController@showMedicaments')->name('medicaments.noms-commerciale');
// Route::get('/medicaments','bddm_app\bddmController@showMedicaments')->name('medicaments.noms-commerciale');
Route::post('/medicaments','bddm_app\bddmController@search')->name('medicaments.search');
Route::get('/medicaments_ajax/','bddm_app\bddmController@showMedicamentsAjax')->name('medicaments.noms1-commerciale');
Route::get('/medicaments/alphabet/{name}','bddm_app\bddmController@showAlphabetMedicaments');
Route::get('/classes','bddm_app\bddmController@showClasses')->name('medicaments.classes');
Route::get('/classes/{id}','bddm_app\bddmController@showSubClasses');
Route::get('/classes-pharmaceutiques','bddm_app\bddmController@showPharmClasses');
Route::get('/classes-pharmaceutiques/{id}','bddm_app\bddmController@showSubPharmClasses');
Route::get('/substances/','bddm_app\bddmController@showSubstances')->name('medicaments.substances');
Route::get('/substances/{idSAC}&&{rd}','bddm_app\bddmController@getSacMedicaments');
Route::get('/indications/','bddm_app\bddmController@showIndications')->name('medicaments.indications');
Route::get('/indications/{id}','bddm_app\bddmController@showSpIndication');
Route::get('/medicaments/{medicament}','bddm_app\bddmController@getMonographie')->name('medicaments.monographie');
Route::get('/generatePages','bddm_app\bddmController@generatePages');
Route::get("/api/medicament/{phrase}&&type={type_search}" , 'bddm_app\bddmController@searchMedicament');
Route::get('/bddm_report', 'ReportController@bddmReport');
// Route::post('/medicaments/{medicament}','bddm_app\bddmController@getMonographie')->name('medicaments.monographie');
/*!End BDDM APP!*/
?>