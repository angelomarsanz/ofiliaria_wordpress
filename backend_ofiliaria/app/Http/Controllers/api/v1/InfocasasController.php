<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class InfocasasController extends Controller
{
    public function prueba()
    {
        return response()->json([
            'mensaje' => 'API de Infocasas funcionando correctamente.',
        ], 200);
    }
    /**
     * Guarda un archivo XML de Infocasas en AWS S3.
     *
     * Esta rutina recibe la URL de un archivo XML generado en WordPress,
     * lo lee y lo sube a un bucket de S3. Primero elimina cualquier
     * archivo existente para la misma inmobiliaria.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function guardarXml(Request $request)
    {
        // 1. Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'id_usuario_wordpress' => 'required|integer',
            'url_xml' => 'required|url',
            'ambiente' => 'required|string|in:Produccion,Desarrollo',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'codigoRetorno' => 1,
                'mensaje' => 'Datos de entrada inválidos.',
                'errores' => $validator->errors(),
            ], 400);
        }

        $idUsuario = $request->input('id_usuario_wordpress');
        $urlXml = $request->input('url_xml');
        $ambiente = $request->input('ambiente');
        $disco = 's3';

        // 2. Determinar el directorio en S3 según el ambiente
        $directorioBase = 'infocasas/';
        if ($ambiente === 'Produccion') {
            $directorio = $directorioBase . 'produccion/ofiliaria_' . $idUsuario;
        } else {
            $directorio = $directorioBase . 'ofiliaria_' . $idUsuario;
        }

        $nombreArchivo = 'ofiliaria_' . $idUsuario . '.xml';
        $rutaCompletaS3 = $directorio . '/' . $nombreArchivo;

        try {
            // 3. Obtener el contenido del archivo XML desde la URL
            // Crear el contexto base para SSL, útil para entornos de desarrollo
            $contextOptions = [
                "ssl" => [
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ],
            ];

            // Si el ambiente es de Desarrollo, añadir cabecera de autenticación básica
            if ($ambiente === 'Desarrollo') {
                $auth = base64_encode("ofiliaria:UYsite2025");
                $contextOptions['http'] = [
                    'header' => "Authorization: Basic " . $auth
                ];
            }
            
            $context = stream_context_create($contextOptions);
            $contenidoXml = @file_get_contents($urlXml, false, $context);

            if ($contenidoXml === false) {
                Log::error("Infocasas: No se pudo leer el archivo XML desde la URL: " . $urlXml);
                return response()->json([
                    'codigoRetorno' => 2,
                    'mensaje' => 'No se pudo leer el archivo XML desde la URL proporcionada.',
                ], 500);
            }

            // 4. Guardar el nuevo archivo XML en S3 (sobrescribirá el anterior si existe)
            $guardado = Storage::disk($disco)->put($rutaCompletaS3, $contenidoXml);

            if (!$guardado) {
                Log::error("Infocasas: Falló la subida del archivo a S3 en la ruta: " . $rutaCompletaS3);
                return response()->json([
                    'codigoRetorno' => 3,
                    'mensaje' => 'Ocurrió un error al guardar el archivo en el servidor de almacenamiento.',
                ], 500);
            }

            // 5. Devolver respuesta de éxito
            return response()->json([
                'codigoRetorno' => 0,
                'mensaje' => 'Archivo XML de Infocasas para el usuario ' . $idUsuario . ' guardado exitosamente en S3.',
                'ruta' => $rutaCompletaS3,
            ], 200);

        } catch (\Exception $e) {
            Log::error("Infocasas: Excepción al procesar XML para usuario {$idUsuario}. Error: " . $e->getMessage());
            return response()->json([
                'codigoRetorno' => 4,
                'mensaje' => 'Ha ocurrido una excepción en el servidor: ' . $e->getMessage(),
            ], 500);
        }
    }
}