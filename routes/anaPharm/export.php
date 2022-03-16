<?php
Route::get('/export/gen_ab/{patient_id}', 'Exports\BilanExport@export_bilan')->middleware('auth');
Route::get('/export/trait_c/{patient_id}', 'Exports\TraitExport@export_bilan')->middleware('auth');
Route::get('/export/auto/{patient_id}', 'Exports\AutoExport@export_bilan')->middleware('auth');
Route::get('/export/phyto/{patient_id}', 'Exports\PhytoExport@export_bilan')->middleware('auth');
Route::get('/export/ques/{patient_id}', 'Exports\QuesExport@export_bilan')->middleware('auth');
Route::get('/export/et/{patient_id}', 'Exports\EtExport@export_bilan')->middleware('auth');
Route::get('/export/ho/{patient_id}', 'Exports\hoExport@export_hospi')->middleware('auth');
Route::get('/export/act/{patient_id}', 'Exports\actExport@export_act')->middleware('auth');
Route::get('/export/consultation/{patient_id}', 'Exports\ConsultationExport@export_bilan')->middleware('auth');
?>