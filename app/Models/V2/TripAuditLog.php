<?php

namespace App\Models\V2;

use App\Models\V1\User;
use Illuminate\Database\Eloquent\Model;

class TripAuditLog extends Model
{
    public $timestamps = false;

    protected $table = 'trips_audit_log';

    protected $guarded = ["id"];

    protected $fillable = [
        'primary_id',
        'org_code',
        'route_id',
        'driver_id',
        'driver_name',
        'vehicle_id',
        'vehicle_registration_number',
        'start_location',
        'destination',
        'start_time',
        'end_time',
        'distance_km',
        'purpose',
        'fuel_cost',
        'total_cost',
        'is_locked',
        'status',
        'action',
        'created_by'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'distance_km' => 'decimal:2',
        'fuel_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'is_locked' => 'boolean',
        'created_at' => 'datetime',
    ];

    // Relationships
    public function trip()
    {
        return $this->belongsTo(Trip::class, 'primary_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
} 