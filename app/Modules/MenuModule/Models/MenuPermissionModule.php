<?php

namespace App\Modules\MenuModule\Models;

use Illuminate\Database\Eloquent\Model;

class MenuPermissionModule extends Model {

    protected $table = 'menuPermissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'menuId', 'permissionId','status'
    ];

}
