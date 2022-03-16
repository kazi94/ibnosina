<?php
/*Chat Routes*/
Route::resource('chat','ChatController');
Route::get('chats','ChatController@chat');
Route::post('send','ChatController@send');
Route::post('saveToSession','ChatController@saveToSession');
Route::post('deleteSession','ChatController@deleteSession');
Route::post('getOldMessage','ChatController@getOldMessage');
// Route::get('check',function(){
//     return session('chat');
// });
/*!End Chat Routes!*/
