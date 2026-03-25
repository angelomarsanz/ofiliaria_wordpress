<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\api\v1\GarantiaController;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personas = 
            DB::table('personas')
                ->where('estatus_registro', '=', 'Activo')
                ->get();

        if ($personas->isEmpty()) 
        {
            $datos = 
                [
                    "codigoRetorno" => 1,
                    "mensaje" => "No se encontraron registros de personas",            
                ];
            return response()->json($datos, 200);
        }
                
        $datos = 
        [
            "codigoRetorno" => 0,
            "personas" => $personas
        ];
        return response()->json($datos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $columnasPersona = 
            [
                'garantia_id' => $request->garantia_id,
                'tipo_arrendatario' => $request->tipo_arrendatario,
                'tipo_documento_identidad' => $request->tipo_documento_identidad,
                'tipo_persona' => $request->tipo_persona,
                'numero_identidad_arrendatario' => $request->numero_identidad_arrendatario,
                'nombres_arrendatario' => $request->nombres_arrendatario,
                'apellidos_arrendatario' => $request->apellidos_arrendatario,
                'numero_identidad_empresa' => $request->numero_identidad_empresa,
                'empresa' => $request->empresa,
                'cargo_empresa' => $request->cargo_empresa,
                'email_arrendatario' => $request->email_arrendatario,
                'telefono_arrendatario' => $request->telefono_arrendatario,
                'moneda_ingreso' => $request->moneda_ingreso,
                'monto_ingreso' => $request->monto_ingreso,
                'ingreso' => $request->ingreso,
                'sueldo' => $request->sueldo,
                
                'identidad' => $request->identidad,
                'etiqueta_identidad' => $request->etiqueta_identidad,
                'ubicacion_identidad' => $request->ubicacion_identidad,
                'contador_identidad' => $request->contador_identidad,
                
                'rec_sueldo' => $request->rec_sueldo,
                'etiqueta_rec_sueldo' => $request->etiqueta_rec_sueldo,
                'ubicaciones_rec_sueldo' => $request->ubicaciones_rec_sueldo,
                'contador_rec_sueldo' => $request->contador_rec_sueldo,
                
                'cert_ing_mod' => $request->cert_ing_mod,
                'etiqueta_cert_ing_mod' => $request->etiqueta_cert_ing_mod,
                'ubicaciones_cert_ing_mod' => $request->ubicaciones_cert_ing_mod,
                'contador_cert_ing_mod' => $request->contador_cert_ing_mod,
                
                'dgi' => $request->dgi,
                'etiqueta_dgi' => $request->etiqueta_dgi,
                'ubicaciones_dgi' => $request->ubicaciones_dgi,
                'contador_dgi' => $request->contador_dgi,
                
                'cert_dgi_caja' => $request->cert_dgi_caja,
                'etiqueta_cert_dgi_caja' => $request->etiqueta_cert_dgi_caja,
                'ubicaciones_cert_dgi_caja' => $request->ubicaciones_cert_dgi_caja,
                'contador_cert_dgi_caja' => $request->contador_cert_dgi_caja,
                
                'balance' => $request->balance,
                'etiqueta_balance' => $request->etiqueta_balance,
                'ubicaciones_balance' => $request->ubicaciones_balance,
                'contador_balance' => $request->contador_balance,

                'rut' => $request->rut,
                'etiqueta_rut' => $request->etiqueta_rut,
                'ubicaciones_rut' => $request->ubicaciones_rut,
                'contador_rut' => $request->contador_rut,

                'contrato_social' => $request->contrato_social,
                'etiqueta_contrato_social' => $request->etiqueta_contrato_social,
                'ubicaciones_contrato_social' => $request->ubicaciones_contrato_social,
                'contador_contrato_social' => $request->contador_contrato_social,

                'cert_uni' => $request->cert_uni,
                'etiqueta_cert_uni' => $request->etiqueta_cert_uni,
                'ubicaciones_cert_uni' => $request->ubicaciones_cert_uni,
                'contador_cert_uni' => $request->contador_cert_uni,

                'domicilio_persona' => $request->domicilio_persona,
                'departamento_domicilio' => $request->departamento_domicilio,
                'ciudad_domicilio' => $request->ciudad_domicilio,
                'clasificacion_persona_fisica' => $request->clasificacion_persona_fisica,
                'clasificacion_persona_juridica' => $request->clasificacion_persona_juridica,
                'notas_persona' => $request->nota_persona,

                'estatus_registro' => $request->estatus_registro
            ];

        $persona = Persona::create($columnasPersona);

        $personas = DB::table('personas')
            ->where([['garantia_id', '=', $persona->garantia_id], ['estatus_registro', '=', 'Activo']])
            ->get();

        $mensaje = "El registro de la persona se creó exitosamente";
        $datos =
            [
                "codigoRetorno" => 0,
                "mensaje" => $mensaje,
                "personas" => $personas
            ];
        return response()->json($datos, 200);
    }

    /**
     * Display the specified resource.
     */
    
    public function show($id)
    {
        $persona = DB::table('personas')->find($id);

        if (!$person)
        {
            $datos = 
                [
                    "codigoRetorno" => 1,
                    "mensaje" => "Persona no encontrada"
                ];
            return response()->json($datos, 200);
        }

        $datos =
            [
                "codigoRetorno" => 0,
                "persona" => $persona
            ];
        return response()->json($datos, 200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $mensaje = '';

        $persona = Persona::find($id);

        if (!$persona)
        {
            $mensaje = "Persona no encontrada";
            $datos =
                [
                    "codigoRetorno" => 1,
                    "mensaje" => $mensaje,
                ];
            return response()->json($datos, 404);
        }

        if ($request->input('datos'))
        {
            $datos = json_decode($request->input('datos'));

            $actualizarColumnas = 
                [
                    'tipo_arrendatario' => $datos->tipo_arrendatario,
                    'tipo_persona' => $datos->tipo_persona,
                    'tipo_documento_identidad' => $datos->tipo_documento_identidad,
                    'numero_identidad_arrendatario' => $datos->numero_identidad_arrendatario,
                    'nombres_arrendatario' => $datos->nombres_arrendatario,
                    'apellidos_arrendatario' => $datos->apellidos_arrendatario,
                    'numero_identidad_empresa' => $datos->numero_identidad_empresa,
                    'empresa' => $datos->empresa,
                    'cargo_empresa' => $datos->cargo_empresa,
                    'email_arrendatario' => $datos->email_arrendatario,
                    'telefono_arrendatario' => $datos->telefono_arrendatario,
                    'moneda_ingreso' => $datos->moneda_ingreso,
                    'monto_ingreso' => $datos->monto_ingreso,
                    'ingreso' => $datos->ingreso,
                    'sueldo' => $datos->sueldo,
                    
                    'identidad' => $datos->identidad,
                    'etiqueta_identidad' => $datos->etiqueta_identidad,
                    
                    'rec_sueldo' => $datos->rec_sueldo,
                    'etiqueta_rec_sueldo' => $datos->etiqueta_rec_sueldo,
                    
                    'cert_ing_mod' => $datos->cert_ing_mod,
                    'etiqueta_cert_ing_mod' => $datos->etiqueta_cert_ing_mod,
                    
                    'dgi' => $datos->dgi,
                    'etiqueta_dgi' => $datos->etiqueta_dgi,
                    
                    'cert_dgi_caja' => $datos->cert_dgi_caja,
                    'etiqueta_cert_dgi_caja' => $datos->etiqueta_cert_dgi_caja,

                    'balance' => $datos->balance,
                    'etiqueta_balance' => $datos->etiqueta_balance,

                    'rut' => $datos->rut,
                    'etiqueta_rut' => $datos->etiqueta_rut,

                    'contrato_social' => $datos->contrato_social,
                    'etiqueta_contrato_social' => $datos->etiqueta_contrato_social,

                    'cert_uni' => $datos->cert_uni,
                    'etiqueta_cert_uni' => $datos->etiqueta_cert_uni,

                    'domicilio_persona' => $datos->domicilio_persona,
                    'departamento_domicilio' => $datos->departamento_domicilio,
                    'ciudad_domicilio' => $datos->ciudad_domicilio,    
                    'clasificacion_persona_fisica' => $datos->clasificacion_persona_fisica,
                    'clasificacion_persona_juridica' => $datos->clasificacion_persona_juridica,
                    'notas_persona' => $datos->notas_persona,
                    
                    'estatus_registro' => $datos->estatus_registro
                ];

            $persona->update($actualizarColumnas);

            $controladorGarantia = new GarantiaController;

            $respuesta = $controladorGarantia->actualizarEstatusGarantia($datos->garantia_id, $datos->estatus_garantia);

            if ($respuesta['codigoRetorno'] != 0)
            {
                $mensaje = "No se pudo actualizar el estatus de la garantía";
                $datos = 
                    [
                        "codigoRetorno" => 2,
                        "mensaje" => $mensaje,
                    ];
                return response()->json($datos, 200);            
            }
        }
        else
        {
            $mensaje = "No se recibieron los datos de la persona";
            $datos = 
                [
                    "codigoRetorno" => 2,
                    "mensaje" => $mensaje,
                ];
            return response()->json($datos, 200);            
        }
        
        $personas = DB::table('personas')
            ->where([['garantia_id', '=', $persona->garantia_id], ['estatus_registro', '=', 'Activo']])
            ->get();

        foreach ($personas as $persona)
        {            
            $vectorUbicaciones = json_decode($persona->ubicacion_identidad, true);
            $persona->ubicacion_identidad = $vectorUbicaciones;

            $vectorUbicaciones = json_decode($persona->ubicaciones_rec_sueldo, true);
            $persona->ubicaciones_rec_sueldo = $vectorUbicaciones;

            $vectorUbicaciones = json_decode($persona->ubicaciones_cert_ing_mod, true);
            $persona->ubicaciones_cert_ing_mod = $vectorUbicaciones;

            $vectorUbicaciones = json_decode($persona->ubicaciones_dgi, true);
            $persona->ubicaciones_dgi = $vectorUbicaciones;

            $vectorUbicaciones = json_decode($persona->ubicaciones_cert_dgi_caja, true);
            $persona->ubicaciones_cert_dgi_caja = $vectorUbicaciones;

            $vectorUbicaciones = json_decode($persona->ubicaciones_balance, true);
            $persona->ubicaciones_balance = $vectorUbicaciones;

            $vectorUbicaciones = json_decode($persona->ubicaciones_rut, true);
            $persona->ubicaciones_rut = $vectorUbicaciones;

            $vectorUbicaciones = json_decode($persona->ubicaciones_contrato_social, true);
            $persona->ubicaciones_contrato_social = $vectorUbicaciones;

            $vectorUbicaciones = json_decode($persona->ubicaciones_cert_uni, true);
            $persona->ubicaciones_cert_uni = $vectorUbicaciones;            
        }
    
    
        $mensaje = "Los datos se actualizaron exitosamente";
        $datos =
            [
                "codigoRetorno" => 0,
                "mensaje" => $mensaje,
                "personas" => $personas,
            ];
        return response()->json($datos, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $persona = Persona::find($id);

        if (!$persona)
        {
            $mensaje = "Persona con id '.$id.' no encontrada";
            $datos =
                [
                    "codigoRetorno" => 1,
                    "mensaje" => $mensaje,
                ];
            return $datos;
        }

        $persona->update(['estatus_registro' => 'Eliminado']);  

        if (!$persona)
        {
            $datos =
                [
                    "codigoRetorno" => 2,
                    "mensaje" => "No se pudo eliminar el registro de la persona con id ".$id
                ];
            return response()->json($datos, 200);
        }

        $personas = DB::table('personas')
        ->where([['garantia_id', '=', $persona->garantia_id], ['estatus_registro', '=', 'Activo']])
        ->get();

        $datos =
            [
                "codigoRetorno" => 0,
                "mensaje" => 'Persona eliminada',
                "personas" => $personas 
            ];

        return response()->json($datos, 200);    
    }

    public function archivosBase64($persona)
    {
        $convertirArchivos = [];
        $archivosBase64 = [];
        $urlBase = $this->urlBase();

        if ($urlBase == 'http://localhost')
        {
            $disco = 'public';
        }
        else
        {
            $disco = 's3';
        }

        if ($persona->ubicacion_identidad != null && $persona->ubicacion_identidad != 'ubicacion_identidad')
        {
            $convertirArchivos[] = [$persona->ubicacion_identidad];    
            $archivosConvertidos64 = $this->conversionArchivos64($convertirArchivos, $disco);
            $archivosBase64['identidad'] = $archivosConvertidos64;
        }
        
        if ($persona->ubicaciones_rec_sueldo != null && $persona->ubicaciones_rec_sueldo != 'ubicaciones_rec_sueldo')
        {
            $convertirArchivos = json_decode($persona->ubicaciones_rec_sueldo);    
            $archivosConvertidos64 = $this->conversionArchivos64($convertirArchivos, $disco);
            $archivosBase64['rec_sueldo'] = $archivosConvertidos64;
        }

        if ($persona->ubicaciones_cert_ing_mod != null && $persona->ubicaciones_cert_ing_mod != 'ubicaciones_cert_ing_mod')
        {
            $convertirArchivos = json_decode($persona->ubicaciones_cert_ing_mod);    
            $archivosConvertidos64 = $this->conversionArchivos64($convertirArchivos, $disco);
            $archivosBase64['cert_ing_mod'] = $archivosConvertidos64;
        }

        if ($persona->ubicaciones_dgi != null && $persona->ubicaciones_dgi != 'ubicaciones_dgi')
        {
            $convertirArchivos = json_decode($persona->ubicaciones_dgi);    
            $archivosConvertidos64 = $this->conversionArchivos64($convertirArchivos, $disco);
            $archivosBase64['dgi'] = $archivosConvertidos64;
        }

        if ($persona->ubicaciones_cert_dgi_caja != null && $persona->ubicaciones_cert_dgi_caja != 'ubicaciones_cert_dgi_caja')
        {
            $convertirArchivos = json_decode($persona->ubicaciones_cert_dgi_caja);    
            $archivosConvertidos64 = $this->conversionArchivos64($convertirArchivos, $disco);
            $archivosBase64['cert_dgi_caja'] = $archivosConvertidos64;
        }

        if ($persona->ubicaciones_balance != null && $persona->ubicaciones_balance != 'ubicaciones_balance')
        {
            $convertirArchivos = json_decode($persona->ubicaciones_balance);    
            $archivosConvertidos64 = $this->conversionArchivos64($convertirArchivos, $disco);
            $archivosBase64['balance'] = $archivosConvertidos64;
        }

        if ($persona->ubicaciones_rut != null && $persona->ubicaciones_rut != 'ubicaciones_rut')
        {
            $convertirArchivos = json_decode($persona->ubicaciones_rut);    
            $archivosConvertidos64 = $this->conversionArchivos64($convertirArchivos, $disco);
            $archivosBase64['rut'] = $archivosConvertidos64;
        }

        if ($persona->ubicaciones_contrato_social != null && $persona->ubicaciones_contrato_social != 'ubicaciones_contrato_social')
        {
            $convertirArchivos = json_decode($persona->ubicaciones_contrato_social);    
            $archivosConvertidos64 = $this->conversionArchivos64($convertirArchivos, $disco);
            $archivosBase64['contrato_social'] = $archivosConvertidos64;
        }

        if ($persona->ubicaciones_cert_uni != null && $persona->ubicaciones_cert_uni != 'ubicaciones_cert_uni')
        {
            $convertirArchivos = json_decode($persona->ubicaciones_cert_uni);    
            $archivosConvertidos64 = $this->conversionArchivos64($convertirArchivos, $disco);
            $archivosBase64['cert_uni'] = $archivosConvertidos64;
        }
        
        $datos =
            [
                "codigoRetorno" => 0,
                "archivos" => $archivosBase64,              
            ];
        return $datos;
    }

    public function urlBase()
    {
        if(isset($_SERVER['HTTPS']))
        {
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        }
        else{
            $protocol = 'http';
        }
        return $protocol . "://" . $_SERVER['HTTP_HOST'];
    }

    public function conversionArchivos64($convertirArchivos, $disco)
    {
        $archivoBase64 = [];
        foreach ($convertirArchivos as $archivo)
        {
            $vectorNombre = explode("/", $archivo[0]);
            if ($disco == 'public')
            {
                $nombreArchivo = $vectorNombre[1];
                $urlArchivo = 'http://localhost/ofiliaria/backend_ofiliaria/public/storage/garantias/'.$nombreArchivo;
            }
            else
            {
                $nombreArchivo = $vectorNombre[3];
                $urlArchivo = Storage::disk($disco)->url($archivo[0]);
            }
            $extensionArchivo = $this->extensionArchivo($nombreArchivo, true);
            
            $archivoBase64 = base64_encode(file_get_contents($urlArchivo));
            $archivosBase64[] = ['nombreArchivo' => $nombreArchivo, 'extensionArchivo' => $extensionArchivo, 'archivoBase64' => $archivoBase64];
        }
        return $archivosBase64;
    }

    public function extensionArchivo($file, $tolower=true)
    {
        $file = basename($file);
        $pos = strrpos($file, '.');

        if ($file == '' || $pos === false) {
            return '';
        }

        $extension = substr($file, $pos+1);
        if ($tolower) {
            $extension = strtolower($extension);
        }

        return $extension;
    }
    public function guardarArchivos(Request $request, $id)
    {
        $codigoRetorno = 0;
        $mensaje = '';
        $directorio = 'garantias';
        $disco = 'public';
        $ubicacionArchivo = '';
        $ubicacionesArchivos = [];
        $contadorArchivos = 0;

        $persona = Persona::find($id);

        if (!$persona)
        {
            $codigoRetorno = 1;
            $mensaje = "Persona no encontrada";
            $respuesta =
                [
                    "codigoRetorno" => $codigoRetorno,
                    "mensaje" => $mensaje,
                ];
            return response()->json($respuesta, 200);
        }

        if ($request->input('datos'))
        {
            $datos = json_decode($request->input('datos'));
        }
        else
        {
            $codigoRetorno = 2;
            $mensaje = "No se recibieron los datos";
            $respuesta =
                [
                    "codigoRetorno" => $codigoRetorno,
                    "mensaje" => $mensaje,
                ];
            return response()->json($respuesta, 200);
        } 

        $multiples_archivos = $datos->multiples_archivos;
        $sub_directorio = $datos->sub_directorio;
        $nombre_campo = $datos->nombre_campo;
        $ubicaciones_archivos = $datos->ubicaciones_archivos;
        $contador_archivos = $datos->contador_archivos;

        if ($datos->ambiente == 'Producción')
        {
            $urlBase = $this->urlBase();
            if ($urlBase == 'https://backend.ofiliaria.com.uy')
            {
                $directorio = 'garantias-uy/produccion/'.$persona->garantia_id.'/'.$sub_directorio;
            }
            else
            {
                $directorio = 'garantias-uy/'.$persona->garantia_id.'/'.$sub_directorio;
            }
            $disco = 's3';
        }

        if ($request->hasFile("archivo_cargado"))
        {
            $mensaje = 'Si se recibió el archivo';

            if ($request->file('archivo_cargado')->isValid()) 
            {           
                $nombreArchivo = $id.'-'.$nombre_campo.'-'.uniqid().'.'.$request->file('archivo_cargado')->getClientOriginalExtension();
                $ubicacionArchivo = $request->file('archivo_cargado')->storeAs($directorio, $nombreArchivo, $disco);

                if ($persona->$ubicaciones_archivos == null)
                {
                    $ubicacionesArchivos[] = $ubicacionArchivo;
                }
                elseif ($multiples_archivos == false)
                {
                    $ubicacionesArchivos = json_decode($persona->$ubicaciones_archivos);
                    if (empty($ubicacionesArchivos) == false)
                    {
                        Storage::disk($disco)->delete($ubicacionesArchivos[0]);
                    }
                    $ubicacionesArchivos = [$ubicacionArchivo];
                }
                else
                {
                    $ubicacionesArchivos = json_decode($persona->$ubicaciones_archivos);
                    array_push($ubicacionesArchivos, $ubicacionArchivo);
                }

                $persona->$ubicaciones_archivos = json_encode($ubicacionesArchivos);
                $contadorArchivos = $persona->$contador_archivos + 1;
                $persona->$contador_archivos = $contadorArchivos;
                $persona->save();
            }
        }
        else
        {
            $codigoRetorno = 3;
            $mensaje = 'No se recibió el archivo';
        }

        $respuesta =
            [
                "codigoRetorno" => $codigoRetorno,
                "mensaje" => $mensaje,
                "ubicacionesArchivos" => $ubicacionesArchivos,
                "contadorArchivos" => $contadorArchivos,
                "datos" => $datos
            ];
        return response()->json($respuesta, 200);
    }

    public function eliminarArchivo(Request $request, $id)
    {
        $codigoRetorno = 0;
        $mensaje = '';
        $disco = 'public';
        $ubicacionArchivo = '';
        $ubicacionesArchivosBusqueda = [];
        $ubicacionesArchivos = [];
        $contadorArchivos = 0;

        $persona = Persona::find($id);

        if (!$persona)
        {
            $codigoRetorno = 1;
            $mensaje = "Pesona no encontrada";
            $respuesta =
                [
                    "codigoRetorno" => $codigoRetorno,
                    "mensaje" => $mensaje,
                ];
            return response()->json($respuesta, 200);
        }

        if ($request->input('datos'))
        {
            $datos = json_decode($request->input('datos'));
        }
        else
        {
            $codigoRetorno = 2;
            $mensaje = "No se recibieron los datos";
            $respuesta =
                [
                    "codigoRetorno" => $codigoRetorno,
                    "mensaje" => $mensaje,
                ];
            return response()->json($respuesta, 200);
        } 

        $ubicacion_archivo = $datos->ubicacion_archivo;
        $nombre_campo = $datos->nombre_campo;
        $ubicaciones_archivos = $datos->ubicaciones_archivos;
        $contador_archivos = $datos->contador_archivos;

        if ($datos->ambiente == 'Producción')
        {
            $disco = 's3';
        }

        $ubicacionesArchivosBusqueda = json_decode($persona->$ubicaciones_archivos);
        foreach ($ubicacionesArchivosBusqueda as $ubicacion) 
        {
            if ($ubicacion != $ubicacion_archivo)
            {
                $ubicacionesArchivos[] = $ubicacion;
            }
        }
        $persona->$ubicaciones_archivos = json_encode($ubicacionesArchivos);
        $contadorArchivos = $persona->$contador_archivos - 1;
        $persona->$contador_archivos = $contadorArchivos;
        $persona->save();
        Storage::disk($disco)->delete($ubicacion_archivo);

        $respuesta =
            [
                "codigoRetorno" => $codigoRetorno,
                "mensaje" => $mensaje,
                "ubicacionesArchivos" => $ubicacionesArchivos,
                "contadorArchivos" => $contadorArchivos
            ];
        return response()->json($respuesta, 200);
    }
}
