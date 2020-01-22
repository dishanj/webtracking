<?php

namespace App\Modules\PermissionModule\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionModule extends Model {

    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description','status','created_by'
    ];

}
