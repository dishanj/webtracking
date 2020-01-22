<?php

/**
 * @Author: Thisaru
 * @Date:   2018-10-09 12:43:27
 * @Last Modified by:   Thisaru
 * @Last Modified time: 2018-10-09 13:27:37
 */
namespace App\Modules\RoleModule\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermissionModule extends Model {

    protected $table = 'rolePermissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'roleId', 'permissionId','status'
    ];
}