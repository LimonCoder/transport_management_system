<?php

namespace App\Models\V2;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'notices';
    protected $fillable = ['title', 'details', 'status', 'created_by', 'updated_by', 'org_code'];
}