<?php

namespace App\Modules\MenuModule\Models;

use Illuminate\Database\Eloquent\Model;

class MenuModule extends Model {

    protected $table = 'tbl_menu';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'menu_name', 'url','parent_id','icon','icon_id','sequence','status'
    ];

}
