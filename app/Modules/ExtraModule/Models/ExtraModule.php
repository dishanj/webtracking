<?php

namespace App\Modules\ExtraModule\Models;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class ExtraModule extends BaseModel {

    protected $table = 'WebBanner';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bannerName', 'logoName','description','status','createdById','updatedById','deletedById'
    ];

}
