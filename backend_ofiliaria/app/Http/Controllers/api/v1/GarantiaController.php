<?php

namespace App\Http\Controllers\api\v1;
use App\Http\Controllers\Controller;
use App\Http\Controllers\api\v1\PersonaController;
use App\Models\Garantia;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mail;
use App\Mail\MailEnvioGarantia;
use App\Mail\MailAprobacionRechazoGarantia;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Enums\TokenAbility;

class GarantiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Obtener la URL base para el entorno actual (frontend)
        $controladorPersona = new PersonaController;
        $urlBase = $controladorPersona->urlBase();

        // 2. Determinar la URL base de AWS para el almacenamiento de archivos
        $urlBaseAWS = '';
        if ($urlBase === 'https://backend.ofiliaria.com.uy' || $urlBase === 'https://dev-backend.ofiliaria.com') {
            try {
                $urlAWS = Storage::disk('s3')->url('garantias-uy/imagenes/identificacion-test.jpg');
                $vectorUrlAWS = explode("/", $urlAWS);
                $urlBaseAWS = $vectorUrlAWS[0] . '//' . $vectorUrlAWS[2] . '/' . $vectorUrlAWS[3] . '/';
            } catch (\Exception $e) {
                error_log("Error al obtener URL de S3: " . $e->getMessage());
                $urlBaseAWS = '';
            }
        }

        // 3. Obtener parámetros de paginación y filtro de la solicitud de React.
        $perPage = $request->integer('per_page', 20);
        $page = $request->integer('page', 1);
        $estatusFiltro = $request->input('estatus', 'Todos');
        $agenciaAgenteFiltro = $request->input('agencia_agente', 'Todos');
        $arrendatarioFiltro = $request->input('arrendatario', 'Todos');
        $propietarioFiltro = $request->input('propietario', 'Todos');
        $aseguradoraFiltro = $request->input('aseguradora', 'Todos');
        $garantiaIdFiltro = $request->input('id', null);

        // 4. Construir la consulta base de garantías
        $query = Garantia::query()
            ->where('estatus_registro', 'Activo');

        // 5. Aplicar filtro de seguridad por rol (Agencia/Agente)
        if ($request->input('usuarioAdministrador') !== 'Sí') {
            if ($request->integer('rolUsuarioConectado') === 2) { // Rol de Agente
                $query->where('agente_id', $request->integer('agenteId'));
            } else { // Rol de Agencia
                $query->where('agencia_id', $request->integer('agenciaId'));
            }
        }
        
        // 6. Obtener todas las garantías que coinciden con el filtro de rol para usarlas en los filtros de la UI
        $garantiasParaFiltros = $query->get();

        // 7. Obtener los IDs de agencias y agentes para buscar sus nombres
        $agenciaIds = $garantiasParaFiltros->pluck('agencia_id')->filter()->unique();
        $agenteIds = $garantiasParaFiltros->pluck('agente_id')->filter()->unique();
        $userIds = $agenciaIds->merge($agenteIds)->unique();

        // 8. Obtener los nombres de los posts (agencias/agentes) de WordPress
        $postDetails = DB::connection('wordpress')->table('usermeta')
            ->whereIn('user_id', $userIds)
            ->where('meta_key', 'user_agent_id')
            ->join('posts', 'usermeta.meta_value', '=', 'posts.ID')
            ->select('usermeta.user_id', 'posts.post_title')
            ->get()
            ->keyBy('user_id');

        // 9. Crear un mapa de ID de usuario a nombre de post
        $userNombres = $postDetails->map(function ($detail) {
            return $detail->post_title;
        });

        // 10. Construir el mapa de nombres de agencia/agente para cada garantía
        $agenciaAgenteNombres = [];
        foreach ($garantiasParaFiltros as $garantia) {
            $nombreAgencia = $userNombres->get($garantia->agencia_id);
            $nombreAgente = $userNombres->get($garantia->agente_id);
            $nombreCompleto = 'N/A';

            if ($nombreAgencia && $nombreAgente && $garantia->agencia_id !== $garantia->agente_id) {
                $nombreCompleto = $nombreAgencia . '/ ' . $nombreAgente;
            } else if ($nombreAgencia) {
                $nombreCompleto = $nombreAgencia;
            } else if ($nombreAgente) {
                $nombreCompleto = $nombreAgente;
            }
            $agenciaAgenteNombres[$garantia->id] = $nombreCompleto;
        }

        // 11. Obtener personas (solicitantes, cosolicitantes y propietarios) para los filtros
        $garantiaIds = $garantiasParaFiltros->pluck('id');
        $personas = DB::table('personas')
            ->whereIn('garantia_id', $garantiaIds)
            ->where('estatus_registro', 'Activo')
            ->whereIn('tipo_arrendatario', ['Solicitante', 'Cosolicitante', 'Propietario'])
            ->get();

        // 12. Preparar los vectores para los filtros del frontend
        $filtroAgenciasAgentes = collect($agenciaAgenteNombres)->unique()->sort()->values()->all();
        $filtroAseguradoras = $garantiasParaFiltros->pluck('aseguradora')->unique()->sort()->values()->all();
        
        $formatPersonaFiltro = function ($p) {
            $tipoDoc = $p->tipo_documento_identidad === 'Cédula de identidad' ? 'Cédula' : ($p->tipo_documento_identidad === 'Pasaporte' ? 'Pasaporte' : $p->tipo_documento_identidad);
            return trim($p->nombres_arrendatario . ' ' . $p->apellidos_arrendatario) . ' - ' . $tipoDoc . ': ' . $p->numero_identidad_arrendatario;
        };

        $filtroArrendatarios = $personas->whereIn('tipo_arrendatario', ['Solicitante', 'Cosolicitante'])->map($formatPersonaFiltro)->unique()->sort()->values()->all();

        $filtroPropietarios = $personas->where('tipo_arrendatario', 'Propietario')->map($formatPersonaFiltro)->unique()->sort()->values()->all();


        // 13. Construir la consulta PRINCIPAL con los filtros aplicados
        $queryPrincipal = Garantia::with(['personas' => function ($query) {
            $query->where('estatus_registro', 'Activo')
                  ->whereIn('tipo_arrendatario', ['Solicitante', 'Cosolicitante', 'Propietario']);
        }])
        ->where('estatus_registro', 'Activo');

        // Aplicar filtro de seguridad por rol
        if ($request->input('usuarioAdministrador') !== 'Sí') {
            if ($request->integer('rolUsuarioConectado') === 2) { // Rol de Agente
                $queryPrincipal->where('agente_id', $request->integer('agenteId'));
            } else { // Rol de Agencia
                $queryPrincipal->where('agencia_id', $request->integer('agenciaId'));
            }
        }

        // Aplicar filtros de la UI
        if ($garantiaIdFiltro) {
            $queryPrincipal->where('id', $garantiaIdFiltro);
        }
        if ($estatusFiltro !== 'Todos') {
            if ($estatusFiltro === 'Borrador') {
                $queryPrincipal->whereIn('estatus_garantia', ['Paso 1, Borrador', 'Paso 2, Borrador', 'Paso 3, Borrador', 'Paso 4, Borrador']);
            } else {
                $queryPrincipal->where('estatus_garantia', 'like', $estatusFiltro . '%');
            }
        }
        if ($aseguradoraFiltro !== 'Todos') {
            $queryPrincipal->where('aseguradora', $aseguradoraFiltro);
        }
        if ($arrendatarioFiltro !== 'Todos') {
            $queryPrincipal->whereHas('personas', function ($q) use ($arrendatarioFiltro) {
                $q->whereIn('tipo_arrendatario', ['Solicitante', 'Cosolicitante'])
                  ->where(DB::raw("CONCAT(TRIM(nombres_arrendatario), ' ', TRIM(apellidos_arrendatario), ' - ', CASE WHEN tipo_documento_identidad = 'Cédula de identidad' THEN 'Cédula' WHEN tipo_documento_identidad = 'Pasaporte' THEN 'Pasaporte' ELSE tipo_documento_identidad END, ': ', numero_identidad_arrendatario)"), $arrendatarioFiltro);
            });
        }
        if ($propietarioFiltro !== 'Todos') {
            $queryPrincipal->whereHas('personas', function ($q) use ($propietarioFiltro) {
                $q->where('tipo_arrendatario', 'Propietario')
                  ->where(DB::raw("CONCAT(TRIM(nombres_arrendatario), ' ', TRIM(apellidos_arrendatario), ' - ', CASE WHEN tipo_documento_identidad = 'Cédula de identidad' THEN 'Cédula' WHEN tipo_documento_identidad = 'Pasaporte' THEN 'Pasaporte' ELSE tipo_documento_identidad END, ': ', numero_identidad_arrendatario)"), $propietarioFiltro);
            });
        }
        
        // 14. Aplicar filtro de agencia/agente (post-consulta, ya que el nombre no está en la BD)
        $garantiasPaginadas = $queryPrincipal
            ->orderBy('estatus_garantia', 'asc')
            ->orderBy('id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        $processedGarantias = $garantiasPaginadas->getCollection()->map(function ($garantia) use ($agenciaAgenteNombres, $userNombres) {
            $solicitante = $garantia->personas->firstWhere('tipo_arrendatario', 'Solicitante');
            $propietario = $garantia->personas->firstWhere('tipo_arrendatario', 'Propietario');
            
            $nombreAgencia = $userNombres->get($garantia->agencia_id);
            $nombreAgente = $userNombres->get($garantia->agente_id);
            $nombreCompleto = 'N/A';

            if ($nombreAgencia && $nombreAgente && $garantia->agencia_id !== $garantia->agente_id) {
                $nombreCompleto = $nombreAgencia . '/ ' . $nombreAgente;
            } else if ($nombreAgencia) {
                $nombreCompleto = $nombreAgencia;
            } else if ($nombreAgente) {
                $nombreCompleto = $nombreAgente;
            }

            return [
                'id' => $garantia->id,
                'estatus_garantia' => $garantia->estatus_garantia,
                'nombre_propiedad' => $garantia->nombre_propiedad,
                'aseguradora' => $garantia->aseguradora,
                'costo_alquiler' => $garantia->costo_alquiler,
                'moneda_propiedad' => $garantia->moneda_propiedad,
                'agencia_agente_nombre' => $nombreCompleto,
                'nombres_arrendatario' => $solicitante ? $solicitante->nombres_arrendatario : '',
                'apellidos_arrendatario' => $solicitante ? $solicitante->apellidos_arrendatario : '',
                'nombre_propietario' => $propietario ? $propietario->nombres_arrendatario . ' ' . $propietario->apellidos_arrendatario : '',
            ];
        });
        
        if ($agenciaAgenteFiltro !== 'Todos') {
            $processedGarantias = $processedGarantias->filter(function ($garantia) use ($agenciaAgenteFiltro) {
                return $garantia['agencia_agente_nombre'] === $agenciaAgenteFiltro;
            });
        }

        // 15. Manejo de caso: No se encontraron garantías.
        if ($processedGarantias->isEmpty() && $page === 1) {
            return response()->json([
                "codigoRetorno" => 1,
                "mensaje" => "No se encontraron garantías con los filtros aplicados",
                "urlBase" => $urlBase,
                "urlBaseAWS" => $urlBaseAWS,
                "filtros" => [
                    "agencias_agentes" => $filtroAgenciasAgentes,
                    "arrendatarios" => $filtroArrendatarios,
                    "propietarios" => $filtroPropietarios,
                    "aseguradoras" => $filtroAseguradoras,
                ]
            ], 200);
        }

        // 16. Devolver la respuesta en formato JSON.
        return response()->json([
            "codigoRetorno" => 0,
            "garantias" => $processedGarantias->values()->all(),
            "meta" => [
                "current_page" => $garantiasPaginadas->currentPage(),
                "last_page" => $garantiasPaginadas->lastPage(),
                "per_page" => $garantiasPaginadas->perPage(),
                "total" => $garantiasPaginadas->total(),
                "from" => $garantiasPaginadas->firstItem(),
                "to" => $garantiasPaginadas->lastItem(),
            ],
            "urlBase" => $urlBase,
            "urlBaseAWS" => $urlBaseAWS,
            "filtros" => [
                "agencias_agentes" => $filtroAgenciasAgentes,
                "arrendatarios" => $filtroArrendatarios,
                "propietarios" => $filtroPropietarios,
                "aseguradoras" => $filtroAseguradoras,
            ]
        ], 200);
    }
              
    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        $columnasGarantia = 
            [
                'agencia_id' => $request->agencia_id,
                'agente_id' => $request->agente_id,
                'aseguradora' => $request->aseguradora,
                'propiedad_id' => $request->propiedad_id,
                'numero_identidad_propiedad' => $request->numero_identidad_propiedad,
                'nombre_propiedad' => $request->nombre_propiedad,
                'direccion_propiedad' => $request->direccion_propiedad,
                'tipo_propiedad' => $request->tipo_propiedad,
                'tasa_cambio' => $request->tasa_cambio,
                'moneda_propiedad' => $request->moneda_propiedad,
                'costo_alquiler' => $request->costo_alquiler,

                'archivos_inventario' => $request->archivos_inventario,
                'etiqueta_inventario' => $request->etiqueta_inventario,
                'ubicaciones_inventario' => $request->ubicaciones_inventario,
                'contador_inventario' => $request->contador_inventario,

                'contrato' => $request->contrato,
                'ubicaciones_contrato' => $request->ubicaciones_contrato,

                'foto_inventario' => $request->foto_inventario,
                'ubicaciones_foto_inventario' => $request->ubicaciones_foto_inventario,

                'contrato_firmado' => $request->contrato_firmado,
                'etiqueta_contrato_firmado' => $request->etiqueta_contrato_firmado,
                'ubicaciones_contrato_firmado' => $request->ubicaciones_contrato_firmado,
                'contador_contrato_firmado' => $request->contador_contrato_firmado,

                'inventario_firmado' => $request->inventario_firmado,
                'etiqueta_inventario_firmado' => $request->etiqueta_inventario_firmado,
                'ubicaciones_inventario_firmado' => $request->ubicaciones_inventario_firmado,
                'contador_inventario_firmado' => $request->contador_inventario_firmado,

                'formulario_firmado' => $request->formulario_firmado,
                'etiqueta_formulario_firmado' => $request->etiqueta_formulario_firmado,
                'ubicaciones_formulario_firmado' => $request->ubicaciones_formulario_firmado,
                'contador_formulario_firmado' => $request->contador_formulario_firmado,

                'comprobante_pago' => $request->comprobante_pago,
                'etiqueta_comprobante_pago' => $request->etiqueta_comprobante_pago,
                'ubicaciones_comprobante_pago' => $request->ubicaciones_comprobante_pago,
                'contador_comprobante_pago' => $request->contador_comprobante_pago,

                'estatus_garantia' => $request->estatus_garantia,
                'estatus_registro' => $request->estatus_registro
            ];

        $columnasPersona = 
            [
                'tipo_arrendatario' => 'Solicitante',
                'tipo_persona' => $request->tipo_persona,
                'numero_identidad_arrendatario' => $request->numero_identidad_arrendatario,	
                'nombres_arrendatario' => $request->nombres_arrendatario,
                'apellidos_arrendatario' => $request->apellidos_arrendatario,
                'numero_identidad_empresa' => $request->numero_identidad_empresa,
                'empresa' => $request->empresa,
                'cargo_empresa' => $request->cargo_empresa,
                'email_arrendatario' => $request->email_arrendatario,
                'telefono_arrendatario' => $request->telefono_arrendatario,
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

                'estatus_registro' => $request->estatus_registro
            ];

        $garantia = Garantia::create($columnasGarantia);

        if (!$garantia)
        {
            $datos =
                [
                    "codigoRetorno" => 1,
                    "mensaje" => "No se pudo crear la garantia"
                ];
                return response()->json($datos, 200);
        }
        
        $idGarantia = $garantia->id;

        $garantia = Garantia::find($idGarantia);

        $garantia->personas()->create($columnasPersona);

        $columnasPersona['tipo_arrendatario'] = 'Cosolicitante';

        $garantia->personas()->create($columnasPersona);

        $datos = 
            [
                "codigoRetorno" => 0,
                "id" => $idGarantia,
                "garantia" => $garantia,
                "personas" => $garantia->personas
            ];
        return response()->json($datos, 200);
    }
    
    /**
     * Display the specified resource.
     */
    
    public function show($id)
    {
        $garantia = Garantia::find($id);

        if (!$garantia)
        {
            $datos = 
                [
                    "codigoRetorno" => 1,
                    "mensaje" => "Garantia no encontrada"
                ];
            return response()->json($datos, 200);
        }
 
        if ($garantia->ubicaciones_inventario != null)
        {
            $vectorUbicaciones = json_decode($garantia->ubicaciones_inventario, true);
            $garantia->ubicaciones_inventario = $vectorUbicaciones;   
        }
        if ($garantia->ubicaciones_contrato_firmado != null)
        {
            $vectorUbicaciones = json_decode($garantia->ubicaciones_contrato_firmado, true);
            $garantia->ubicaciones_contrato_firmado = $vectorUbicaciones;   
        }
        if ($garantia->ubicaciones_inventario_firmado != null)
        {
            $vectorUbicaciones = json_decode($garantia->ubicaciones_inventario_firmado, true);
            $garantia->ubicaciones_inventario_firmado = $vectorUbicaciones;   
        }
        if ($garantia->ubicaciones_formulario_firmado != null)
        {
            $vectorUbicaciones = json_decode($garantia->ubicaciones_formulario_firmado, true);
            $garantia->ubicaciones_formulario_firmado = $vectorUbicaciones;   
        }
        if ($garantia->ubicaciones_comprobante_pago != null)
        {
            $vectorUbicaciones = json_decode($garantia->ubicaciones_comprobante_pago, true);
            $garantia->ubicaciones_comprobante_pago = $vectorUbicaciones;   
        }

        $personas = $garantia->personas()
                        ->where('estatus_registro', '=', 'Activo')
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
                
        $datos =
            [
                "codigoRetorno" => 0,
                "garantia" => $garantia,
                "personas" => $personas
            ];
        return response()->json($datos, 200);
    }
    
    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, $id)
    {
        $mensaje = '';
        $inputsAseguradoras = [];
        $ambiente = '';
        $directorio = '';
        $disco = '';
        $mensajeArchivosContratoFirmado = '';
        $ubicacionesArchivos = [];
        $nombreArchivo = '';
        $archivos = [];

        $garantia = Garantia::find($id);

        if (!$garantia)
        {
            $mensaje = "Garantía no encontrada";
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
            $datosRecibidos = $datos;

            $columnasPaso1 = 
                [
                    'aseguradora' => $datos->aseguradora,
                    'estatus_garantia' => $datos->estatus_garantia,
                ];

            $columnasPaso2 = 
                [     
                    'propiedad_id' => $datos->propiedad_id,
                    'numero_identidad_propiedad' => $datos->numero_identidad_propiedad,
                    'nombre_propiedad' => $datos->nombre_propiedad,
                    'direccion_propiedad' => $datos->direccion_propiedad,
                    'tipo_propiedad' => $datos->tipo_propiedad,
                    'tasa_cambio' => $datos->tasa_cambio,
                    'moneda_propiedad' => $datos->moneda_propiedad,
                    'costo_alquiler' => $datos->costo_alquiler,
                    'estatus_garantia' => $datos->estatus_garantia,
                ];

            $columnasPaso3 = 
            [
                'estatus_garantia' => $datos->estatus_garantia,
            ];

            $columnasPaso4 = 
            [
                'estatus_garantia' => $datos->estatus_garantia,
            ];

            $columnasPaso5 = 
            [
                'estatus_garantia' => $datos->estatus_garantia,
            ];

            $columnasPaso6 = 
            [
                'estatus_garantia' => $datos->estatus_garantia,
            ];
            $columnasPaso7 = 
            [
                'tipo_contrato' => $datos->tipo_contrato,
                'fecha_inicio_alquiler' => $datos->fecha_inicio_alquiler,
                'plazo_alquiler' => $datos->plazo_alquiler,
                'tipo_plazo_alquiler' => $datos->tipo_plazo_alquiler,
                'tipo_pago_alquiler' => $datos->tipo_pago_alquiler,
                'regimen_ajuste_alquiler' => $datos->regimen_ajuste_alquiler,
                'departamento_firma' => $datos->departamento_firma,
                'ciudad_firma' => $datos->ciudad_firma,
                'terminos_condiciones' => $datos->terminos_condiciones,
                'banco' => $datos->banco,
                'numero_sucursal_banco' => $datos->numero_sucursal_banco,
                'nombres_titular_cuenta' => $datos->nombres_titular_cuenta,
                'apellidos_titular_cuenta' => $datos->apellidos_titular_cuenta,
                'moneda' => $datos->moneda,
                'numero_cuenta' => $datos->numero_cuenta,
                'tipo_cuenta' => $datos->tipo_cuenta,
                'notas_garantia' => $datos->notas_garantia,
                'texto_contrato' => $datos->texto_contrato,
                'estatus_garantia' => $datos->estatus_garantia,
            ];
            $columnasPaso8 = 
            [
                'contrato' => $datos->contrato,
                'texto_contrato' => $datos->texto_contrato,
                'estatus_garantia' => $datos->estatus_garantia,
                // 'estatus_garantia' => 'Paso 7.1, Esperando datos del contrato'
            ];

            $columnasPaso9 = 
            [
                'tipo_inventario' => $datos->tipo_inventario,
                'descripcion_inventario' => $datos->descripcion_inventario,
                'observaciones_inventario' => $datos->observaciones_inventario,
                'archivos_inventario' => $datos->archivos_inventario,
                'etiqueta_inventario' => $datos->etiqueta_inventario,
                'estatus_garantia' => $datos->estatus_garantia,
                // 'estatus_garantia' => 'Paso 8, Esperando carga del inventario'
            ];

            $columnasPaso10 = 
            [
                'contrato_firmado' => $datos->contrato_firmado,
                'etiqueta_contrato_firmado' => $datos->etiqueta_contrato_firmado,
                'inventario_firmado' => $datos->inventario_firmado,
                'etiqueta_inventario_firmado' => $datos->etiqueta_inventario_firmado,
                'formulario_firmado' => $datos->formulario_firmado,
                'etiqueta_formulario_firmado' => $datos->etiqueta_formulario_firmado,
                'estatus_garantia' => $datos->estatus_garantia,
                // 'estatus_garantia' => 'Paso 9, Esperando firma del contrato'
            ];

            $columnasPaso11 = 
            [
                'comprobante_pago' => $datos->comprobante_pago,
                'etiqueta_comprobante_pago' => $datos->etiqueta_comprobante_pago,
                'estatus_garantia' => $datos->estatus_garantia,
                // 'estatus_garantia' => 'Paso 10, Esperando pago'
            ];

            $actualizarColumnas = [];

            $vectorEstatusGarantiaAnterior = explode(",", $garantia->estatus_garantia);
            $pasoGarantiaAnterior = $vectorEstatusGarantiaAnterior[0];

            $vectorEstatusGarantia = explode(",", $datos->estatus_garantia);
            $pasoGarantia = $vectorEstatusGarantia[0];

            switch ($pasoGarantia) 
            {
                case 'Paso 1':
                    $actualizarColumnas = $columnasPaso1;
                    break;
                case 'Paso 2':
                    $actualizarColumnas = $columnasPaso2;
                    break;
                case 'Paso 3':
                    $actualizarColumnas = $columnasPaso3;
                    break;
                case 'Paso 4':
                    $actualizarColumnas = $columnasPaso4;
                    break;
                case 'Paso 5':
                    $actualizarColumnas = $columnasPaso5;
                    break;
                case 'Paso 6':
                    $actualizarColumnas = $columnasPaso6;
                    break;
                case 'Paso 7.1':
                    $actualizarColumnas = $columnasPaso7;
                    break;
                case 'Paso 7.2':
                    $actualizarColumnas = $columnasPaso7;
                    break;
                case 'Paso 8':
                    $actualizarColumnas = $columnasPaso8;
                    break;
                case 'Paso 9':
                    $actualizarColumnas = $columnasPaso9;
                    break;
                case 'Paso 10':
                    $actualizarColumnas = $columnasPaso10;
                    break;
                case 'Paso 11':
                    $actualizarColumnas = $columnasPaso11;
                    break;
            }

            $garantia->update($actualizarColumnas);

            $directorio = 'garantias';
            $disco = 'public';
            $ambiente = $datos->ambiente;

            if ($pasoGarantia == 'Paso 6')
            {
                if ($datos->inputs_aseguradoras != null)
                {
                    Mail::to('garantias@ofiliaria.com.uy')->send(new MailEnvioGarantia($datos));
                }
            }

            if ($pasoGarantiaAnterior == 'Paso 6')
            {
                if ($datos->personas != null && $datos->personas != '')
                {
                    foreach ($datos->personas as $persona)
                    {
                        if ($persona->tipo_arrendatario == 'Solicitante')
                        {
                            $datos->correo_notificaciones = $persona->email_arrendatario;
                            break;
                        }
                    }
                }
                if ($pasoGarantia == 'Paso 7.1')
                {
                    $datos->titulo_correo = 'Notificación de Aprobación de la garantía';
                    Mail::to($datos->correo_notificaciones)->send(new MailAprobacionRechazoGarantia($datos));
                }
                elseif ($pasoGarantia == 'Paso 7.2')
                {
                    $datos->titulo_correo = 'Notificación de Rechazo de la garantía';
                    Mail::to($datos->correo_notificaciones)->send(new MailAprobacionRechazoGarantia($datos));
                }
            }

            if ($pasoGarantia == 'Paso 8')
            {       
                if ($ambiente == 'Producción')
                {
                    $controladorPersona = new PersonaController;
                    $urlBase = $controladorPersona->urlBase();            
                    if ($urlBase == 'https://backend.ofiliaria.com.uy')
                    {
                        $directorio = 'garantias-uy/produccion/'.$id.'/contrato';
                    }
                    else
                    {
                        $directorio = 'garantias-uy/'.$id.'/contrato';
                    }
                    $disco = 's3';
                }

                Storage::disk($disco)->delete($directorio.'/'.$id.'-contrato.pdf');
                $html = '<div style="text-align: justify; padding: 1rem;">'.$garantia->texto_contrato.'</div>';
                $pdf= Pdf::loadHTML($html);
                Storage::disk($disco)->put($directorio.'/'.$id.'-contrato.pdf', $pdf->download());
                $garantia->ubicaciones_contrato = $directorio.'/'.$id.'-contrato.pdf'; 
                $garantia->save();
            }
        }
        else
        {
            $mensaje = "No se recibieron los datos de la garantía";
            $datos = 
                [
                    "codigoRetorno" => 2,
                    "mensaje" => $mensaje,
                ];
            return response()->json($datos, 200);            
        }

        $personas = $garantia->personas()
                        ->where('estatus_registro', '=', 'Activo')
                        ->get();

        $mensaje = "Los datos se actualizaron exitosamente";
        $datos =
            [
                "codigoRetorno" => 0,
                "mensaje" => $mensaje,
                "personas" => $personas,
                "mensajeArchivosContratoFirmado" => $mensajeArchivosContratoFirmado,
                "datosRecibidos" => $datosRecibidos
            ];
        return response()->json($datos, 200);
    }

    public function actualizarEstatusGarantia($id, $estatusGarantia)
    {
        $mensaje = '';

        $garantia = Garantia::find($id);

        if (!$garantia)
        {
            $mensaje = "Garantía no encontrada";
            $datos =
                [
                    "codigoRetorno" => 1,
                    "mensaje" => $mensaje,
                ];
            return $datos;
        }

        $garantia->estatus_garantia = $estatusGarantia;

        $garantia->save();

        $mensaje = "El estatus de la garantía se actualizó exitosamente";
        $datos =
            [
                "codigoRetorno" => 0,
                "mensaje" => $mensaje,
            ];
        return $datos;
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

        $garantia = Garantia::find($id);

        if (!$garantia)
        {
            $codigoRetorno = 1;
            $mensaje = "Garantía no encontrada";
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
            $controladorPersona = new PersonaController;
            $urlBase = $controladorPersona->urlBase();            
            if ($urlBase == 'https://backend.ofiliaria.com.uy')
            {
                $directorio = 'garantias-uy/produccion/'.$id.'/'.$sub_directorio;
            }
            else
            {
                $directorio = 'garantias-uy/'.$id.'/'.$sub_directorio;
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

                if ($garantia->$ubicaciones_archivos == null)
                {
                    $ubicacionesArchivos[] = $ubicacionArchivo;
                }
                elseif ($multiples_archivos == false)
                {
                    $ubicacionesArchivos = json_decode($garantia->$ubicaciones_archivos);
                    if (empty($ubicacionesArchivos) == false)
                    {
                        Storage::disk($disco)->delete($ubicacionesArchivos[0]);
                    }
                    $ubicacionesArchivos = [$ubicacionArchivo];
                }
                else
                {
                    $ubicacionesArchivos = json_decode($garantia->$ubicaciones_archivos);
                    array_push($ubicacionesArchivos, $ubicacionArchivo);
                }

                $garantia->$ubicaciones_archivos = json_encode($ubicacionesArchivos);
                $contadorArchivos = $garantia->$contador_archivos + 1;
                $garantia->$contador_archivos = $contadorArchivos;
                $garantia->save();
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

        $garantia = Garantia::find($id);

        if (!$garantia)
        {
            $codigoRetorno = 1;
            $mensaje = "Garantía no encontrada";
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

        $ubicacionesArchivosBusqueda = json_decode($garantia->$ubicaciones_archivos);
        foreach ($ubicacionesArchivosBusqueda as $ubicacion) 
        {
            if ($ubicacion != $ubicacion_archivo)
            {
                $ubicacionesArchivos[] = $ubicacion;
            }
        }
        $garantia->$ubicaciones_archivos = json_encode($ubicacionesArchivos);
        $contadorArchivos = $garantia->$contador_archivos - 1;
        $garantia->$contador_archivos = $contadorArchivos;
        $garantia->save();
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

    public function fotoInventario(Request $request, $id)
    {
        $codigoRetorno = 0;
        $mensaje = '';
        $directorio = 'garantias';
        $disco = 'public';
        $ubicacionesInventario = [];
        $controladorPersona = new PersonaController;
        $urlBase = $controladorPersona->urlBase();
        if ($urlBase == 'https://backend.ofiliaria.com.uy' || $urlBase == 'https://dev-backend.ofiliaria.com')
        {
            $urlBaseInventario = 'https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/'; 
        }
        else
        {
            $urlBaseInventario = 'http://localhost/ofiliaria/backend_ofiliaria/public/storage/';
        }
        $htmlInventario = '<div><h3>Foto Inventario</h3>';
        $base64 = '';
        $ambiente = '';
        $foto_inventario = '';

        $garantia = Garantia::find($id);

        if (!$garantia)
        {
            $codigoRetorno = 1;
            $mensaje = "Garantía no encontrada";
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
            $ambiente = $datos->ambiente;
            $foto_inventario = $datos->foto_inventario;    
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

        if ($ambiente == 'Producción')
        {
            if ($urlBase == 'https://backend.ofiliaria.com.uy')
            {
                $directorio = 'garantias-uy/produccion/'.$id.'/inventario';
            }
            else
            {
                $directorio = 'garantias-uy/'.$id.'/inventario';
            } 
            $disco = 's3';
        }

        if ($garantia->ubicaciones_foto_inventario != null)
        {
            $ubicacionesInventario = json_decode($garantia->ubicaciones_foto_inventario);
            Storage::disk($disco)->delete($ubicacionesInventario[0]);
            $garantia->foto_inventario = null;
            $garantia->ubicaciones_foto_inventario = null; 
            $garantia->save();
        }
        
        if ($garantia->ubicaciones_inventario != null)
        {
            $ubicacionesInventario = json_decode($garantia->ubicaciones_inventario);
            foreach ($ubicacionesInventario as $ubicacionInventario)
            {
                $path = $urlBaseInventario.$ubicacionInventario;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                $htmlInventario .= '<div><img src="'.$base64.'" height="250" /></div><br /><br />';
            }
            $htmlInventario .= '</div>';
            $pdfInventario = Pdf::loadHTML($htmlInventario);
            Storage::disk($disco)->put($directorio.'/'.$id.'-foto-inventario.pdf', $pdfInventario->download());
            $garantia->foto_inventario = $foto_inventario;
            $garantia->ubicaciones_foto_inventario = json_encode([$directorio.'/'.$id.'-foto-inventario.pdf']); 
            $garantia->save();
        }
        
        $mensaje = 'El archivo PDF del inventario se generó exitosamente';

        $respuesta =
            [
                "codigoRetorno" => $codigoRetorno,
                "mensaje" => $mensaje,
                "ubicacionesFotoInventario" => $garantia->ubicaciones_foto_inventario
            ];
        return response()->json($respuesta, 200);
    }

    public function obtenerFotoInventario(Request $request, $id)
    {
        $codigoRetorno = 0;
        $mensaje = '';
        $garantia = Garantia::find($id);

        if (!$garantia)
        {
            $codigoRetorno = 1;
            $mensaje = "Garantía no encontrada";
            $respuesta =
                [
                    "codigoRetorno" => $codigoRetorno,
                    "mensaje" => $mensaje,
                ];
            return response()->json($respuesta, 200);
        }
        
        $mensaje = 'Registro de garantía encontrado';

        $respuesta =
            [
                "codigoRetorno" => $codigoRetorno,
                "mensaje" => $mensaje,
                "garantia" => $garantia
            ];
        return response()->json($respuesta, 200);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {        
        $garantia = Garantia::find($id);

        if (!$garantia)
        {
            $mensaje = "Garantía no encontrada";
            $datos =
                [
                    "codigoRetorno" => 1,
                    "mensaje" => $mensaje,
                ];
            return $datos;
        }

        $garantia->update(['estatus_registro' => 'Eliminado']);  

        if (!$garantia)
        {
            $datos =
                [
                    "codigoRetorno" => 2,
                    "mensaje" => "No se pudo eliminar la garantía"
                ];
            return response()->json($datos, 200);
        }

        $personas = $garantia->personas()
                        ->where('estatus_registro', '=', 'Activo')
                        ->get();

        $controladorPersona = new PersonaController;
                
        foreach ($personas as $persona)
        {
            $personaEliminada = $controladorPersona->destroy($persona->id);
        }
        
        $datos =
            [
                "codigoRetorno" => 0,
                "mensaje" => 'Garantia eliminada' 
            ];

        return response()->json($datos, 200);    
    }
}