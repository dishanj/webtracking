<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class eflOrder extends Model
{
    protected $table = "efl_orders";

    protected $fillable = [
        'json',
        'status',
        'deleted_at'
    ];
}
