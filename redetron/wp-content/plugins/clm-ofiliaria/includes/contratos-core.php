<?php
//Funciones CRUD módulo contratos

//Consulta de id
function contratos_ofiliaria_obtener_por_id($id) {
    global $wpdb;
    $tabla = $wpdb->prefix . 'contratos';

    if (!is_numeric($id)) {
        return false;
    }

    $contrato = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $tabla WHERE id = %d", $id),
        ARRAY_A
    );

    if ($contrato) {
        // Des-serializar los IDs de los documentos
        $documentos_ids = maybe_unserialize($contrato['documentos']);
        
        // Inicializar un array para los detalles de los documentos
        $documentos_detalles = [];

        // Si hay documentos, obtener la URL y el título de cada uno
        if (is_array($documentos_ids) && !empty($documentos_ids)) {
            foreach ($documentos_ids as $doc_id) {
                // Obtener la URL del archivo adjunto
                $url = wp_get_attachment_url($doc_id);
                // Obtener el nombre del archivo adjunto
                $titulo = get_the_title($doc_id);
                
                if ($url) {
                    $documentos_detalles[] = [
                        'id' => $doc_id,
                        'titulo' => $titulo,
                        'url' => $url,
                    ];
                }
            }
        }
        
        // Reemplazar los IDs por los detalles del documento en el array del contrato
        $contrato['documentos'] = $documentos_detalles;
    }

    return $contrato ?: false;
}

//registrar contrato
function contratos_ofiliaria_actualizar($id, $data) {
    global $wpdb;
    $tabla = $wpdb->prefix . 'contratos';

    // Asegurarse de que el ID sea válido
    if (!$id || empty($data) || !is_array($data)) {
        return false;
    }

    // Sanitizar cada campo del arreglo $data
    $campos_permitidos = [
        'prop_nombre', 'prop_apellido', 'prop_doc_tipo', 'prop_doc_num',
        'prop_email', 'prop_telefono', 'arr_nombre', 'arr_apellido',
        'arr_doc_tipo', 'arr_doc_num', 'arr_email', 'arr_telefono',
        'titulo_contrato', 'garantia', 'fecha_inicio', 'fecha_fin',
        'monto', 'divisa', 'ciclo_pago', 'documentos'
    ];

    $datos_actualizados = [];
    foreach ($campos_permitidos as $campo) {
        if (isset($data[$campo])) {
            $datos_actualizados[$campo] = $data[$campo];
        }
    }

    // Realizar la actualización
    $resultado = $wpdb->update(
        $tabla,
        $datos_actualizados,
        ['id' => $id],
        null,
        ['%d']
    );

    return $resultado !== false;
}