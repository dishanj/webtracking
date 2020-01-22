<?php

Route::group(['module' => 'RoleModule', 'middleware' => ['api'], 'namespace' => 'App\Modules\RoleModule\Controllers'], function() {

    Route::resource('RoleModule', 'RoleModuleController');

});
