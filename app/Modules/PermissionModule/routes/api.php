<?php

Route::group(['module' => 'PermissionModule', 'middleware' => ['api'], 'namespace' => 'App\Modules\PermissionModule\Controllers'], function() {

    Route::resource('PermissionModule', 'PermissionModuleController');

});
