<?php

namespace App\Models\V2;

use App\Models\V1\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    public $timestamps = true;
    protected $table = 'vehicles';

    use SoftDeletes;

    protected $guarded = ["id", "created_at", "updated_at"];

    protected $fillable = [
        'org_code',
        'registration_number',
        'model',
        'capacity',
        'fuel_type_id',
        'images',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'capacity' => 'integer',
        'fuel_type_id' => 'integer',
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

    // Relationships to trips
    public function trips()
    {
        return $this->hasMany(Trip::class, 'vehicle_id');
    }
} 