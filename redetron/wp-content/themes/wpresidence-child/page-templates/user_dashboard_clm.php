<?php
/**
 * Template Name: User Dashboard Contratos
 * @package WpResidence
 */

wpestate_dashboard_header_permissions();
get_header();
?>

<div class="row row_user_dashboard">
    <?php get_template_part('templates/dashboard-templates/dashboard-left-col'); ?>

    <div class="col-md-9 dashboard-margin">
        <?php wpestate_show_dashboard_title(get_the_title()); ?>

        <div class="col-md-12 wpestate_dash_coluns">
            <div class="wpestate_dashboard_content_wrapper">
                <div class="contratos-toolbar mb-3">
                    <a href="/agregar-contrato/" class="wpresidence_button wpresidence_success">+ Nuevo Contrato</a>
                </div>

                <?php
                global $wpdb;
                $user_id = get_current_user_id();
                $tabla = $wpdb->prefix . 'contratos';

                // Obtener lista de agentes asociados (current_agent_list)
                $agent_list = (array) get_user_meta($user_id, 'current_agent_list', true);
                $agent_list[] = $user_id;
                $agent_list = array_unique(array_map('intval', $agent_list));

                // Filtros GET
                $filtro_estado = isset($_GET['estado']) ? sanitize_text_field($_GET['estado']) : '';
                $filtro_garantia = isset($_GET['garantia']) ? sanitize_text_field($_GET['garantia']) : '';

                $estados_posibles = ['activo' => 'Activo', 'vencido' => 'Vencido', 'por vencer' => 'Por Vencer'];
                $garantias_posibles = $wpdb->get_col("SELECT DISTINCT garantia FROM $tabla WHERE garantia != ''");

                // Mostrar filtros
                ?>
                <form method="get" class="row mb-4">
                    <div class="col-md-4">
                        <label for="estado" class="form-label">Estado del contrato</label>
                        <select name="estado" id="estado" class="form-select">
                            <option value="">Todos</option>
                            <?php foreach ($estados_posibles as $key => $label): ?>
                                <option value="<?php echo esc_attr($key); ?>" <?php selected($filtro_estado, $key); ?>><?php echo esc_html($label); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="garantia" class="form-label">Tipo de garantía</label>
                        <select name="garantia" id="garantia" class="form-select">
                            <option value="">Todas</option>
                            <?php foreach ($garantias_posibles as $garantia): ?>
                                <option value="<?php echo esc_attr($garantia); ?>" <?php selected($filtro_garantia, $garantia); ?>><?php echo esc_html($garantia); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary me-2">Filtrar</button>
                        <a href="<?php echo esc_url(remove_query_arg(['estado', 'garantia'])); ?>" class="btn btn-outline-secondary">Limpiar</a>
                    </div>
                </form>

                <?php
                // Construir cláusula WHERE
                $placeholders = implode(',', array_fill(0, count($agent_list), '%d'));
                $where = "WHERE user_id IN ($placeholders)";
                $params = $agent_list;

                if ($filtro_estado !== '') {
                    $where .= " AND estado = %s";
                    $params[] = $filtro_estado;
                }

                if ($filtro_garantia !== '') {
                    $where .= " AND garantia = %s";
                    $params[] = $filtro_garantia;
                }

                $query = "SELECT * FROM $tabla $where ORDER BY id DESC";
                $contratos = $wpdb->get_results($wpdb->prepare($query, ...$params), ARRAY_A);
                ?>

                <?php if ($contratos): ?>
                    <!-- Vista de tabla para escritorio -->
                    <div class="contratos-table-container d-none d-md-block">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Arrendatario</th>
                                    <th>Tipo de Garantía</th>
                                    <th>Estado</th>
                                    <th>Vencimiento</th>
                                    <th>Monto</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contratos as $contrato): 
                                    $estado = strtolower(trim($contrato['estado']));
                                    $color = '';
                                    $texto = ucfirst($estado);

                                    switch ($estado) {
                                        case 'activo':
                                            $color = 'style="color: #28a745;"';
                                            break;
                                        case 'por vencer':
                                            $color = 'style="color: #ff9600;"';
                                            break;
                                        case 'vencido':
                                            $color = 'style="color: #dc3545;"';
                                            break;
                                    }
                                ?>
                                    <tr data-id="<?php echo esc_attr($contrato['id']); ?>">
                                        <td><?php echo esc_html($contrato['arr_nombre'] . ' ' . $contrato['arr_apellido']); ?></td>
                                        <td><?php echo esc_html($contrato['garantia']); ?></td>
                                        <td>
                                            <span <?php echo $color; ?>>
                                                <i class="fas fa-square"></i> <?php echo esc_html($texto); ?>
                                            </span>
                                        </td>
                                        <td><?php echo esc_html(date_i18n('d/m/Y', strtotime($contrato['fecha_fin']))); ?></td>
                                        <td><?php echo esc_html($contrato['divisa'] . ' ' . number_format($contrato['monto'], 2)); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-default dropdown-toggle property_dashboard_actions_button" data-bs-toggle="dropdown">Acciones</button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="<?php echo esc_url('/detalles-contrato/?id=' . $contrato['id']); ?>">Ver detalles</a></li>
                                                    <li><a class="dropdown-item" href="<?php echo esc_url('/editar-contrato/?id=' . $contrato['id']); ?>">Editar</a></li>
                                                    <li><a class="dropdown-item text-danger eliminar-contrato" href="#" data-id="<?php echo esc_attr($contrato['id']); ?>">Eliminar</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Vista de tarjetas para móviles -->
                    <div class="contratos-cards-container d-md-none">
                        <?php foreach ($contratos as $contrato): 
                            $estado = strtolower(trim($contrato['estado']));
                            $color_class = '';
                            $texto = ucfirst($estado);

                            switch ($estado) {
                                case 'activo':
                                    $color_class = 'estado-activo';
                                    break;
                                case 'por vencer':
                                    $color_class = 'estado-por-vencer';
                                    break;
                                case 'vencido':
                                    $color_class = 'estado-vencido';
                                    break;
                            }
                        ?>
                            <div class="contrato-card" data-id="<?php echo esc_attr($contrato['id']); ?>">
                                <div class="contrato-card-header">
                                    <h3 class="contrato-nombre"><?php echo esc_html($contrato['arr_nombre'] . ' ' . $contrato['arr_apellido']); ?></h3>
                                    <span class="contrato-estado <?php echo $color_class; ?>">
                                        <?php echo esc_html($texto); ?>
                                    </span>
                                </div>
                                
                                <div class="contrato-card-body">
                                    <div class="contrato-info">
                                        <div class="info-item">
                                            <span class="info-label">Tipo de Garantía:</span>
                                            <span class="info-value"><?php echo esc_html($contrato['garantia']); ?></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Vencimiento:</span>
                                            <span class="info-value"><?php echo esc_html(date_i18n('d/m/Y', strtotime($contrato['fecha_fin']))); ?></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Monto:</span>
                                            <span class="info-value"><?php echo esc_html($contrato['divisa'] . ' ' . number_format($contrato['monto'], 2)); ?></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="contrato-card-footer">
                                    <div class="btn-group-vertical">
                                        <a href="<?php echo esc_url('/detalles-contrato/?id=' . $contrato['id']); ?>" class="btn btn-outline-primary">Ver detalles</a>
                                        <a href="<?php echo esc_url('/editar-contrato/?id=' . $contrato['id']); ?>" class="btn btn-outline-secondary">Editar</a>
                                        <a href="#" class="btn btn-outline-danger eliminar-contrato" data-id="<?php echo esc_attr($contrato['id']); ?>">Eliminar</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No se encontraron contratos registrados.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
// Cargar estilos CSS
wp_enqueue_style('contratos-dashboard', get_stylesheet_directory_uri() . '/css/contratos-dashboard.css', array(), '1.0');
?>

<?php get_footer(); ?>