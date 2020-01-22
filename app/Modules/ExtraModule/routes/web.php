<?php

Route::group(['prefix' => 'other','module' => 'ExtraModule', 'middleware' => ['web','authenticate'], 'namespace' => 'App\Modules\ExtraModule\Controllers'], function() {

    // Route::resource('ExtraModule', 'ExtraModuleController');

    /*** Get Routes ***/
	Route::get('banners/add', 'ExtraModuleController@addBannersView')->name('web.update');

	Route::get('othercsvupload', 'ExtraModuleController@othercsvupload')->name('product.upload');

	Route::get('excelupload', 'ExtraModuleController@excelupload')->name('product.upload');

    Route::get('download-latest', 'ExtraModuleController@downloadLastProductFile')->name('product.upload');

    Route::get('download-sample', 'ExtraModuleController@downloadSampleProductFile')->name('product.upload');


	/*** Post Routes ***/
	Route::post('banners/add', 'ExtraModuleController@addBanners')->name('web.update');

	Route::post('othercsvupload', 'ExtraModuleController@saveothercsv')->name('product.upload');

	Route::post('excelupload', 'ExtraModuleController@saveExcelData')->name('product.upload');

});
