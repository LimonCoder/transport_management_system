<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $table = 'users';
    public $timestamps = true;
    protected $guarded = ["id", "created_at", "updated_at"];


    use SoftDeletes;

    protected $dates = ['deleted_at'];

}
