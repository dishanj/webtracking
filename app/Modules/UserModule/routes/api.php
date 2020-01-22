<?php

Route::group(['module' => 'UserModule', 'middleware' => ['api'], 'namespace' => 'App\Modules\UserModule\Controllers'], function() {

    Route::resource('UserModule', 'UserModuleController');

});
