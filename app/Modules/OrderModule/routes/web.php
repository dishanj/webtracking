<?php

Route::group(['module' => 'OrderModule', 'middleware' => ['web'], 'namespace' => 'App\Modules\OrderModule\Controllers'], function() {

    Route::resource('OrderModule', 'OrderModuleController');

});
