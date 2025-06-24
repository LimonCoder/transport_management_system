<?php

namespace App\Models\V2;

use App\Models\V1\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    public $timestamps = true;

    use SoftDeletes;

    protected $guarded = ["id", "created_at", "updated_at"];

    protected $fillable = [
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
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'distance_km' => 'decimal:2',
        'fuel_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'is_locked' => 'boolean',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // You can add more relationships here like:
    // public function route() { return $this->belongsTo(Route::class); }
    // public function driver() { return $this->belongsTo(Driver::class); }
    // public function vehicle() { return $this->belongsTo(Vehicle::class); }
} 