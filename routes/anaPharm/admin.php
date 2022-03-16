<?php

Route::prefix('admin')->group(function () {
    Route::resource('medicaments', 'User\MedicamentController')->middleware('auth');
    Route::get('stats/getPrescriptions', 'Stats\StatistiqueController@getPrescriptions')->middleware('auth');
    Route::get('stats/getProblems', 'Stats\StatistiqueController@getProblems')->middleware('auth');
    Route::get('stats/getAnalysesPharmaceutique', 'Stats\StatistiqueController@getAnalysesPharmaceutique')->middleware('auth');
    Route::get('stats/getInterventionsPharmaceutique', 'Stats\StatistiqueController@getInterventionsPharmaceutique')->middleware('auth');
    Route::get('stats/getAll', 'Stats\StatistiqueController@getAll')->middleware('auth');
    Route::resource('stats', 'Stats\StatistiqueController')->middleware('auth');
    Route::resource('user', 'Admin\UserController')->middleware('can:is-admin');
    Route::resource('profile', 'Admin\RoleController')->middleware('can:is-admin');
    Route::get('element/get-elements/{bilan}', 'Admin\ElementController@getElements');
    Route::resource('element', 'Admin\ElementController')->middleware('can:is-admin');
    Route::resource('produit', 'Admin\ProduitalimentaireController')->middleware('can:is-admin');
    Route::resource('regle', 'Admin\RegleController')->middleware('can:is-admin');
    Route::resource('questionnaires', 'Admin\QuestionController')->middleware('can:is-admin');
    Route::resource('unite', 'Admin\UniteController')->middleware('can:is-admin');
    Route::resource('specialite', 'Admin\SpecialiteController')->middleware('can:is-admin');
    Route::resource('userEx', 'Admin\UserExController'); //->middleware('can:is-admin,user')
    Route::resource('profile', 'Admin\RoleController')->middleware('can:is-admin,profile');
    Route::resource('reglee', 'Admin\RegleeController')->middleware('can:is-admin,editeur_regle');
    Route::resource('education', 'Admin\EducationController')->middleware('can:is-admin,editeur_regle');
    Route::resource('suivi', 'Admin\SuiviController')->middleware('can:is-admin,editeur_regle');
    Route::resource('pharmaco', 'Admin\pharmacoController')->middleware('auth');
    Route::resource('compte', 'Admin\CompteController');                                                      //->middleware('can:is-admin,user')
    Route::resource('dashboard', 'Admin\DashboardController')->middleware('can:dashboard.view'); //->middleware('can:is-admin,element')
    Route::resource('unite', 'Admin\UniteController')->middleware('can:is-admin,produit');
    Route::resource('specialite', 'Admin\SpecialiteController')->middleware('can:is-admin,produit');
    Route::post('element/{phrase}', 'Admin\ElementController@getElement')->middleware('auth');
    Route::get('analyseEduSite/{pathologie}&{obsrvance}&{medicament}', 'Admin\MoteurEduSite@analyser');
    Route::post('specialite1', 'Admin\SpecialiteController@storeUnit')->middleware('can:is-admin')->name('specialite.store2');
    Route::get('pharmacoList1', 'Admin\pharmacoController@liste1')->middleware('can:is-admin,produit')->name('liste1');
    Route::get('pharmacolist2', 'Admin\pharmacoController@liste2')->middleware('can:is-admin,produit')->name('liste2');
    Route::get('{pharmaco}/envoyer', 'Admin\pharmacoController@envoyee')->name('envoie')->middleware('auth');
    Route::get('regle/{regle_id}/edits', 'Admin\RegleController@edits')->middleware('can:is-admin');
    Route::get('regle/{id}/edit', 'Admin\RegleeController@edit')->middleware('can:is-admin,editeur_regle');
    Route::get('education/{id}/edit', 'Admin\EducationController@edit')->middleware('can:is-admin,editeur_regle');
    Route::get('suivi/{id}/edit', 'Admin\SuiviController@edit')->middleware('can:is-admin,editeur_regle');
    Route::match(['put', 'patch', 'post', 'get'], 'education/{id}/update', 'Admin\EducationController@update')->middleware('can:is-admin,editeur_regle');
    Route::match(['put', 'patch', 'post', 'get'], 'regle/{id}/update', 'Admin\RegleeController@update')->middleware('can:is-admin,editeur_regle');
    Route::match(['put', 'patch', 'post', 'get'], 'suivi/{id}/update', 'Admin\SuiviController@update')->middleware('can:is-admin,editeur_regle');
});
