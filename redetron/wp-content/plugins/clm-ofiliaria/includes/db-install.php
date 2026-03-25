<?php
function contratos_ofiliaria_install_db() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contratos';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id BIGINT UNSIGNED NOT NULL,
        user_agent_id BIGINT,
        prop_nombre VARCHAR(100),
        prop_apellido VARCHAR(100),
        prop_doc_tipo VARCHAR(50),
        prop_doc_num VARCHAR(100),
        prop_email VARCHAR(100),
        prop_telefono VARCHAR(50),
        arr_nombre VARCHAR(100),
        arr_apellido VARCHAR(100),
        arr_doc_tipo VARCHAR(50),
        arr_doc_num VARCHAR(100),
        arr_email VARCHAR(100),
        arr_telefono VARCHAR(50),
        titulo_contrato VARCHAR(255),
        garantia VARCHAR(100),
        fecha_inicio DATE,
        fecha_fin DATE,
        monto DECIMAL(10,2),
        divisa VARCHAR(10),
        ciclo_pago VARCHAR(50),
        documentos TEXT,
        estado VARCHAR(50) DEFAULT 'activo',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}