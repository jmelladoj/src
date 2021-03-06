<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['nombre'];
    protected $dates = ['deleted_at'];
}
