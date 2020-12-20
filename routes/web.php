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


Route::group(['middleware' => ['auth']],function(){

//Single Link
Route::get('/single/add', function () {return view('addSingleLink');})->name('addSingleLink');
Route::get('/single/edit/{id}', function () {return view('editSingleLink');})->name('editSingleLink');
Route::get('/single/show/{id}', function () {return view('showSingleLink');})->name('showSingleLink');

//Group Link
Route::get('/group/add', function () {return view('addGroupLink');})->name('addGroupLink');
Route::get('/group/edit/{shortURL}', function () {return view('editGroupLink');})->name('editGroupLink');
Route::get('/group/show/{shortURL}', function () {return view('showGroupLink');})->name('showGroupLink');

});

Auth::routes();

Route::get('/','HomeController@index');
Route::get('/home','HomeController@index');
Route::get('/error', function () {return view('error');})->name('error');

//Single Link Controller
Route::get('/s/{short_url}','SingleLinkController@singleLinkWhatsApp');
Route::get('/single', 'SingleLinkController@index')->name('single');
Route::apiResources(['singlelink' => 'SingleLinkController']);

//Group Link Controller
Route::apiResources(['grouplink' => 'GroupLinkController']);
Route::get('/g/{short_url}','GroupLinkController@groupLinkWhatsApp');
Route::get('/{id}/{shortURL}','GroupLinkController@redirectWhatsApp');
Route::get('/group', 'GroupLinkController@index')->name('group');



