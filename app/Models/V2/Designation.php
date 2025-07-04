<?php

namespace App\Models\V2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designation extends Model
{
    protected $table = 'designation';
    public $timestamps = true;

    use SoftDeletes;
    protected $fillable = ['name'];
}
