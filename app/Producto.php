<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['nombre', 'cantidad_sesiones', 'servicio_id'];
    protected $dates = ['deleted_at'];
}
