<?php

namespace App\Models\V2;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'org_code',
        'name',
        'email',
        'message',
    ];
}
