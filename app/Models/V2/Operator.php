<?php

namespace App\Models\V2;

use App\Models\V1\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operator extends Model
{
    public $timestamps = true;

    use SoftDeletes;

    protected $guarded = ["id", "created_at", "updated_at"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
