<?php

Route::group(['module' => 'OrderModule', 'middleware' => ['api'], 'namespace' => 'App\Modules\OrderModule\Controllers'], function() {

    Route::resource('OrderModule', 'OrderModuleController');

});
