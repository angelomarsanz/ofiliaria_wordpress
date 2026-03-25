<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\api\v1\DepartamentoController;

class UbicacionController extends Controller
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
    public function importarUbicacionesMeli($token)
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
    public function zonasMeliInfocasas()
    {
        $provinciaMeli = '';
        $ciudadMeli = '';
        $departamentoInfocasas = '';
        $zonaInfocasas = '';
        $idDepartamentoInfocasas = 0;
        $idZonaInfocasas = 0;
        $ubicacionEncontrada = 0;

        $ubicacions = 
            DB::table('ubicacions')
                ->where([['ubicacions.ciudad', '!=', '']])
                ->get();
        $controladorDepartamento = new DepartamentoController;

        $busquedaDepartamentosZonas = $controladorDepartamento->index('zonasMeliInfocasas');
        $departamentosZonas = $busquedaDepartamentosZonas['departamentos_zonas'];

        foreach ($ubicacions as $indiceUbicacion => $ubicacion)
        {
            $provinciaMeli = $this->normalizarCadena($ubicacion->provincia);
            $ciudadMeli = $this->normalizarCadena($ubicacion->ciudad);
            $idDepartamentoInfocasas = 0;
            $idZonaInfocasas = 0; 
            $ubicacionEncontrada = 0;
            foreach ($departamentosZonas as $indiceDepartamentoZona => $departamentoZona)
            {
                $departamentoInfocasas = $this->normalizarCadena($departamentoZona->departamento);
                $zonaInfocasas = $this->normalizarCadena($departamentoZona->zona);
                if ($provinciaMeli == $departamentoInfocasas)
                {
                    $ubicacionEncontrada = 1;
                    $idDepartamentoInfocasas = $departamentoZona->id_departamento_infocasas;
                }
                if ($ciudadMeli == $zonaInfocasas)
                {
                    $ubicacionEncontrada = 1;
                    $idZonaInfocasas = $departamentoZona->id_zona_infocasas;
                    break;
                }
            }
            if ($ubicacionEncontrada == 1)
            {
                $columnasActualizar = 
                    [
                        'id_departamento_infocasas' => $idDepartamentoInfocasas,
                        'id_zona_infocasas' => $idZonaInfocasas
                    ];
                $ubicacionActualizar = Ubicacion::find($ubicacion->id);
                $ubicacionActualizar->update($columnasActualizar);
            }
        }

        $datos = 
            [
                "codigoRetorno" => 0,
                "ubicacions" => $ubicacions,
                "departamentosZonas" => $departamentosZonas
            ];

        return response()->json($datos, 200);
    }
    public function normalizarCadena($cadena) 
	{
		// Convierte a minúsculas
		$cadena = mb_strtolower($cadena, 'UTF-8');
	
		// Remover acentos 
		$cadena = str_replace(
			array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'ü', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'Ü'),
			array('a', 'e', 'i', 'o', 'u', 'n', 'u', 'a', 'e', 'i', 'o', 'u', 'n', 'u'),
			$cadena
		);
	
		return $cadena;
	}
}
