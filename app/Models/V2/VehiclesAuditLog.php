<?php

namespace App\Models\V2;

use Illuminate\Database\Eloquent\Model;

class VehiclesAuditLog extends Model
{
    public $timestamps = false;

    protected $table = 'vehicles_audit_log';

    protected $guarded = ["id"];

    protected $fillable = [
        'primary_id',
        'org_code',
        'registration_number',
        'model',
        'capacity',
        'fuel_type_id',
        'images',
        'status',
        'action',
        'created_by',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'capacity' => 'integer',
        'fuel_type_id' => 'integer',
        'org_code' => 'integer',
        'primary_id' => 'integer',
    ];
} 