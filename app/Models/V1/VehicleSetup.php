<?php

namespace App\Models\V1;

use App\helpers\GlobalHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class VehicleSetup extends Model
{

    protected $table = 'vehicles';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'org_code',
        'registration_number',
        'model',
        'capacity',
        'fuel_type_id',
        'images',
        'status',
        'version',
        'created_by',
        'updated_by'
    ];

}
