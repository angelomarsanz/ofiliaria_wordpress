<?php
/**
 * Template Name: Editar Contrato
 * src: page-templates/user-editar-contrato.php
 */

wpestate_dashboard_header_permissions();
get_header();

// Validación y permisos
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$user_agent_id = intval(get_user_meta($user_id, 'user_agent_id', true)); // ID del post_type estate_agency o estate_agent

// Obtener ID del contrato desde GET
$contrato_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$contrato = contratos_ofiliaria_obtener_por_id($contrato_id);

if (!$contrato) {
    echo '<div class="alert alert-danger">Contrato no encontrado.</div>';
    get_footer();
    exit;
}

// Lógica de permisos
$puede_editar = false;

// Caso 1: El usuario es el creador del contrato
if ($contrato['user_id'] == $user_id) {
    $puede_editar = true;
}

// Caso 2: El contrato fue creado por un agente y el usuario actual es su agencia
if (!$puede_editar) {
    $agent_list = (array) get_user_meta($user_id, 'current_agent_list', true); // Agentes asignados a esta agencia
    if (in_array($contrato['user_id'], $agent_list)) {
        $puede_editar = true;
    }
}

if (!$puede_editar) {
    echo '<div class="alert alert-danger">No tienes permiso para editar este contrato.</div>';
    get_footer();
    exit;
}

// Preparamos los datos de los documentos para pasarlos a JavaScript
$documentos = $contrato['documentos'] ?? [];
$documentos_ids = [];
if (!empty($documentos)) {
    foreach ($documentos as $doc) {
        $documentos_ids[] = $doc['id'];
    }
}

// Pasamos las variables a un script para que estén disponibles en contrato-form.js
// Esto se hará a través de una nueva variable global llamada 'contrato_edicion_data'
$script_data = array(
    'contrato_id'         => $contrato_id,
    'documentos_ids'      => $documentos_ids,
);
wp_localize_script('contrato-form-js', 'contrato_edicion_data', $script_data);
?>

<div class="row row_user_dashboard">
    <?php get_template_part('templates/dashboard-templates/dashboard-left-col'); ?>

    <div class="col-md-9 dashboard-margin">
        <?php wpestate_show_dashboard_title('Editar Contrato'); ?>

        <div class="col-md-12 wpestate_dash_coluns">
            <div class="wpestate_dashboard_content_wrapper">
                <form id="form-editar-contrato" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="editar_contrato_ajax">
                    <input type="hidden" name="contrato_id" value="<?php echo esc_attr($contrato['id']); ?>">
                    <input type="hidden" id="documentos-existentes-input" name="documentos_existentes" value="">

                    <h4>Datos del Propietario</h4>
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="prop_nombre" class="form-control" value="<?php echo esc_attr($contrato['prop_nombre']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" name="prop_apellido" class="form-control" value="<?php echo esc_attr($contrato['prop_apellido']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Tipo de documento</label>
                        <select name="prop_doc_tipo" class="form-seleccionar" required>
                            <option value="">Tipo de documento</option>
                            <option value="CI" <?php selected($contrato['prop_doc_tipo'], 'CI'); ?>>CI</option>
                            <option value="Pasaporte" <?php selected($contrato['prop_doc_tipo'], 'Pasaporte'); ?>>Pasaporte</option>
                            <option value="Licencia de conducir" <?php selected($contrato['prop_doc_tipo'], 'Licencia de conducir'); ?>>Licencia de conducir</option>
                            <option value="DNI" <?php selected($contrato['prop_doc_tipo'], 'DNI'); ?>>DNI</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Número de documento</label>
                        <input type="text" name="prop_doc_num" class="form-control" value="<?php echo esc_attr($contrato['prop_doc_num']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="prop_email" class="form-control" value="<?php echo esc_attr($contrato['prop_email']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="prop_telefono" class="form-control" value="<?php echo esc_attr($contrato['prop_telefono']); ?>">
                    </div>

                    <h4>Datos del Arrendatario</h4>
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="arr_nombre" class="form-control" value="<?php echo esc_attr($contrato['arr_nombre']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" name="arr_apellido" class="form-control" value="<?php echo esc_attr($contrato['arr_apellido']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Tipo de documento</label>
                        <select name="arr_doc_tipo" class="form-seleccionar" required>
                            <option value="">Tipo de documento</option>
                            <option value="CI" <?php selected($contrato['arr_doc_tipo'], 'CI'); ?>>CI</option>
                            <option value="Pasaporte" <?php selected($contrato['arr_doc_tipo'], 'Pasaporte'); ?>>Pasaporte</option>
                            <option value="Licencia de conducir" <?php selected($contrato['arr_doc_tipo'], 'Licencia de conducir'); ?>>Licencia de conducir</option>
                            <option value="DNI" <?php selected($contrato['arr_doc_tipo'], 'DNI'); ?>>DNI</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Número de documento</label>
                        <input type="text" name="arr_doc_num" class="form-control" value="<?php echo esc_attr($contrato['arr_doc_num']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="arr_email" class="form-control" value="<?php echo esc_attr($contrato['arr_email']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="arr_telefono" class="form-control" value="<?php echo esc_attr($contrato['arr_telefono']); ?>">
                    </div>

                    <h4>Datos del Contrato</h4>
                    <div class="form-group">
                        <label>Título del contrato</label>
                        <input type="text" name="titulo_contrato" class="form-control" value="<?php echo esc_attr($contrato['titulo_contrato']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Tipo de garantía</label>
                        <select name="garantia" class="form-seleccionar" required>
                            <option value="">Tipo de garantía</option>
                            <option value="ANDA" <?php selected($contrato['garantia'], 'ANDA'); ?>>ANDA</option>
                            <option value="Contaduria" <?php selected($contrato['garantia'], 'Contaduria'); ?>>ANDA</option>
                            <option value="Sura" <?php selected($contrato['garantia'], 'Sura'); ?>>Sura</option>
                            <option value="Porto" <?php selected($contrato['garantia'], 'Porto'); ?>>Porto</option>
                            <option value="Mapfre" <?php selected($contrato['garantia'], 'Mapfre'); ?>>Mapfre</option>
                            <option value="Sancor" <?php selected($contrato['garantia'], 'Sancor'); ?>>Sancor</option>
                            <option value="San Cristóbal" <?php selected($contrato['garantia'], 'San Cristóbal'); ?>>ANDA</option>
                            <option value="BSE" <?php selected($contrato['garantia'], 'BSE'); ?>>San Cristóbal</option>
                            <option value="SBI" <?php selected($contrato['garantia'], 'SBI'); ?>>SBI</option>
                            <option value="Santander Zurich" <?php selected($contrato['garantia'], 'Santander Zurich'); ?>>Santander Zurich</option>
                            <option value="LUC" <?php selected($contrato['garantia'], 'LUC'); ?>>LUC</option>
                            <option value="Depósito BHU" <?php selected($contrato['garantia'], 'Depósito BHU'); ?>>Depósito BHU</option>
                            <option value="Depósito en Cuenta Propietario" <?php selected($contrato['garantia'], 'Depósito en Cuenta Propietario'); ?>>Depósito en Cuenta Propietario</option>
                            <option value="Depósito" <?php selected($contrato['garantia'], 'Depósito'); ?>>Depósito</option>
                            <option value="FIDECIU" <?php selected($contrato['garantia'], 'FIDECIU'); ?>>FIDECIU</option>
                            <option value="ANV" <?php selected($contrato['garantia'], 'ANV'); ?>>ANV</option>
                            <option value="otro" <?php selected($contrato['garantia'], 'otro'); ?>>Otro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Fecha de inicio</label><br>
                        <input type="date" name="fecha_inicio" class="campo-fecha-c" value="<?php echo esc_attr($contrato['fecha_inicio']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Fecha de finalización</label><br>
                        <input type="date" name="fecha_fin" class="campo-fecha-c" value="<?php echo esc_attr($contrato['fecha_fin']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Monto</label>
                        <input type="number" step="0.01" name="monto" class="form-control" value="<?php echo esc_attr($contrato['monto']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Divisa</label>
                        <select name="divisa" class="form-seleccionar" required>
                            <option value="UYU" <?php selected($contrato['divisa'], 'UYU'); ?>>UYU</option>
                            <option value="USD" <?php selected($contrato['divisa'], 'USD'); ?>>USD</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ciclo de pago</label>
                        <select name="ciclo_pago" class="form-seleccionar" required>
                            <option value="mensual" <?php selected($contrato['ciclo_pago'], 'mensual'); ?>>Mensual</option>
                            <option value="trimestral" <?php selected($contrato['ciclo_pago'], 'trimestral'); ?>>Trimestral</option>
                            <option value="anual" <?php selected($contrato['ciclo_pago'], 'anual'); ?>>Anual</option>
                        </select>
                    </div>

                    <h4>Documentos existentes</h4>
                    <?php
                    $documentos = $contrato['documentos'] ?? [];
                    $documentos_ids = [];
                    if (!empty($documentos)) {
                        echo '<ul id="documentos-existentes-lista">';
                        foreach ($documentos as $doc) {
                            $documentos_ids[] = $doc['id'];
                            echo '<li data-id="' . esc_attr($doc['id']) . '">';
                            echo '<span class="eliminar-documento-btn" data-id="' . esc_attr($doc['id']) . '" style="margin-right: 1rem; cursor: pointer;"><i class="fas fa-trash-alt"></i></span>';
                            echo '<a href="' . esc_url($doc['url']) . '" target="_blank">' . esc_html($doc['titulo']) . '</a>';
                            echo '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<p>No hay documentos adjuntos.</p>';
                    }
                    ?>

                    <div class="form-group mt-3">
                        <label>Adjuntar nuevos documentos (opcional)</label>
                        <input type="file" name="documentos[]" class="form-control" multiple>
                    </div>
                    <br><br>
                    <div id="alerta-edicion" class="alert mt-3 d-none"></div>

                    <button type="submit" id="btn-editar-contrato" class="wpresidence_button">
                        <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                        <span class="texto-btn">Guardar cambios</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>