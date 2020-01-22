<?php

namespace App\Modules\OrderModule\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModule extends Model {

    protected $table = 'efl_orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'json', 'status'
    ];


}
