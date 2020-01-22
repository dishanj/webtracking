<?php

Route::group(['prefix' => 'menu','module' => 'MenuModule', 'middleware' => ['web','authenticate'], 'namespace' => 'App\Modules\MenuModule\Controllers'], function() {

    // Route::resource('MenuModule', 'MenuModuleController');

    /*** Get Routes ***/
	Route::get('add', 'MenuModuleController@index')->name('menu.add');
	
	Route::get('list', 'MenuModuleController@listView')->name('menu.list');
	
	Route::get('edit/{id}', 'MenuModuleController@edit')->name('menu.edit');


	/*** Post Routes ***/
	Route::post('add', 'MenuModuleController@store')->name('menu.add');
	
	Route::post('changeStatus', 'MenuModuleController@changeStatus')->name('menu.delete');
	
	Route::post('update', 'MenuModuleController@update')->name('menu.edit');

});
