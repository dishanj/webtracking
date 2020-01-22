<?php

Route::group(['module' => 'MenuModule', 'middleware' => ['api'], 'namespace' => 'App\Modules\MenuModule\Controllers'], function() {

    Route::resource('MenuModule', 'MenuModuleController');

});
