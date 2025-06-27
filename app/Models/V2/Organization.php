<?php

namespace App\Models\V2;

use App\Models\V1\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'organizations';

    protected $guarded = ["id", "created_at", "updated_at"];

    protected $fillable = [
        'org_code',
        'name',
        'address',
        'org_type',
        'created_by',
        'updated_by'
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Relationship to users
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class, 'org_code', 'org_code');
    }

    // Relationship to get organization operator
    public function operator(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'org_code', 'org_code')
            ->where('user_type', 'operator')
            ->where('is_special_user', 1);
    }
} 