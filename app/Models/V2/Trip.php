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
        'route_name',
        'route_id',
        'driver_id',
        'driver_name',
        'vehicle_id',
        'vehicle_registration_number',
        'trip_initiate_date',
        'is_locked',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'trip_initiate_date' => 'date',
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

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
} 