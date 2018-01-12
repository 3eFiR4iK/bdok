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


//Auth::routes();

Route::get ('/','HomeController@index');
Route::get('login', 'LoginController@show');
Route::post('login', 'LoginController@login')->name('login');
Route::post('logout', 'LoginController@logout')->name('logout');

Route::get('part','TestController@index') ;
Route::get('part/filter/','TestController@filter')->name('filterPart');
Route::get('part/toexcel/{path}','TestController@toExport');
Route::post('part/updateImage','TestController@updateImage');

Route::get('kadet','KadetController@kadets');
Route::get('kadet/filter','KadetController@filter')->name('filterKadet');

Route::get('class','ClassController@classes');
Route::get('class/filter','ClassController@filter')->name('filterClass');

Route::get('addPart','AddPartController@show');
Route::post('addPart','AddPartController@save')->name('savePart');

Route::post('import','ImportController@import');
Route::get('export/parts','ExcelController@export');
Route::get('export/prepods','ExcelController@exportPrepods');
Route::post('export/kadets','ExcelController@exportKadets');
Route::get('upkadet','UpclassController@UpClass');

