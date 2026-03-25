<?php

// ===================
// Guardar nuevo contrato
// ===================
add_action('wp_ajax_guardar_contrato_ajax', 'guardar_contrato_ajax_handler');

function guardar_contrato_ajax_handler() {
    global $wpdb;
    $tabla = $wpdb->prefix . 'contratos';

    check_ajax_referer('crear_contrato_nonce', 'nonce');

    if (!is_user_logged_in()) {
        wp_send_json_error('No autorizado.');
    }

    $data = $_POST;
    $user_id = get_current_user_id();
    $user_agent_id = intval(get_user_meta($user_id, 'user_agent_id', true));

    if (!$user_agent_id || get_post_status($user_agent_id) !== 'publish') {
        wp_send_json_error('No tienes permisos para realizar esta acción.');
    }
    
    if (empty($data['titulo_contrato']) || empty($data['fecha_inicio']) || empty($data['fecha_fin'])) {
        wp_send_json_error('Faltan campos obligatorios.');
    }
    
    // 1. Crear el post para el contrato principal
    $post_data = array(
        'post_title'    => sanitize_text_field($data['titulo_contrato']),
        'post_status'   => 'publish',
        'post_type'     => 'contratos_externos', // Tipo de post personalizado
        'post_author'   => $user_id,
    );
    $contrato_post_id = wp_insert_post($post_data);

    if (is_wp_error($contrato_post_id)) {
        wp_send_json_error('Error al crear el post del contrato.');
    }

    // 2. Procesar archivos adjuntos y asociarlos al post del contrato
    $archivos_ids = [];
    if (!empty($_FILES['documentos'])) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        
        // Formatear el array de archivos para que WordPress lo entienda correctamente
        $files = $_FILES['documentos'];
        
        foreach ($files['name'] as $key => $value) {
            if ($files['error'][$key] === UPLOAD_ERR_OK) {
                // Crear un array de archivo único para cada iteración
                $file = array(
                    'name'     => $files['name'][$key],
                    'type'     => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error'    => $files['error'][$key],
                    'size'     => $files['size'][$key],
                );
                
                // Usamos media_handle_sideload con el array de archivo único
                $attachment_id = media_handle_sideload($file, $contrato_post_id);

                if (is_wp_error($attachment_id)) {
                    // Si falla la subida, eliminamos el post del contrato para evitar huérfanos
                    wp_delete_post($contrato_post_id, true);
                    wp_send_json_error('Error al subir un archivo: ' . $attachment_id->get_error_message());
                } else {
                    $archivos_ids[] = $attachment_id;
                }
            }
        }
    }

    // 3. Insertar en la tabla de contratos
    // Formato de la tabla (agregamos 'id_post')
    $formato = array(
        '%d', // id_post
        '%d', // user_id
        '%d', // user_agent_id
        '%s', // prop_nombre
        '%s', // prop_apellido
        '%s', // prop_doc_tipo
        '%s', // prop_doc_num
        '%s', // prop_email
        '%s', // prop_telefono
        '%s', // arr_nombre
        '%s', // arr_apellido
        '%s', // arr_doc_tipo
        '%s', // arr_doc_num
        '%s', // arr_email
        '%s', // arr_telefono
        '%s', // titulo_contrato
        '%s', // garantia
        '%s', // fecha_inicio
        '%s', // fecha_fin
        '%f', // monto
        '%s', // divisa
        '%s', // ciclo_pago
        '%s', // documentos (ahora IDs)
        '%s', // estado
    );

    $success = $wpdb->insert($tabla, [
        'id_post'               => $contrato_post_id, // Guardamos el ID del post
        'user_id'               => $user_id,
        'user_agent_id'         => $user_agent_id,
        'prop_nombre'           => sanitize_text_field($data['prop_nombre']),
        'prop_apellido'         => sanitize_text_field($data['prop_apellido']),
        'prop_doc_tipo'         => sanitize_text_field($data['prop_doc_tipo']),
        'prop_doc_num'          => sanitize_text_field($data['prop_doc_num']),
        'prop_email'            => sanitize_email($data['prop_email']),
        'prop_telefono'         => sanitize_text_field($data['prop_telefono']),
        'arr_nombre'            => sanitize_text_field($data['arr_nombre']),
        'arr_apellido'          => sanitize_text_field($data['arr_apellido']),
        'arr_doc_tipo'          => sanitize_text_field($data['arr_doc_tipo']),
        'arr_doc_num'           => sanitize_text_field($data['arr_doc_num']),
        'arr_email'             => sanitize_email($data['arr_email']),
        'arr_telefono'          => sanitize_text_field($data['arr_telefono']),
        'titulo_contrato'       => sanitize_text_field($data['titulo_contrato']),
        'garantia'              => sanitize_text_field($data['garantia']),
        'fecha_inicio'          => sanitize_text_field($data['fecha_inicio']),
        'fecha_fin'             => sanitize_text_field($data['fecha_fin']),
        'monto'                 => floatval($data['monto']),
        'divisa'                => sanitize_text_field($data['divisa']),
        'ciclo_pago'            => sanitize_text_field($data['ciclo_pago']),
        'documentos'            => maybe_serialize($archivos_ids), // Ahora guardamos los IDs de los attachments
        'estado'                => 'activo',
    ], $formato);

    $id_insertado = $wpdb->insert_id;
    if (false === $success) {
        // Si falla la inserción en la tabla, eliminamos el post para evitar inconsistencias
        wp_delete_post($contrato_post_id, true);
        wp_send_json_error('Error al insertar registro en la tabla de contratos.');
    } else {
        wp_send_json_success(['mensaje' => 'Contrato guardado correctamente', 'id' => $id_insertado, 'id_post' => $contrato_post_id]);
    }
}

// ===================
// Editar contrato existente
// ===================
add_action('wp_ajax_editar_contrato_ajax', 'contratos_ofiliaria_editar_ajax');

function contratos_ofiliaria_editar_ajax() {
    global $wpdb;
    
    if (!is_user_logged_in()) {
        wp_send_json_error('No autorizado');
    }

    // Verificación de nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'editar_contrato_nonce')) {
        wp_send_json_error('Token de seguridad inválido.');
    }

    $id = intval($_POST['contrato_id']);
    $contrato = contratos_ofiliaria_obtener_por_id($id);
    $current_user_id = get_current_user_id();
    $user_agent_id = intval(get_user_meta($current_user_id, 'user_agent_id', true));

    if (!$contrato || get_post_status($user_agent_id) !== 'publish') {
        wp_send_json_error('Contrato no encontrado o sin permisos');
    }

    // Verificación de permisos
    $puede_editar = false;
    if ($contrato['user_id'] == $current_user_id) {
        $puede_editar = true;
    }
    if (!$puede_editar) {
        $agent_list = (array) get_user_meta($current_user_id, 'current_agent_list', true);
        if (in_array($contrato['user_id'], $agent_list)) {
            $puede_editar = true;
        }
    }
    if (!$puede_editar && $contrato['user_agent_id'] == $user_agent_id) {
        $puede_editar = true;
    }

    if (!$puede_editar) {
        wp_send_json_error('No tienes permiso para editar este contrato');
    }

    // Obtener los IDs de los documentos existentes del campo oculto
    $archivos_ids_existentes = isset($_POST['documentos_existentes']) ? array_map('intval', explode(',', $_POST['documentos_existentes'])) : [];
    
    // Iniciar el array con los IDs existentes
    $archivos_ids_final = $archivos_ids_existentes;

    // Procesar nuevos archivos adjuntos si existen
    if (!empty($_FILES['documentos'])) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        
        $contrato_post_id = isset($contrato['id_post']) ? intval($contrato['id_post']) : 0;
        
        $files = $_FILES['documentos'];
        foreach ($files['name'] as $key => $value) {
            if ($files['error'][$key] === UPLOAD_ERR_OK) {
                $file = [
                    'name'     => $files['name'][$key],
                    'type'     => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error'    => $files['error'][$key],
                    'size'     => $files['size'][$key],
                ];
                
                $attachment_id = media_handle_sideload($file, $contrato_post_id);

                if (is_wp_error($attachment_id)) {
                    wp_send_json_error('Error al subir un nuevo archivo: ' . $attachment_id->get_error_message());
                } else {
                    $archivos_ids_final[] = $attachment_id;
                }
            }
        }
    }

    $data_to_update = [
        'prop_nombre'       => sanitize_text_field($_POST['prop_nombre']),
        'prop_apellido'     => sanitize_text_field($_POST['prop_apellido']),
        'prop_doc_tipo'     => sanitize_text_field($_POST['prop_doc_tipo']),
        'prop_doc_num'      => sanitize_text_field($_POST['prop_doc_num']),
        'prop_email'        => sanitize_email($_POST['prop_email']),
        'prop_telefono'     => sanitize_text_field($_POST['prop_telefono']),
        'arr_nombre'        => sanitize_text_field($_POST['arr_nombre']),
        'arr_apellido'      => sanitize_text_field($_POST['arr_apellido']),
        'arr_doc_tipo'      => sanitize_text_field($_POST['arr_doc_tipo']),
        'arr_doc_num'       => sanitize_text_field($_POST['arr_doc_num']),
        'arr_email'         => sanitize_email($_POST['arr_email']),
        'arr_telefono'      => sanitize_text_field($_POST['arr_telefono']),
        'titulo_contrato'   => sanitize_text_field($_POST['titulo_contrato']),
        'garantia'          => sanitize_text_field($_POST['garantia']),
        'fecha_inicio'      => sanitize_text_field($_POST['fecha_inicio']),
        'fecha_fin'         => sanitize_text_field($_POST['fecha_fin']),
        'monto'             => floatval($_POST['monto']),
        'divisa'            => sanitize_text_field($_POST['divisa']),
        'ciclo_pago'        => sanitize_text_field($_POST['ciclo_pago']),
        'documentos'        => maybe_serialize($archivos_ids_final),
    ];

    $success = contratos_ofiliaria_actualizar($id, $data_to_update);

    if ($success) {
        $nuevo_estado = contratos_ofiliaria_actualizar_estado($id);
        wp_send_json_success('Contrato actualizado');
    } else {
        wp_send_json_error('Error al actualizar el contrato');
    }
}

// ===================
// Eliminar Documento Individual
// ===================
add_action('wp_ajax_eliminar_documento_ajax', 'contratos_ofiliaria_eliminar_documento_ajax');

function contratos_ofiliaria_eliminar_documento_ajax() {
    global $wpdb;
    
    if (!is_user_logged_in()) {
        wp_send_json_error('No autorizado.');
    }

    // Verificación de nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'eliminar_contrato_nonce')) {
        wp_send_json_error('Token de seguridad inválido.');
    }

    $documento_id = isset($_POST['documento_id']) ? intval($_POST['documento_id']) : 0;
    $contrato_id = isset($_POST['contrato_id']) ? intval($_POST['contrato_id']) : 0;

    if ($documento_id <= 0 || $contrato_id <= 0) {
        wp_send_json_error('ID de documento o contrato inválido.');
    }

    $contrato = contratos_ofiliaria_obtener_por_id($contrato_id);
    if (!$contrato) {
        wp_send_json_error('Contrato no encontrado.');
    }

    // Lógica de permisos para la eliminación (debe ser el mismo usuario que puede editar)
    $current_user_id = get_current_user_id();
    $puede_eliminar = false;
    if ($contrato['user_id'] == $current_user_id) {
        $puede_eliminar = true;
    }
    if (!$puede_eliminar) {
        $agent_list = (array) get_user_meta($current_user_id, 'current_agent_list', true);
        if (in_array($contrato['user_id'], $agent_list)) {
            $puede_eliminar = true;
        }
    }
    
    if (!$puede_eliminar) {
        wp_send_json_error('No tienes permiso para eliminar este documento.');
    }

    // Eliminar el post de adjunto y el archivo físico
    $deleted = wp_delete_attachment($documento_id, true);

    if ($deleted === false) {
        wp_send_json_error('Error al eliminar el post de adjunto.');
    }
    
    // Opcional: Ahora que el post de adjunto se eliminó, actualizamos la tabla del contrato
    // Esto es redundante con la lógica del front-end, pero añade una capa de seguridad
    $documentos_actuales = $contrato['documentos'] ?? [];
    $documentos_restantes = [];
    foreach ($documentos_actuales as $doc) {
        if ($doc['id'] != $documento_id) {
            $documentos_restantes[] = $doc['id'];
        }
    }
    
    $data_to_update = ['documentos' => maybe_serialize($documentos_restantes)];
    contratos_ofiliaria_actualizar($contrato_id, $data_to_update);

    wp_send_json_success('Documento eliminado.');
}

// ===================
// Eliminar Contrato
// ===================
add_action('wp_ajax_eliminar_contrato_ajax', 'contratos_ofiliaria_eliminar_ajax');

function contratos_ofiliaria_eliminar_ajax() {
    global $wpdb;
    $tabla = $wpdb->prefix . 'contratos';
    
    check_ajax_referer('eliminar_contrato_nonce', 'nonce');

    if (!is_user_logged_in()) {
        wp_send_json_error('No autorizado');
    }

    $id = intval($_POST['contrato_id']);
    $contrato = contratos_ofiliaria_obtener_por_id($id); 
    $current_user_id = get_current_user_id();
    $user_agent_id = intval(get_user_meta($current_user_id, 'user_agent_id', true));

    if (!$contrato) {
        wp_send_json_error('Contrato no encontrado.');
    }

    // Lógica de permisos
    $puede_eliminar = false;
    if ($contrato['user_id'] == $current_user_id) {
        $puede_eliminar = true;
    }
    if (!$puede_eliminar) {
        $agent_list = (array) get_user_meta($current_user_id, 'current_agent_list', true);
        if (in_array($contrato['user_id'], $agent_list)) {
            $puede_eliminar = true;
        }
    }
    if (!$puede_eliminar && $contrato['user_agent_id'] == $user_agent_id) {
        $puede_eliminar = true;
    }

    if (!$puede_eliminar) {
        wp_send_json_error('No tienes permiso para eliminar este contrato.');
    }
    
    $contrato_post_id = isset($contrato['id_post']) ? intval($contrato['id_post']) : 0;

    if ($contrato_post_id > 0) {
        // Obtener los IDs de los posts de los archivos adjuntos
        $attachment_ids = $wpdb->get_col( $wpdb->prepare(
            "SELECT ID FROM $wpdb->posts WHERE post_parent = %d AND post_type = 'attachment'",
            $contrato_post_id
        ) );
    
        // Eliminar cada archivo adjunto y su post
        if (!empty($attachment_ids)) {
            foreach ($attachment_ids as $attachment_id) {
                // El segundo parámetro 'true' fuerza la eliminación del archivo físico
                wp_delete_attachment($attachment_id, true);
            }
        }
        
        // Ahora eliminar el post principal del contrato
        $deleted_post = wp_delete_post($contrato_post_id, true);
        if (!$deleted_post) {
            wp_send_json_error('Error al eliminar el post del contrato.');
        }
    }
    
    // Lógica para eliminar el registro de la tabla de contratos
    $deleted_db = $wpdb->delete($tabla, ['id' => $id], ['%d']);

    if ($deleted_db === false) {
        wp_send_json_error('Error al eliminar el registro de la base de datos.');
    }

    wp_send_json_success();
}