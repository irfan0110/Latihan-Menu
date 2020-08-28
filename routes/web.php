<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/menu', 'MenuController@index')->name('menus.index');
Route::prefix('menu')->middleware('auth')->group(function (){
    Route::post('store', 'MenuController@store')->name('menus.store');
    Route::post('update', 'MenuController@update')->name('menus.update');
});

Route::get('/role', 'RoleController@index')->name('roles.index');
Route::prefix('role')->middleware('auth')->group(function(){
    Route::post('store','RoleController@store')->name('roles.store');
    Route::post('update', 'RoleController@update')->name('roles.update');
    Route::get('addUserRole/{id}', 'RoleController@addUserRole')->name('roles.addUserRole');
    Route::post('roleStore', 'RoleController@roleStore')->name('roles.roleStore');
    Route::get('accessMenu/{id}', 'RoleController@accessMenu')->name('roles.menu');
    Route::post('addMenu', 'RoleController@addMenu')->name('roles.addMenu');
    Route::delete('delete/{id}','RoleController@delete')->name('roles.delete');
});

Route::get('/submenu','SubMenuController@index')->name('submenu.index');
Route::prefix('submenu')->middleware('auth')->group(function (){
    Route::post('store','SubMenuController@store')->name('submenu.store');
    Route::post('update','SubMenuController@update')->name('submenu.update');
});