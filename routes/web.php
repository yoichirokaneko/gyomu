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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes([
    'resister' => false,
    'reset' => false,
    'confirm' => false,
]);

Route::get('/home', 'HomeController@index')->name('home');

//ルーティング
//検索画面
Route::get('/', 'SearchController@index')->name('index')->middleware('auth');

//ajax
Route::get('/ajax/client_name_search', 'SearchController@client_name_search')->name('ajax.client_name_search');
Route::get('/ajax/client_pic_search', 'SearchController@client_pic_search')->name('ajax.client_pic_search');
Route::get('/ajax/client_tel_search', 'SearchController@client_tel_search')->name('ajax.client_tel_search');
Route::get('/ajax/client_activity_search', 'SearchController@client_activity_search')->name('ajax.client_activity_search');

//各検索ボタン押下時の処理へ
Route::post('/client_name_search', 'SearchController@client_name')->name('search.client_name')->middleware('auth');
Route::post('/client_pic_search', 'SearchController@client_pic')->name('search.client_pic')->middleware('auth');
Route::post('/client_tel_search', 'SearchController@client_tel')->name('search.client_tel')->middleware('auth');
Route::post('/client_activity_search', 'SearchController@client_activity')->name('search.client_activity')->middleware('auth');
Route::get('/property_search', 'SearchController@property')->name('search.property')->middleware('auth');


//顧客情報画面
Route::get('/client/create', 'ClientController@create')->name('client.create')->middleware('auth');
Route::post('/client/store', 'ClientController@store')->name('client.store')->middleware('auth');
Route::get('/client/{client_id}/edit', 'ClientController@edit')->name('client.edit')->middleware('auth');
Route::post('/client/{client_id}/upsert', 'ClientController@upsert')->name('client.upsert')->middleware('auth');
Route::delete('/client/{client_id}/delete', 'ClientController@delete')->name('client.delete')->middleware('auth');

//客先ファイルの処理
Route::post('/client/{client_id}/client_file_upload', 'ClientFileUploadController@store')->name('client_file.upload')->middleware('auth');
Route::get('/client/{client_id}/client_file_download/{client_file_id}', 'ClientFileDownloadController@index')->name('client_file.download')->middleware('auth');
Route::delete('/client/{client_id}/client_file_download/{client_file_id}', 'ClientFileDownloadController@delete')->name('client_file.delete')->middleware('auth');

//活動履歴画面
Route::get('/client/{client_id}/activity_history/edit', 'ActivityHistoryController@edit')->name('activity_history.edit')->middleware('auth');
Route::post('/client/{client_id}/activity_history/upsert', 'ActivityHistoryController@upsert')->name('activity_history.upsert')->middleware('auth');

//修理ファイルの処理
Route::post('/client/{client_id}/activity_history/{activity_history_id}/repair_file_upload', 'RepairFileUploadController@store')->name('repair_file.upload')->middleware('auth');
Route::get('/client/{client_id}/activity_history/{activity_history_id}/repair_file_download/{repair_file_id}', 'RepairFileDownloadController@index')->name('repair_file.download')->middleware('auth');
Route::delete('/client/{client_id}/activity_history/{activity_history_id}/repair_file_download/{repair_file_id}', 'RepairFileDownloadController@delete')->name('repair_file.delete')->middleware('auth');

//商談状況表
Route::get('/client/{client_id}/activity_history/{activity_history_id}/property/create', 'PropertyController@create')->name('property.create')->middleware('auth');
Route::post('/client/{client_id}/activity_history/{activity_history_id}/property/store', 'PropertyController@store')->name('property.store')->middleware('auth');
Route::get('/client/{client_id}/activity_history/property/edit', 'PropertyController@edit')->name('property.edit')->middleware('auth');
Route::post('/client/{client_id}/activity_history/property/upsert', 'PropertyController@upsert')->name('property.upsert')->middleware('auth');

//商談状況表（検索）
Route::post('/property_search/property/upsert', 'AllPropertyController@upsert')->name('all_property.upsert')->middleware('auth');

//見積ファイルの処理
Route::post('/client/{client_id}/activity_history/{activity_history_id}/property/{property_id}/estimate_file_upload', 'EstimateFileUploadController@store')->name('estimate_file.upload')->middleware('auth');
Route::get('/client/{client_id}/activity_history/{activity_history_id}/property/{property_id}/estimate_file_download/{estimate_file_id}', 'EstimateFileDownloadController@index')->name('estimate_file.download')->middleware('auth');
Route::delete('/client/{client_id}/activity_history/{activity_history_id}/property/{property_id}/estimate_file_download/{estimate_file_id}', 'EstimateFileDownloadController@delete')->name('estimate_file.delete')->middleware('auth');

//協会情報画面
Route::get('/association/create', 'AssociationController@create')->name('association.create')->middleware('auth');
Route::post('/association/store', 'AssociationController@store')->name('association.store')->middleware('auth');
Route::get('/association/show', 'AssociationController@show')->name('association.show')->middleware('auth');
Route::get('/association/{association_id}/edit', 'AssociationController@edit')->name('association.edit')->middleware('auth');
Route::post('/association/{association_id}/update', 'AssociationController@update')->name('association.update')->middleware('auth');
Route::delete('/association/{association_id}/delete', 'AssociationController@delete')->name('association.delete')->middleware('auth');

//CSVインポート／エクスポート画面
Route::get('/csv', 'CSVController@index')->name('csv.index')->middleware('auth');
Route::post('/csv/client_import', 'CSVController@client_import')->name('csv.client_import')->middleware('auth');
Route::post('/csv/association_import', 'CSVController@association_import')->name('csv.association_import')->middleware('auth');
Route::get('/csv/client_export', 'CSVController@client_export')->name('csv.client_export')->middleware('auth');
Route::get('/csv/association_export', 'CSVController@association_export')->name('csv.association_export')->middleware('auth');

//営業担当登録画面
Route::get('/sales_staff/create', 'SalesStaffController@create')->name('sales_staff.create')->middleware('auth');
Route::post('/sales_staff/store', 'SalesStaffController@store')->name('sales_staff.store')->middleware('auth');
Route::delete('/sales_staff/{sales_staff_id}/delete', 'SalesStaffController@delete')->name('sales_staff.delete')->middleware('auth');