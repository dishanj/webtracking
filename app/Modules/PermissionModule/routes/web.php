<?php

Route::group(['prefix' => 'permission','module' => 'PermissionModule', 'middleware' => ['web','authenticate'], 'namespace' => 'App\Modules\PermissionModule\Controllers'], function() {

    // Route::resource('PermissionModule', 'PermissionModuleController');

	/*** Get Routes ***/
	Route::get('add', 'PermissionModuleController@index')->name('permission.add');
	
	Route::get('list', 'PermissionModuleController@listView')->name('permission.list');
	
	Route::get('edit/{id}', 'PermissionModuleController@edit')->name('permission.edit');


	/*** Post Routes ***/
	Route::post('add', 'PermissionModuleController@store')->name('permission.add');
	
	Route::post('changeStatus', 'PermissionModuleController@changeStatus')->name('permission.delete');
	
	Route::post('update', 'PermissionModuleController@update')->name('permission.edit');

});
