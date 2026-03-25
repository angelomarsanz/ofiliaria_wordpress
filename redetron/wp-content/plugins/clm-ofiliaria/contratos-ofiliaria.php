<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Contratos Ofiliaria
 * Plugin URI:        https://redetronic.com
 * Description:       Módulo de gestión de contratos externos para sistema ofiliaria, permite agregar contratos, gestionar su ciclo de vida y monitorear los vencimientos, filtrando información desde la lista de datos.
 * Version:           1.0.0
 * Requires at least: 6.7.0
 * Requires PHP:      8.1
 * Author:            Redetronic
 * Author URI:        https://redetronic.com
 **/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Definir rutas
define('CONTRATOS_OFILIARIA_DIR', plugin_dir_path(__FILE__));
define('CONTRATOS_OFILIARIA_URL', plugin_dir_url(__FILE__));

// Incluir archivos
require_once CONTRATOS_OFILIARIA_DIR . 'includes/db-install.php';
require_once CONTRATOS_OFILIARIA_DIR . 'includes/contratos-core.php';
require_once CONTRATOS_OFILIARIA_DIR . 'includes/ajax-handler.php';

// Crear tabla en activación
register_activation_hook(__FILE__, 'contratos_ofiliaria_install_db');

// Cargar estilos y scripts
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'contratos-style',
        CONTRATOS_OFILIARIA_URL . 'assets/css/contratos-style.css',
        [],
        filemtime(CONTRATOS_OFILIARIA_DIR . 'assets/css/contratos-style.css')
    );

    wp_enqueue_script('contrato-form-js', CONTRATOS_OFILIARIA_URL . 'assets/js/contrato-form.js', ['jquery'], filemtime(CONTRATOS_OFILIARIA_DIR . 'assets/js/contrato-form.js'), true);

    // Pasar datos a JS
    wp_localize_script('contrato-form-js', 'contrato_form_data', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce_crear' => wp_create_nonce('crear_contrato_nonce'),
        'nonce_editar' => wp_create_nonce('editar_contrato_nonce'), // <-- Nuevo nonce para la edición
        'nonce_eliminar' => wp_create_nonce('eliminar_contrato_nonce'),
    ]);
});
//Registro de Cron para estados de contratos
register_activation_hook(__FILE__, function() {
    if ( ! wp_next_scheduled('contratos_ofiliaria_cron_event') ) {
        // 2:00 am hora del servidor
        wp_schedule_event( strtotime('02:00:00'), 'daily', 'contratos_ofiliaria_cron_event' );
    }
});

// Eliminar cron al desactivar plugin
register_deactivation_hook(__FILE__, function() {
    wp_clear_scheduled_hook('contratos_ofiliaria_cron_event');
});
add_action('contratos_ofiliaria_cron_event', 'contratos_ofiliaria_actualizar_estados_automaticamente');

//Funcion de actualizar estado del contrato
function contratos_ofiliaria_actualizar_estado($id_contrato) {
    global $wpdb;
    $tabla = $wpdb->prefix . 'contratos';

    $contrato = $wpdb->get_row(
        $wpdb->prepare("SELECT fecha_fin FROM $tabla WHERE id = %d", $id_contrato),
        ARRAY_A
    );

    if ( ! $contrato || empty($contrato['fecha_fin']) || $contrato['fecha_fin'] === '0000-00-00' ) {
        return false;
    }

    $hoy = current_time('Y-m-d');
    $dias_restantes = (strtotime($contrato['fecha_fin']) - strtotime($hoy)) / (60 * 60 * 24);

    if ($dias_restantes < 0) {
        $nuevo_estado = 'vencido';
    } elseif ($dias_restantes <= 60) {
        $nuevo_estado = 'por vencer';
    } else {
        $nuevo_estado = 'activo';
    }

    $wpdb->update(
        $tabla,
        array('estado' => $nuevo_estado),
        array('id' => $id_contrato),
        array('%s'),
        array('%d')
    );

    return $nuevo_estado;
}
//Actualizar estados vía CronJob
function contratos_ofiliaria_actualizar_estados_automaticamente() {
    global $wpdb;
    $tabla = $wpdb->prefix . 'contratos';

    $contratos = $wpdb->get_results("SELECT id FROM $tabla", ARRAY_A);

    foreach ($contratos as $contrato) {
        contratos_ofiliaria_actualizar_estado($contrato['id']);
    }
}


?>
