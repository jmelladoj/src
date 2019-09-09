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

    public function crearOactualizar(Request $request){
        Servicio::updateOrCreate(['id' => $request->servicio_id], ['nombre' => $request->nombre]);
    }

    public function activarOdesactivar(Request $request){
        $request->accion == 1 ? Servicio::find($request->id)->delete() : Servicio::withTrashed()->where('id' , $request->id)->restore(); 
    }
}
