<?php
Route::post('/addAnnotation', 'User\AnnotationController@store')->name('addAnnotation');
Route::get('/sms/{patient_id}', 'Admin\NotificationController@send')->middleware('auth')->name('send');


Route::get('getQuestions/{questionnaireId}', 'Admin\QuestionController@getQuestions')->middleware('auth');;
Route::get('/patient/regleSuivPatient/{patient_id}&{regle_id}', 'User\RegleSuivPatientController@vu')->name('regleSuivPatient.vu')->middleware('can:is-admin,analyse_suiv');
//Route::get('/admin/regle/{regle_id}/edits','Admin\RegleController@edits')->middleware('can:is-admin,produit');

Route::get('/element/all', 'Admin\ElementController@getAll')->middleware('auth');
Route::get('/act/all', 'User\Act_medicaleController@getAll')->middleware('auth');
//
Route::get('/patient/list-view', 'User\PatientController@showView')->middleware('auth');
Route::get('/api/patient/getPatient/{patient_id}', 'User\PatientController@getPatient')->middleware('auth');
Route::post('/patient/message', 'User\PatientController@storeMessage')->middleware('auth');
Route::get('/patient/{id}&{pr_risque}', 'User\PatientController@intervenir')->name('patient.intervenir')->middleware('auth');
Route::get('/patient/{id}/exit', 'User\PatientController@exit')->name('patient.exit')->middleware('auth');
Route::get('/patient/{id}/print', 'User\PatientController@print_conciliation')->name('patient.print_conciliation')->middleware('auth');
// Route::get('/patient/{id}/analysePerso' , 'User\MoteurInferenceController@pre_analyser')->middleware('auth');

Route::get('/patient/{pr_risque}/faireEdu', 'User\PrescriptionController@faireEducation')->name('patient.FaireEducation')->middleware('can:analyse_therap');
Route::resource('/patient', 'User\PatientController')->middleware('auth');
Route::get('/chart/edit/{id}', 'User\ChartController@edit')->name('chart.edit')->middleware('auth');
Route::post('/graphe/', 'User\ChartController@passInfo')->name('graphe')->middleware('auth');
Route::get('/ajax/{id}/{dashboard}', 'User\ChartController@ajax')->name('ajax')->middleware('auth');

Route::match(['put', 'patch', 'post', 'get'], '/hospitalisation/{id}/edit', 'User\HospitalisationController@update');
Route::match(['put', 'patch', 'post', 'get'], '/hospitalisation/getHospitalisation/{id}', 'User\HospitalisationController@getHospitalisation');
Route::post('/hospitalisation/getHospitalisation/{id}', 'User\HospitalisationController@getHospitalisation')->middleware('auth');
Route::resource('/hospitalisation', 'User\HospitalisationController')->middleware('auth');
Route::get('/hospitalisation/{patient_id}/print', 'User\HospitalisationController@showsho')->name('hospitalisation.shows')->middleware('auth');
//
Route::resource('/patient/traitement_chronique', 'User\TraitementchroniqueController')->middleware('auth');
Route::get('/patient/traitement_chronique/get-last-state/{id}', 'User\TraitementchroniqueController@getLastState')->middleware('auth');
Route::put('/patient/traitement_chronique/update-state/{id}', 'User\TraitementchroniqueController@updateState')->middleware('auth');
Route::delete('/patient/traitement/{id}', 'User\TraitementChroniqueController@destroy_tmp')->middleware('auth')->name('traitement.destroy_tmp');
Route::post('/patient/traitement/{id}', 'User\TraitementChroniqueController@confirm')->middleware('auth')->name('traitement.confirm');
Route::post('/getTraitement', 'User\TraitementchroniqueController@getHisTraitement')->middleware('auth');
//
Route::resource('/patient/automedication', 'User\AutomedicationController')->middleware('auth');
Route::get('/patient/automedication/get-last-state/{id}', 'User\AutomedicationController@getLastState')->middleware('auth');
Route::put('/patient/automedication/update-state/{id}', 'User\AutomedicationController@updateState')->middleware('auth');
Route::delete('/patient/automedication/{id}', 'User\AutomedicationController@destroy_tmp')->middleware('auth')->name('automedication.destroy_tmp');
Route::post('/patient/automedication/{id}', 'User\AutomedicationController@confirm')->middleware('auth')->name('automedication.confirm');
Route::post('/getAutomedication', 'User\AutomedicationController@getHisAutomedication')->middleware('auth');
//
Route::resource('/patient/phytotherapie', 'User\PhytotherapieController')->middleware('auth');
Route::resource('/patient/operation', 'User\Operation_chirugicaleController')->middleware('auth');
Route::match(['put', 'patch', 'post', 'get'], '/operation/getOperation/{id}', 'User\Operation_chirugicaleController@getOperation');
Route::match(['put', 'patch', 'post', 'get'], '/operation/{id}/edit', 'User\Operation_chirugicaleController@update');
//
Route::resource('/patient/act', 'User\Act_medicaleController')->middleware('auth');
Route::post('/patient/acte/store', 'User\Act_medicale_patientController@store')->name('actestore')->middleware('auth');
Route::delete('/acte/{id}', 'User\Act_medicale_patientController@destory')->name('actee.delete')->middleware('auth');
Route::match(['put', 'patch', 'post', 'get'], '/act/get/{id}', 'User\Act_medicaleController@getAct');
Route::match(['put', 'patch', 'post', 'get'], '/acts/getAct/{id}', 'User\Act_medicale_patientController@getAct');
Route::match(['put', 'patch', 'post', 'get'], '/acts/{id}/edit', 'User\Act_medicale_patientController@update');
Route::match(['put', 'patch', 'post', 'get'], '/act/{id}/edit', 'User\Act_medicaleController@update');
//
Route::resource('/patient/travail', 'User\TravailController')->middleware('auth');
Route::match(['put', 'patch', 'post', 'get'], '/travail/get/{id}', 'User\TravailController@getTravail');
Route::match(['put', 'patch', 'post', 'get'], '/travail/{id}/edit', 'User\TravailController@update');
//
Route::resource('/patient/education_therapeutique', 'User\EducationtherapeutiqueController')->middleware('auth');
Route::get('/admin/education/{id}/details', 'Admin\EducationController@show')->middleware('can:is-admin,editeur_regle');

//
Route::resource('/patient/questionnaire', 'User\QuestionnaireController')->middleware('auth');
Route::delete('/patient/questionnaire/destroy/{id}&{patient_id}&{user_id}&{date_questionnaire}', 'User\QuestionnaireController@destroys')->middleware('auth');
//
Route::get('/patient/prescription/ligneprescription/{line_id}&&{isChecked}', 'User\LignePrescriptionController@updateInjectedValue')->middleware('auth');
Route::resource('/patient/prescription', 'User\PrescriptionController')->middleware('auth');
Route::post('/prescription/store2', 'User\PrescriptionController@store')->name('prescriptionstore2')->middleware('auth');
//
Route::resource('/patient/education_therapeutique', 'User\EducationtherapeutiqueController')->middleware('auth');
//
Route::resource('/patient/questionnairePatient', 'User\QuestionnaireController')->middleware('auth');
Route::delete('/patient/questionnairePatient/destroy/{id}&{patient_id}&{user_id}&{date_questionnaire}', 'User\QuestionnaireController@destroys')->middleware('auth');
//
Route::resource('/patient/prescription', 'User\PrescriptionController')->middleware('auth');
Route::get('/patient/prescription/{patient_id}${id}/print', 'User\PrescriptionController@shows')->name('prescription.shows')->middleware('auth');
//
Route::resource('/patient/consultation', 'User\ConsultationController')->middleware('auth');
Route::delete('/patient/consultation/destroy/{id}&{patient_id}', 'User\ConsultationController@destroys')->middleware('auth');
Route::get('/patient/consultation/{patient_id}${id}/print_consultation', 'User\ConsultationController@shows')->name('consultation.shows')->middleware('auth');
Route::get('/patient/consultation/{patient_id}${id}/print_orientation', 'User\ConsultationController@shows1')->name('consultation.shows1')->middleware('auth');
Route::get('/patient/consultation/{patient_id}${id}/print_certificat', 'User\ConsultationController@shows2')->name('consultation.shows2')->middleware('auth');
Route::get('/patient/consultation/{patient_id}${id}/print_act', 'User\Act_medicale_patientController@shows')->name('acts.shows')->middleware('auth');
//
Route::resource('/admin/question', 'User\QuestionController')->middleware('auth');
Route::resource('patient/bilan', 'User\BilanController')->middleware('auth');
Route::patch('/patient/bilan/element/{id}', 'User\BilanController@updateElement')->middleware('auth');
Route::get('/patient/element/get-demande/{id}', 'User\BilanController@getDemande')->middleware('auth');
Route::get('/patient/element/get-element/{id}', 'User\BilanController@getElement')->middleware('auth');
//
Route::post('/getElement', 'Admin\ElementController@avoir')->middleware('auth');
Route::post('/admin/element/{phrase}', 'Admin\ElementController@getElement')->middleware('auth');
//
Route::post('/patient/produit/{phrase}', 'Admin\ProduitalimentaireController@getProduit')->middleware('auth');
Route::post('/patient/produit1/{phrase}', 'Admin\ProduitalimentaireController@getProduit1')->middleware('auth');
Route::post('/patient/produit_ar/{phrase}', 'Admin\ProduitalimentaireController@getProduit_ar')->middleware('auth');
//
Route::post('/medicament', 'User\MedicamentController@getMedicament')->middleware('auth');
Route::post('/medicamentDci', 'User\MedicamentController@getMedicamentDci')->middleware('auth');
Route::post('/actnom', 'User\Act_medicaleController@getActe')->middleware('auth');
Route::post('/medicamentSpUnit', 'User\MedicamentController@getMedicamentSpUnit')->middleware('auth');
//Route::post('/medicamentSp','User\MedicamentController@get_sp')->middleware('auth');
Route::post('/classeMedicament', 'User\MedicamentController@get_classe')->middleware('auth');

//
Route::get('/patient/{patient_id}/pre_analyser/{prescription_id}', 'User\AnalyseController@pre_analyser')->name('analyse.pre');
Route::resource('/analyse', 'User\AnalyseController')->middleware('auth');
Route::get('/analyses', 'User\AnalyseController@index2')->middleware('auth')->name('education.todo');
Route::get('/ip/history', 'User\AnalyseController@index2')->middleware('auth')->name('analyse.history_ip');
Route::get('/analysesView', 'User\AnalyseController@index3')->middleware('auth')->name('analyse.index3');
Route::get('/patient/{patient_id}&{pre_risque_id}/analysePharmaceutique', 'User\AnalyseController@analyse_ph')->middleware('auth');
Route::get('/patient/{patient_id}&{pre_risque_id}/pre_analyse_interne', 'User\AnalyseController@pre_analyse_interne')->middleware('auth');
Route::get('/patient/{patient_id}&{pre_risque_id}/details_education', 'User\AnalyseController@details_education')->middleware('auth');
