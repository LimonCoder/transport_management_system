<?php

namespace App\Models\V2;

use Illuminate\Database\Eloquent\Model;

class FuelType extends Model
{
    protected $table = 'fuel_type';
    public $timestamps = true;
    protected $fillable = [
        'org_code',
        'name',
        'status',
        'created_by',
        'updated_by',
    ];
} 