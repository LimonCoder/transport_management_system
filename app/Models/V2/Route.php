<?php

namespace App\Models\V2;

use App\Models\V1\User;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    public $timestamps = true;

    protected $table = 'routes';


    protected $guarded = ["id", "created_at", "updated_at"];

    protected $fillable = [
        'org_code',
        'title',
        'details',
        'status',
        'created_by',
        'updated_by'
    ];

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
        return $this->hasMany(Trip::class, 'route_id');
    }
} 