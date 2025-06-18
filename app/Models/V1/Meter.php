<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meter extends Model 
{

    protected $table = 'meter';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

}