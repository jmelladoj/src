<?php

namespace App\Http\Controllers;

use App\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    //
    public function index_administrador(Request $request){       
        $servicios = Servicio::orderBy('nombre', 'asc')->withTrashed()->get();

        return [
            'servicios' => $servicios
        ];
    }
}
