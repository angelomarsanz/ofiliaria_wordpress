<?php
/**
 * Template Name: Detalles del Contrato
 * src: page-templates/user-contratos-details.php
 *
 * Este archivo muestra los detalles completos de un contrato específico en el dashboard del usuario.
 * Se accede con el parámetro GET ?id=123
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
$puede_ver = false;

// Caso 1: El usuario es el creador del contrato
if ($contrato['user_id'] == $user_id) {
    $puede_ver = true;
}

// Caso 2: El contrato fue creado por un agente y el usuario actual es su agencia
if (!$puede_ver) {
    $agent_list = (array) get_user_meta($user_id, 'current_agent_list', true); // Agentes asignados a esta agencia
    if (in_array($contrato['user_id'], $agent_list)) {
        $puede_ver = true;
    }
}

if (!$puede_ver) {
    echo '<div class="alert alert-danger">No tienes permiso para editar este contrato.</div>';
    get_footer();
    exit;
}
?>

<div class="row row_user_dashboard">
    <?php get_template_part('templates/dashboard-templates/dashboard-left-col'); ?>

    <div class="col-md-9 dashboard-margin">
        <?php wpestate_show_dashboard_title('Detalles del Contrato'); ?>

        <div class="col-md-12 wpestate_dash_coluns">
            <div class="wpestate_dashboard_content_wrapper">
                <h3><?php echo esc_html($contrato['titulo_contrato']); ?></h3>

                <h4>Propietario</h4>
                <ul>
                    <li><strong>Nombre:</strong> <?php echo esc_html($contrato['prop_nombre'] . ' ' . $contrato['prop_apellido']); ?></li>
                    <li><strong>Documento:</strong> <?php echo esc_html($contrato['prop_doc_tipo'] . ' ' . $contrato['prop_doc_num']); ?></li>
                    <li><strong>Email:</strong> <?php echo esc_html($contrato['prop_email']); ?></li>
                    <li><strong>Teléfono:</strong> <?php echo esc_html($contrato['prop_telefono']); ?></li>
                </ul>

                <h4>Arrendatario</h4>
                <ul>
                    <li><strong>Nombre:</strong> <?php echo esc_html($contrato['arr_nombre'] . ' ' . $contrato['arr_apellido']); ?></li>
                    <li><strong>Documento:</strong> <?php echo esc_html($contrato['arr_doc_tipo'] . ' ' . $contrato['arr_doc_num']); ?></li>
                    <li><strong>Email:</strong> <?php echo esc_html($contrato['arr_email']); ?></li>
                    <li><strong>Teléfono:</strong> <?php echo esc_html($contrato['arr_telefono']); ?></li>
                </ul>

                <h4>Información del Contrato</h4>
                <ul>
                    <li><strong>Tipo de garantía:</strong> <?php echo esc_html($contrato['garantia']); ?></li>
                    <li><strong>Inicio:</strong> <?php echo esc_html($contrato['fecha_inicio']); ?></li>
                    <li><strong>Finalización:</strong> <?php echo esc_html($contrato['fecha_fin']); ?></li>
                    <li><strong>Monto:</strong> <?php echo esc_html(number_format($contrato['monto'], 2)); ?> <?php echo esc_html($contrato['divisa']); ?></li>
                    <li><strong>Ciclo de pago:</strong> <?php echo esc_html($contrato['ciclo_pago']); ?></li>
                    <li><strong>Estado:</strong> <?php echo esc_html($contrato['estado']); ?></li>
                </ul>

                <?php
                $documentos = $contrato['documentos'];
                if (!empty($documentos)) :
                ?>
                    <h4>Documentos adjuntos</h4>
                    <ul>
                        <?php foreach ($documentos as $doc) : ?>
                            <li><a href="<?php echo esc_url($doc['url']); ?>" target="_blank"><?php echo esc_html($doc['titulo']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <a href="<?php echo esc_url('/editar-contrato/?id=' . $contrato_id); ?>" class="wpresidence_button">Editar contrato</a>
                <button class="boton-eliminar-clm-details" id="btn-eliminar-detalles" data-id="<?php echo esc_attr($contrato_id); ?>"><svg xmlns="http://www.w3.org/2000/svg" 
       width="16" height="16" viewBox="0 0 24 24" 
       fill="none" stroke="currentColor" stroke-width="2" 
       stroke-linecap="round" stroke-linejoin="round">
    <path d="M3 6h18"></path>
    <path d="M19 6l-1 14H6L5 6"></path>
    <path d="M10 11v6"></path>
    <path d="M14 11v6"></path>
    <path d="M9 6V4h6v2"></path>
  </svg> Eliminar contrato</button>
                
            </div>
        </div>
    </div>
</div>
<style>
    .boton-eliminar-clm-details {
        color: #dc3545;
        border-color: #dc3545;
        padding:14px;
        border-radius: 5px;
        margin-left: 30px;
    }
    .boton-eliminar-clm-details:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #fff;
    }
</style>
<?php get_footer(); ?>