<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InportacionInmuebleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    
    public function show($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
    public function importarInmueblesMeli($token)
    {
        Ubicacion::truncate();

        $pais = '';
        $provincia = '';
        $ciudad = '';
        $barrio = '';
        $sub_barrio = '';
		
		$vectorRespuestaUbicacion = $this->buscarUbicacion('/countries/', 'UY', $token);
        $pais = $vectorRespuestaUbicacion->name;
        $provincia = '';
        $ciudad = '';
        $barrio = '';
        $sub_barrio = '';
        $respuestaInsertarUbicacion = $this->insertarubicacion($pais, $provincia, $ciudad, $barrio, $sub_barrio, $vectorRespuestaUbicacion); 
        if (empty($vectorRespuestaUbicacion->states) == false)
        {
            $ubicaciones = $vectorRespuestaUbicacion->states;
            foreach ($ubicaciones as $ubicacion)
            {
                $vectorRespuestaUbicacion = $this->buscarUbicacion('/states/', $ubicacion->id, $token);
                $provincia = $vectorRespuestaUbicacion->name;
                $ciudad = '';
                $barrio = '';
                $sub_barrio = '';
                $respuestaInsertarUbicacion = $this->insertarubicacion($pais, $provincia, $ciudad, $barrio, $sub_barrio, $vectorRespuestaUbicacion); 
                if (empty($vectorRespuestaUbicacion->cities) == false)
                {
                    $ubicaciones = $vectorRespuestaUbicacion->cities;
                    foreach ($ubicaciones as $ubicacion)
                    {
                        $vectorRespuestaUbicacion = $this->buscarUbicacion('/cities/', $ubicacion->id, $token);
                        $ciudad = $vectorRespuestaUbicacion->name;
                        $barrio = '';
                        $sub_barrio = '';
                        $respuestaInsertarUbicacion = $this->insertarubicacion($pais, $provincia, $ciudad, $barrio, $sub_barrio, $vectorRespuestaUbicacion); 
                        if (empty($vectorRespuestaUbicacion->neighborhoods) == false)
                        {
                            $ubicaciones = $vectorRespuestaUbicacion->neighborhoods;
                            foreach ($ubicaciones as $ubicacion)
                            {
                                $vectorRespuestaUbicacion = $this->buscarUbicacion('/neighborhoods/', $ubicacion->id, $token);
                                $barrio = $vectorRespuestaUbicacion->name;
                                $sub_barrio = '';
                                $respuestaInsertarUbicacion = $this->insertarubicacion($pais, $provincia, $ciudad, $barrio, $sub_barrio, $vectorRespuestaUbicacion); 
                            }
                        }
                    }
                }
            }
        }
        exit('Proceso de carga de ubicaciones finalizado');
	}
	
	public function buscarUbicacion($directorio = null, $ubicacion, $token = null)
	{
		$url = "https://api.mercadolibre.com/classified_locations".$directorio.$ubicacion;
		$headers = 
			[
				"Authorization: Bearer ".$token
			];
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$respuesta_ubicacion = curl_exec($curl);
		curl_close($curl);
		$vector_respuesta_ubicacion = json_decode($respuesta_ubicacion);
		return $vector_respuesta_ubicacion;
	}

	public function insertarUbicacion($pais = null, $provincia = null, $ciudad = null, $barrio = null, $sub_barrio = null, $vectorRespuestaUbicacion = null)
	{
        $columnasUbicacion = 
        [
            'pais' => $pais,
            'provincia' => $provincia,
            'ciudad' => $ciudad,
            'barrio' => $barrio,
            'sub_barrio' => $sub_barrio,
            'nombre_ubicacion' => $vectorRespuestaUbicacion->name,
            'identificador_meli' => $vectorRespuestaUbicacion->id
        ];

        $ubicacion = Ubicacion::create($columnasUbicacion);

        if (!$ubicacion)
        {
            $datos =
                [
                    "codigoRetorno" => 1,
                    "mensaje" => "No se pudo crear la ubicacion ".$vectorRespuestaUbicacion->id." ".$vectorRespuestaUbicacion->name
                ];
                return response()->json($datos, 200);
        }
	}
}
