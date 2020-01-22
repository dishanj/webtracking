<?php

Route::group(['prefix' => 'roles','module' => 'RoleModule', 'middleware' => ['web','authenticate'], 'namespace' => 'App\Modules\RoleModule\Controllers'], function() {

    // Route::resource('RoleModule', 'RoleModuleController');

    /*** Get Routes ***/
	Route::get('add', 'RoleModuleController@index')->name('roles.add');
	
	Route::get('list', 'RoleModuleController@listView')->name('roles.list');
	
	Route::get('edit/{id}', 'RoleModuleController@edit')->name('roles.edit');


	/*** Post Routes ***/
	Route::post('add', 'RoleModuleController@store')->name('roles.add');
	
	Route::post('update', 'RoleModuleController@update')->name('roles.edit');

});
