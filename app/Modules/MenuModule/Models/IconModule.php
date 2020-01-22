<?php

namespace App\Modules\MenuModule\Models;

use Illuminate\Database\Eloquent\Model;

class IconModule extends Model {

    protected $table = 'tbl_icon';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'icon','unicode'
    ];

}
