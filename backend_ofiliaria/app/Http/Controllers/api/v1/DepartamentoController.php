<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($origen = null)
    {
        $departamentos_zonas = 
            DB::table('departamentos')
                ->join('zonas', 'departamentos.id', '=', 'zonas.departamento_id')
                ->get();
    
        $datos = 
            [
                "codigo_retorno" => 0,
                "departamentos_zonas" => $departamentos_zonas
            ];
        if ($origen != null)
        { 
            return $datos;
        }
        else
        {
            return response()->json($datos, 200);
        }
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
    public function show(Departamento $departamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departamento $departamento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departamento $departamento)
    {
        //
    }
}
