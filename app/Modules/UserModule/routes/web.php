<?php

Route::group(['prefix'=>'user','module' => 'UserModule', 'middleware' => ['web','authenticate'], 'namespace' => 'App\Modules\UserModule\Controllers'], function() {

    // Route::resource('UserModule', 'UserModuleController');

    /*** Get Routes ***/
	Route::get('add', 'UserModuleController@index')->name('user.add');
	
	Route::get('list', 'UserModuleController@listView')->name('user.list');
	
	Route::get('edit/{id}', 'UserModuleController@edit')->name('user.edit');
	
	Route::get('reset/{id}', 'UserModuleController@changePwdView')->name('user.reset');

	Route::get('change-my-password', 'UserModuleController@changeMyPassword')->name('user.changemypassword');

	Route::get('profile', 'UserModuleController@profile')->name('user.list');


	/*** Post Routes ***/
	Route::post('add', 'UserModuleController@store')->name('user.add');
	
	Route::post('changeStatus', 'UserModuleController@changeStatus')->name('user.delete');
	
	Route::post('update', 'UserModuleController@update')->name('user.edit');
	
	Route::post('reset', 'UserModuleController@updatePassword')->name('user.reset');

    Route::post('change-my-password', 'UserModuleController@updateMyPassword')->name('user.changemypassword');
});
