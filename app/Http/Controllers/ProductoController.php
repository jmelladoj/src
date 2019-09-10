<?php

namespace App\Http\Controllers;

use App\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    //
    public function index_administrador($id){       
        $productos = Producto::where('servicio_id', $id)->orderBy('nombre', 'asc')->get();

        return [
            'productos' => $productos
        ];
    }

    public function crearOactualizar(Request $request){
        Producto::updateOrCreate(['id' => $request->producto_id], ['nombre' => $request->nombre, 'cantidad_sesiones' => $request->sesiones, 'servicio_id' => $request->servicio_id]);
    }

    public function eliminar(Request $request){
        Producto::find($request->id)->delete(); 
    }
}
