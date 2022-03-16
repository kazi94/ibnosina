<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Events\TaskEvent;

Auth::routes();
Route::get('/clear', 'ConfigController@optimize');
Route::get('/', 'ConfigController@getApp');
Route::get('/omaga', 'ConfigController@down');

Route::get('/tests', 'Exports\testExcel@export_bilan');
// Route::get('/testCnas', 'TestController@insertCnas');
Route::get('/testCnas', 'TestController@fileRead');

// Routes Application AnaPharm
//require_once "anaPharm/web.php";
//*******************Divers*******************************
Route::resource('/appointement', 'AppointementController')->middleware('auth');
Route::post('/appointement/storePatient', 'AppointementController@storePatient')->middleware('auth');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/help', 'ConfigController@help')->name('help');
Route::get('/admin/settings', 'ConfigController@settings')->middleware('auth');
Route::get('/admin/logActivity', 'HomeController@logActivity')->name('admin.logs')->middleware('auth');
//
Route::get('/clairance', 'User\ClairanceController@index')->name('clairance.index');
Route::post('/clairance', 'User\ClairanceController@calculClairance')->name('clairance.calcul');

// Route::get('/app', 'ConfigController@getApp');
Route::get('/bugs_report', 'ReportController@bugs');
Route::post('bugs_report', 'ReportController@reportBug')->name('report_bug');
Route::get('/export/gen_ab/{patient_id}', 'Exports\BilanExport@export_bilan')->middleware('auth');
Route::get('/export/trait_c/{patient_id}', 'Exports\TraitExport@export_bilan')->middleware('auth');
Route::get('/export/auto/{patient_id}', 'Exports\AutoExport@export_bilan')->middleware('auth');
Route::get('/export/phyto/{patient_id}', 'Exports\PhytoExport@export_bilan')->middleware('auth');
Route::get('/export/ques/{patient_id}', 'Exports\QuesExport@export_bilan')->middleware('auth');
Route::get('/export/et/{patient_id}', 'Exports\EtExport@export_bilan')->middleware('auth');
Route::get('/export/ho/{patient_id}', 'Exports\hoExport@export_hospi')->middleware('auth');
Route::get('/export/act/{patient_id}', 'Exports\actExport@export_act')->middleware('auth');
Route::get('/export/consultation/{patient_id}', 'Exports\ConsultationExport@export_bilan')->middleware('auth');
Route::get('/export/patients', 'Exports\PatientExport@exportPatientsWithBilans')->name('export.patients.bilans')->middleware('auth');
/*Chat Routes*/
Route::resource('chat', 'ChatController');
Route::get('chats', 'ChatController@chat');
Route::post('send', 'ChatController@send');
Route::post('saveToSession', 'ChatController@saveToSession');
Route::post('deleteSession', 'ChatController@deleteSession');
Route::post('getOldMessage', 'ChatController@getOldMessage');
// Route::get('check', function () {
//     return session('chat');
// });
/*!End Chat Routes!*/
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
Route::get('/dispenser', 'Chimio\PrescriptionController@dis')->middleware('auth');
Route::get('/encours', 'Chimio\PrescriptionController@encours')->middleware('auth');

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
Route::get('/export/gen_ab/{patient_id}', 'Exports\BilanExport@export_bilan')->middleware('auth');
Route::get('/export/trait_c/{patient_id}', 'Exports\TraitExport@export_bilan')->middleware('auth');
Route::get('/export/auto/{patient_id}', 'Exports\AutoExport@export_bilan')->middleware('auth');
Route::get('/export/phyto/{patient_id}', 'Exports\PhytoExport@export_bilan')->middleware('auth');
Route::get('/export/ques/{patient_id}', 'Exports\QuesExport@export_bilan')->middleware('auth');
Route::get('/export/et/{patient_id}', 'Exports\EtExport@export_bilan')->middleware('auth');
Route::get('/export/ho/{patient_id}', 'Exports\hoExport@export_hospi')->middleware('auth');
Route::get('/export/act/{patient_id}', 'Exports\actExport@export_act')->middleware('auth');
Route::get('/export/consultation/{patient_id}', 'Exports\ConsultationExport@export_bilan')->middleware('auth');
Route::post('/addAnnotation', 'User\AnnotationController@store')->name('addAnnotation');
Route::get('/sms/{patient_id}', 'Admin\NotificationController@send')->middleware('auth')->name('send');


Route::get('getQuestions/{questionnaireId}', 'Admin\QuestionController@getQuestions')->middleware('auth');;
Route::get('/patient/archives', 'User\PatientController@showArchives')->name('patient.archives');
Route::post('/patient/all', 'User\PatientController@search');
Route::get('/patient/create-patient', 'User\PatientController@createOnOneStep')->name('patient.create.zero.step');
Route::get('/patient/regleSuivPatient/{patient_id}&{regle_id}', 'User\RegleSuivPatientController@vu')->name('regleSuivPatient.vu')->middleware('can:is-admin,analyse_suiv');
//Route::get('/admin/regle/{regle_id}/edits','Admin\RegleController@edits')->middleware('can:is-admin,produit');

Route::get('/element/all', 'Admin\ElementController@getAll')->middleware('auth');
Route::get('/act/all', 'User\Act_medicaleController@getAll')->middleware('auth');
//


Route::get('/patient/list-view', 'User\PatientController@showView')->middleware('auth')->name('patient.view.list');
Route::post('/patient/all', 'User\PatientController@search')->middleware('auth');
Route::post('/patient/message', 'User\PatientController@storeMessage')->middleware('auth');
Route::get('/patient/{id}&&{pr_risque?}&&{notif_id}/confirm', 'User\PatientController@markAsRead')->name('patient.notification')->middleware('auth');
Route::get('/patient/{id}&&{pr_risque?}/edit', 'User\PatientController@edit')->name('patient.intervenir')->middleware('auth');
// Route::get('/patient/{id}/analysePerso' , 'User\MoteurInferenceController@pre_analyser')->middleware('auth');
Route::get('/patient/{pr_risque}/faireEdu', 'User\PrescriptionController@faireEducation')->name('patient.FaireEducation')->middleware('can:analyse_therap');
Route::get('/patient/get-pathologies?_type=query', 'User\PatientController@fetchPathologies');
Route::resource('/patient', 'User\PatientController')->middleware('auth');
Route::get('/chart/edit/{id}', 'User\ChartController@edit')->name('chart.edit')->middleware('auth');
Route::post('/graphe', 'User\ChartController@passInfo')->name('graphe')->middleware('auth');
Route::get('/ajax/{id}/{dashboard}', 'User\ChartController@ajax')->name('ajax')->middleware('auth');

Route::match(['put', 'patch', 'post', 'get'], '/hospitalisation/{id}/edit', 'User\HospitalisationController@update');
Route::match(['put', 'patch', 'post', 'get'], '/hospitalisation/getHospitalisation/{id}', 'User\HospitalisationController@getHospitalisation');
Route::post('/hospitalisation/getHospitalisation/{id}', 'User\HospitalisationController@getHospitalisation')->middleware('auth');
Route::resource('/hospitalisation', 'User\HospitalisationController')->middleware('auth');
// Route::get('/hospitalisation/{patient_id}/print', 'User\HospitalisationController@showsho')->name('hospitalisation.shows')->middleware('auth');
Route::post('/patient/hospitalisation/print-report', 'User\HospitalisationController@printReport')->name('hospitalisation.shows')->middleware('auth');
//
Route::resource('/patient/traitement_chronique', 'User\TraitementchroniqueController')->middleware('auth');
Route::get('/patient/traitement_chronique/get-last-state/{id}', 'User\TraitementchroniqueController@getLastState')->middleware('auth');
Route::put('/patient/traitement_chronique/update-state/{id}', 'User\TraitementchroniqueController@updateState')->middleware('auth');
Route::delete('/patient/traitement/{id}/denie', 'User\TraitementchroniqueController@destroy_tmp')->middleware('auth')->name('traitement.destroy_tmp');
Route::delete('/patient/traitement/{id}/confirm', 'User\TraitementchroniqueController@confirm')->middleware('auth')->name('traitement.confirm');
Route::post('/getTraitement', 'User\TraitementchroniqueController@getHisTraitement')->middleware('auth');
//
Route::resource('/patient/automedication', 'User\AutomedicationController')->middleware('auth');
Route::get('/patient/automedication/get-last-state/{id}', 'User\AutomedicationController@getLastState')->middleware('auth');
Route::put('/patient/automedication/update-state/{id}', 'User\AutomedicationController@updateState')->middleware('auth');
Route::delete('/patient/automedication/{id}/denie', 'User\AutomedicationController@destroy_tmp')->middleware('auth')->name('automedication.destroy_tmp');
Route::delete('/patient/automedication/{id}/confirm', 'User\AutomedicationController@confirm')->middleware('auth')->name('automedication.confirm');
Route::post('/getAutomedication', 'User\AutomedicationController@getHisAutomedication')->middleware('auth');
//
Route::resource('/patient/phytotherapie', 'User\PhytotherapieController')->middleware('auth');
Route::get('/api/utils/dairas/{id}', 'Api\PatientController@getDairasByVille')->middleware('auth');
Route::resource('/api/operation', 'Api\Operation_chirugicaleController')->middleware('auth');
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
Route::resource('/patient/education_therapeutique', 'User\EducationTherapeutiqueController')->middleware('auth');
Route::get('/admin/education/{id}/details', 'Admin\EducationController@show')->middleware('can:is-admin,editeur_regle');

Route::get('/patient/consultation-rapide/etape-un/type={type?}{id?}', 'User\DossierController@createPatient')->name('patient.create.step.one.get')->middleware('auth');
Route::post('/patient/consultation-rapide/etape-un', 'User\DossierController@postcreatePatient')->name('patient.create.step.one.post')->middleware('auth');

Route::get('/patient/consultation-rapide/etape-deux/{id?}', 'User\DossierController@createConsultation')->name('patient.create.step.two')->middleware('auth');
Route::post('/patient/consultation-rapide/etape-deux', 'User\DossierController@postcreateConsultation')->name('patient.create.step.two.post')->middleware('auth');

Route::get('/patient/consultation-rapide/etape-trois/{id?}', 'User\DossierController@createHospitalisation')->name('patient.create.step.three')->middleware('auth');
Route::post('/patient/consultation-rapide/etape-trois', 'User\DossierController@postcreateHospitalisation')->name('patient.create.step.three.post')->middleware('auth');

Route::get('/patient/consultation-rapide/etape-quatre/{id?}', 'User\DossierController@createPrescription')->name('patient.create.step.four')->middleware('auth');
Route::post('/patient/consultation-rapide/etape-quatre', 'User\DossierController@postcreatePrescription')->name('patient.create.step.four.post')->middleware('auth');

Route::get('/patient/consultation-rapide/etape-cinq/{id?}', 'User\DossierController@createTraitement')->name('patient.create.step.five')->middleware('auth');
Route::post('/patient/consultation-rapide/etape-cinq', 'User\DossierController@postcreateTraitement')->name('patient.create.step.five.post')->middleware('auth');

Route::get('/patient/consultation-rapide/etape-six/{id?}', 'User\DossierController@createBilan')->name('patient.create.step.six')->middleware('auth');
Route::post('/patient/consultation-rapide/etape-six', 'User\DossierController@postcreateBilan')->name('patient.create.step.six.post')->middleware('auth');

Route::get('/patient/consultation-rapide/etape-finale/{id?}', 'User\DossierController@createReport')->name('patient.create.step.final')->middleware('auth');
Route::post('/patient/consultation-rapide/etape-finale/{id?}', 'User\DossierController@postcreateReport')->name('patient.create.step.final.post')->middleware('auth');
//
Route::resource('/patient/questionnaire', 'User\QuestionnaireController')->middleware('auth');
Route::delete('/patient/questionnaire/destroy/{id}&{patient_id}&{user_id}&{date_questionnaire}', 'User\QuestionnaireController@destroys')->middleware('auth');
//
Route::get('/patient/prescription/ligneprescription/{line_id}&&{isChecked}&&{prise}', 'User\LignePrescriptionController@updateInjectedValue')->middleware('auth');
Route::post('/patient/prescription/ligneprescription/stop-injection/{line_id}', 'User\LignePrescriptionController@stopInjection');

Route::get('/administrations/archives', 'User\InjectionController@showArchives')->name('administrations.archives')->middleware('auth');
Route::resource('/administrations', 'User\InjectionController')->middleware('auth');
Route::delete('/patient/prescription/examen/{id}', 'User\PrescriptionController@destroyPrescriptionExamen')->name('prescription.examen.destroy')->middleware('auth');
Route::resource('/patient/prescription', 'User\PrescriptionController')->middleware('auth');
Route::post('/prescription/store2', 'User\PrescriptionController@store')->name('prescriptionstore2')->middleware('auth');
Route::get('/patient/prescription/get-injections/id={id}', 'User\PrescriptionController@fetchInjectionsHistory')->middleware('auth');
//
Route::resource('/patient/education_therapeutique', 'User\EducationTherapeutiqueController')->middleware('auth');
//
Route::resource('/patient/questionnairePatient', 'User\QuestionnaireController')->middleware('auth');
Route::delete('/patient/questionnairePatient/destroy/{id}&{patient_id}&{user_id}&{date_questionnaire}', 'User\QuestionnaireController@destroys')->middleware('auth');
//
Route::resource('/patient/prescription', 'User\PrescriptionController')->middleware('auth');
Route::get('/patient/prescription/{patient_id}${id}/print', 'User\PrescriptionController@shows')->name('prescription.shows')->middleware('auth');
//
Route::resource('/patient/consultation', 'User\ConsultationController')->middleware('auth');
Route::delete('/patient/consultation/destroy/{id}&{patient_id}', 'User\ConsultationController@destroys')->middleware('auth');
Route::get('logout', 'Auth\LoginController@logout');
Route::resource('/admin/question', 'User\QuestionController')->middleware('auth');
Route::get('/demande-examens', 'User\BilanController@getExamens')->name('examens.index')->middleware('auth');
Route::resource('patient/bilan', 'User\BilanController')->middleware('auth');
Route::patch('/patient/bilan/element/{id}', 'User\BilanController@updateElement')->middleware('auth');
Route::get('/patient/element/get-demande/{id}', 'User\BilanController@getDemande')->middleware('auth');
Route::get('/patient/element/get-prescription/{id}', 'User\BilanController@getPrescription')->middleware('auth');
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

//****************************************************** ROUTES PHARMACIEN ********************************************/
Route::group(['middleware' => 'auth'], function () {
    Route::get('/ma-pharmacie', 'User\PharmacieController@index')->name('pharmacie.index');
    Route::get('/ma-pharmacie/interventions-pharmaceutiques', 'User\InterventionController@showInterventions')->name('intervention.history');
    Route::get('/ma-pharmacie/prescriptions-a-analyser', 'User\InterventionController@showRisquePrescriptions')->name('intervention.show');
    Route::get('/ma-pharmacie/educations-therapeutiques', 'User\EducationTherapeutiqueController@showEducations')->name('education.todo');
    Route::get('/patient/{patient_id}/pre_analyser/{prescription_id}', 'User\AnalyseController@pre_analyser')->name('analyse.pre');
    Route::resource('/analyse', 'User\AnalyseController');
    Route::get('/analysesView', 'User\AnalyseController@index3')->name('analyse.index3');
    Route::get('/patient/{patient_id}&{pre_risque_id}/analysePharmaceutique', 'User\AnalyseController@analyse_ph');
    Route::get('/patient/{patient_id}&{pre_risque_id}/pre_analyse_interne', 'User\AnalyseController@pre_analyse_interne');
    Route::get('/patient/{patient_id}&{pre_risque_id}/details_education', 'User\AnalyseController@details_education');
});

//****************************************************** END ROUTES PHARMACIEN ********************************************/


//****************************************************** ROUTES BANQUE DE DONNÉES ********************************************/
//require_once "bddm/web.php";
// Route::get('/', 'bddm_app\bddmController@showMedicaments')->name('medicaments.noms-commerciale');
// Route::get('/medicaments','bddm_app\bddmController@showMedicaments')->name('medicaments.noms-commerciale');
Route::post('/medicaments', 'bddm_app\bddmController@search')->name('medicaments.search');
Route::get('/medicaments_ajax', 'bddm_app\bddmController@showMedicamentsAjax')->name('medicaments.noms1-commerciale');
Route::get('/medicaments/alphabet/{name}', 'bddm_app\bddmController@showAlphabetMedicaments');
Route::get('/classes', 'bddm_app\bddmController@showClasses')->name('medicaments.classes');
Route::get('/classes/{id}', 'bddm_app\bddmController@showSubClasses');
Route::get('/classes-pharmaceutiques', 'bddm_app\bddmController@showPharmClasses');
Route::get('/classes-pharmaceutiques/{id}', 'bddm_app\bddmController@showSubPharmClasses');
Route::get('/substances', 'bddm_app\bddmController@showSubstances')->name('medicaments.substances');
Route::get('/substances/{idSAC}&&{rd}', 'bddm_app\bddmController@getSacMedicaments');
Route::get('/indications', 'bddm_app\bddmController@showIndications')->name('medicaments.indications');
Route::get('/indications/{id}', 'bddm_app\bddmController@showSpIndication');
Route::get('/medicaments/{medicament}', 'bddm_app\bddmController@getMonographie')->name('medicaments.monographie');
Route::get('/generatePages', 'bddm_app\bddmController@generatePages');
Route::get("/api/medicament/{phrase}&&type={type_search}", 'bddm_app\bddmController@searchMedicament');
Route::get('/bddm_report', 'ReportController@bddmReport');
// Route::post('/medicaments/{medicament}','bddm_app\bddmController@getMonographie')->name('medicaments.monographie');
//****************************************************** END ROUTES BANQUE DE DONNÉES ********************************************/


//****************************************************** ROUTES ADMINISTRATEUR ********************************************/
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::resource('medicaments', 'User\MedicamentController');
    Route::resource('stats', 'Stats\StatistiqueController');
    Route::get('user/profile/{id}', 'Admin\UserController@getProfile')->name('user.profile');
    Route::get('user/get-user/{id}', 'Admin\UserController@getUser');
    Route::resource('user', 'Admin\UserController')->middleware('can:is-admin');
    Route::resource('profile', 'Admin\RoleController')->middleware('can:is-admin');
    Route::get('element/get-elements/{bilan}', 'Admin\ElementController@getElements');
    Route::resource('element', 'Admin\ElementController')->middleware('can:is-admin');
    Route::resource('produit', 'Admin\ProduitalimentaireController')->middleware('can:is-admin');
    Route::resource('regle', 'Admin\RegleController')->middleware('can:is-admin');
    Route::resource('questionnaires', 'Admin\QuestionController')->middleware('can:is-admin');
    Route::resource('unite', 'Admin\UniteController')->middleware('can:is-admin');
    Route::resource('specialite', 'Admin\SpecialiteController')->middleware('can:is-admin');
    Route::resource('userEx', 'Admin\UserExController');
    Route::resource('profile', 'Admin\RoleController')->middleware('can:is-admin,profile');
    Route::resource('reglee', 'Admin\RegleeController')->middleware('can:is-admin,editeur_regle');
    Route::resource('education', 'Admin\EducationController')->middleware('can:is-admin,editeur_regle');
    Route::resource('suivi', 'Admin\SuiviController')->middleware('can:is-admin,editeur_regle');
    Route::resource('pharmaco', 'Admin\pharmacoController');
    Route::resource('compte', 'Admin\CompteController');
    Route::resource('dashboard', 'Admin\DashboardController')->middleware('can:dashboard.view');
    Route::resource('unite', 'Admin\UniteController')->middleware('can:is-admin,produit');
    Route::resource('specialite', 'Admin\SpecialiteController')->middleware('can:is-admin,produit');
    Route::post('element/{phrase}', 'Admin\ElementController@getElement');
    Route::get('analyseEduSite/{pathologie}&{obsrvance}&{medicament}', 'Admin\MoteurEduSite@analyser');
    Route::post('specialite1', 'Admin\SpecialiteController@storeUnit')->middleware('can:is-admin')->name('specialite.store2');
    Route::get('pharmacoList1', 'Admin\pharmacoController@liste1')->middleware('can:is-admin,produit')->name('liste1');
    Route::get('pharmacolist2', 'Admin\pharmacoController@liste2')->middleware('can:is-admin,produit')->name('liste2');
    Route::get('{pharmaco}/envoyer', 'Admin\pharmacoController@envoyee')->name('envoie');
    Route::get('regle/{regle_id}/edits', 'Admin\RegleController@edits')->middleware('can:is-admin');
    Route::get('regle/{id}/edit', 'Admin\RegleeController@edit')->middleware('can:is-admin,editeur_regle');
    Route::get('education/{id}/edit', 'Admin\EducationController@edit')->middleware('can:is-admin,editeur_regle');
    Route::get('suivi/{id}/edit', 'Admin\SuiviController@edit')->middleware('can:is-admin,editeur_regle');
    Route::match(['put', 'patch', 'post', 'get'], 'education/{id}/update', 'Admin\EducationController@update')->middleware('can:is-admin,editeur_regle');
    Route::match(['put', 'patch', 'post', 'get'], 'regle/{id}/update', 'Admin\RegleeController@update')->middleware('can:is-admin,editeur_regle');
    Route::match(['put', 'patch', 'post', 'get'], 'suivi/{id}/update', 'Admin\SuiviController@update')->middleware('can:is-admin,editeur_regle');
    Route::resource('/prescription-type/prescription-service', 'Admin\PrescriptionServiceController');
    Route::resource('/prescription-type/prescription-examen', 'Admin\PrescriptionExamenController');
    Route::resource('prescription-type', 'Admin\PrescriptionTypeController');
});
//****************************************************** END ROUTES ADMINISTRATEUR ********************************************/




//****************************************************** APIS ROUTES ********************************************/

Route::group(['middleware' => 'auth', 'prefix' => 'api'], function () {
    Route::get('patient/{id}', 'Api\PatientController@fetch');
    Route::get('patient/{id}/profile', 'Api\PatientController@fetchProfile');
    Route::get('patient', 'Api\PatientController@search');
    Route::get('/patient/consultation/{id}', 'Api\ConsultationController@show');
    Route::get('/patient/hospitalisation/{id}', 'Api\HospitalisationController@getById');
    Route::get('/patient/prescription/{id}/lines', 'Api\PrescriptionController@fetchLinesById');
    //--------------------- API ROUTES STATISTIQUES -------------------//
    Route::get('stats/get-prescriptions-risque/{from?}/{to/admin/prescription-type/prescription-service/}', 'Stats\StatistiqueController@getPrescriptionsRisk');
    Route::get('stats/get-consultations/{from?}/{to?}', 'Stats\StatistiqueController@getConsultations');
    Route::get('stats/get-patients/{from?}/{to?}', 'Stats\StatistiqueController@getPatients');
    Route::get('stats/get-prescriptions/{from?}/{to?}', 'Stats\StatistiqueController@getPrescriptions');
    Route::get('stats/get-probleme-pharmaceutique/{from?}/{to?}', 'Stats\StatistiqueController@getProblems');
    Route::get('stats/get-analyse-pharmaceutique/{from?}/{to?}', 'Stats\StatistiqueController@getAnalysesPharmaceutique');
    Route::get('stats/get-intervention-pharmaceutique/{from?}/{to?}', 'Stats\StatistiqueController@getInterventionsPharmaceutique');
    Route::get('stats/getAll', 'Stats\StatistiqueController@getAll');

    //--------------------- END API ROUTES STATISTIQUE ----------------//
});

//****************************************************** END APIS ROUTES ********************************************/
