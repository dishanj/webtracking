<?php

namespace App\Modules\RoleModule\Models;

use Illuminate\Database\Eloquent\Model;

class RoleModule extends Model {

    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'name','permissions'
    ];

}
