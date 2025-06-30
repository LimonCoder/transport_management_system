<?php

namespace App\Models\V2;

use App\Models\V1\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    public $timestamps = true;

    use SoftDeletes;

    protected $table = 'drivers';

    protected $guarded = ["id", "created_at", "updated_at"];


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relationships
    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Relationships to trips
    public function trips(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Trip::class, 'driver_id');
    }
}
