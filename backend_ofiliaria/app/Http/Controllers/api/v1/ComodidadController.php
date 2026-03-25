<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Comodidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComodidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comodidades = 
            DB::table('comodidads')
                ->get();
    
        $datos = 
            [
                "codigoRetorno" => 0,
                "comodidades" => $comodidades
            ];
        return response()->json($datos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Comodidad $comodidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comodidad $comodidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comodidad $comodidad)
    {
        //
    }
    // Para probar las notificaciones de Mercado Libre e Infocasas
    public function notificaciones(Request $request)
    {
        $codigo_retorno = 0;
        $mensaje = 'La notificación se recibió exitosamente';
        $resource = '';
        $userId = 0;
        $topicoIdAplicacionIntentos = '';
        
        if (isset($request->resource))
        {
            $userId = $request->user_id;
            $resource = $request->resource;
            $topicoIdAplicacionIntentos = $request->topic.', '.$request->application_id.', '.$request->attempts;
        }
        
        $datos =
            [
                'id_infocasas' => $userId,
                'descripcion' => $resource,
                'tipo_propiedad_aplica' => $topicoIdAplicacionIntentos 
            ];
        $comodidad = Comodidad::create($datos);
        if (!$comodidad)
        {
            $codigo_retorno = 1;
            $mensaje = 'No se pudo registrar la notificación';
        }
        $datos =
            [
                "codigoRetorno" => $codigo_retorno,
                "mensaje" => $mensaje
            ];
        return response()->json($datos, 200);
    }
}