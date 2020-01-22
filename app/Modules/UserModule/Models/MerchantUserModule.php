<?php

namespace App\Modules\UserModule\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantUserModule extends Model {

    //
    protected $table = 'MerchantUser';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'merchantId','userId','status'
    ];

}
