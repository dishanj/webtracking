<?php

Route::group(['module' => 'ExtraModule', 'middleware' => ['api'], 'namespace' => 'App\Modules\ExtraModule\Controllers'], function() {

    Route::resource('ExtraModule', 'ExtraModuleController');

});
