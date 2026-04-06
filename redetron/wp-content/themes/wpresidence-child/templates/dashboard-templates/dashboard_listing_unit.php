<?php
/** MILLDONE
 * Dashboard Property Unit Template
 * src: templates\dashboard-templates\dashboard_listing_unit.php
 * This template displays individual property listings in the user dashboard of WpResidence theme.
 * It shows property details including featured status, image, location, type, status and actions.
 *
 * @package WpResidence
 * @subpackage Dashboard
 * @since 1.0
 * 
 * Dependencies:
 * - WpResidence Theme Options
 * - WordPress Core Functions
 * - Property Post Type
 * - Property Taxonomies (property_category, property_action_category, property_city, property_area)
 *
 * Template Variables Required:
 * - $edit_link: URL for editing the property
 * - $floor_link: URL for editing floor plans (optional)
 * - $is_dashboard_fav: Boolean indicating if this is the favorites dashboard
 */

// Fetch and sanitize property data
$post_id = get_the_ID();
$title = get_the_title();
$featured = intval(get_post_meta($post_id, 'prop_featured', true));
$preview = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'widget_thumb');
$edit_link = esc_url_raw(add_query_arg('listing_edit', $post_id, $edit_link));

// Handle floor link if it exists
if (isset($floor_link)) {
    $floor_link = esc_url_raw(add_query_arg('floor_edit', $post_id, $floor_link));
}

// Get property status and permalink
$post_status = get_post_status($post_id);
$link = get_permalink();

// Initialize payment related variables
$price_submission = floatval(wpresidence_get_option('wp_estate_price_submission', ''));
$price_featured_submission = floatval(wpresidence_get_option('wp_estate_price_featured_submission', ''));
$th_separator = stripslashes(wpresidence_get_option('wp_estate_prices_th_separator', ''));
$paid_submission_status = esc_html(wpresidence_get_option('wp_estate_paid_submission', ''));

// Get property statistics and metadata
$no_views = intval(get_post_meta($post_id, 'wpestate_total_views', true));
$free_feat_list_expiration = intval(wpresidence_get_option('wp_estate_free_feat_list_expiration', ''));
$pfx_date = strtotime(get_the_date("Y-m-d", $post_id));
$expiration_date = $pfx_date + ($free_feat_list_expiration * 24 * 60 * 60);

// Set image column width based on submission status
$image_class = ($paid_submission_status == 'per listing') ? 3 : 4;

// Inicio cambios Ofiliaria
$indicadorPublicacionImportadaMeli = get_post_meta($post_id, '_ofiliaria_publicacion_importada_meli', true);
$indicadorPublicarMeli = get_post_meta($post_id, '_ofiliaria_publicar_en_mercado_libre', true);
$permalink_publicacion_meli = get_post_meta($post_id, '_ofiliaria_permalink_publicacion_meli', true);
$indicador_publicar_infocasas = get_post_meta($post_id, '_ofiliaria_publicar_en_infocasas', true);
$indicador_publicar_infocasas_enviado = get_post_meta($post_id, '_ofiliaria_publicar_en_infocasas_enviado', true);
$id_meli_publicacion = get_post_meta($post_id, '_ofiliaria_id_meli_publicacion', true);
$post_publicacion = get_post($post_id);
$id_autor_publicacion = $post_publicacion->post_author;
$id_post_agencia_agente = get_user_meta($id_autor_publicacion, 'user_agent_id', true);
$publicacion_meli = '';
if ($id_meli_publicacion != '')
{
    $publicacion_meli = apply_filters('ofiliaria_filtro_buscar_publicacion_meli', $publicacion_meli, $id_autor_publicacion, $id_meli_publicacion);
}
// Fin cambios Ofiliaria 

// Set default preview image if none exists
if (!isset($preview[0])) {
    $preview = array(get_theme_file_uri('/img/default_listing_105.png'));
}

$blog_listing_image_class= 'col-xl-4';
if ($paid_submission_status=='per listing'){
    $blog_listing_image_class= 'col-xl-3';
}
?>
<div id="<?php echo 'ofiliaria_gif_espere_mensajes_'.$post_id ?>" style="text-align: center;"></div>
<div class="row property_wrapper_dash flex-md-row flex-column">
    <!-- Property Image and Basic Info Section -->
    <div class="blog_listing_image col-12 col-md-12 col-lg-12 <?php echo esc_attr($blog_listing_image_class);?> col-md-<?php echo esc_attr($image_class); ?>">
        <?php if ($featured == 1) : ?>
            <div class="featured_div"><?php esc_html_e('Featured', 'wpresidence'); ?></div>
        <?php endif; ?>

        <a class="dashbard_unit_image" href="<?php echo esc_url($link); ?>">
            <img src="<?php echo esc_url($preview[0]); ?>" alt="<?php echo esc_attr($title); ?>" />
        </a>

        <div class="property_dashboard_location_wrapper">
            <a class="dashbard_unit_title" href="<?php echo esc_url($link); ?>">
                <?php echo esc_html($title); ?>
            </a>

            <div class="property_dashboard_location">
                <?php
                $property_location = get_the_term_list($post_id, 'property_city', '', ', ', '') . ', ' . 
                                   get_the_term_list($post_id, 'property_area', '', ', ', '');
                echo wp_kses_post(trim($property_location, ','));
                ?>
            </div>

            <?php
            $property_types = get_the_term_list($post_id, 'property_category', '', ', ', '') . ', ' . 
                            get_the_term_list($post_id, 'property_action_category', '', ', ', ''); ?>
            <div class="property_dashboard_location">
                <?php echo wp_kses_post(trim($property_types, ',')); ?>
            </div>

            <div class="property_dashboard_status_unit">
                <?php
                if (!isset($is_dasboard_fav)) {
                    if ($paid_submission_status == 'membership' && isset($user_pack) && $user_pack == '') {
                        if (!wpestate_check_if_developer_or_agency(get_the_author_meta('ID'))) {
                            $date_format = get_option('date_format');
                            esc_html_e('Expires on ', 'wpresidence');
                            echo esc_html(date($date_format, $expiration_date));
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Status, Payment Status, and Price Sections -->
    <?php if ($paid_submission_status == 'per listing') : ?>
        <div class="col-md-2">
            <?php include(locate_template('templates/dashboard-templates/dashboard-unit-templates/dashboard-unit-status.php')); ?>
        </div>
        <div class="col-md-2 property_dashboard_status">
            <?php include(locate_template('templates/dashboard-templates/dashboard-unit-templates/dashboard-unit-paystatus.php')); ?>
        </div>
        <div class="col-md-1 property_dashboard_price">
            <?php include(locate_template('templates/dashboard-templates/dashboard-unit-templates/dashboard-unit-price.php')); ?>
        </div>
    <?php else : ?>
        <div class="col-md-2">
            <?php include(locate_template('templates/dashboard-templates/dashboard-unit-templates/dashboard-unit-status.php')); ?>
        </div>
        <div class="col-md-2 property_dashboard_price">
            <?php include(locate_template('templates/dashboard-templates/dashboard-unit-templates/dashboard-unit-price.php')); ?>
        </div>
    <?php endif; ?>

    <div class="col-md-2">
        <?php
        if (!empty($agentes_agencia)) { ?>
            <div class="row">
                <div class="col-md-12">                        
                    <label for="<?php echo 'agentes_agencia_'.$post_id ?>"><?php esc_html_e('Agente:', 'wpresidence'); ?></label>
                    <input type="hidden" name="<?php echo 'agentes_agencia_'.$post_id ?>" id="<?php echo 'agentes_agencia_'.$post_id ?>" class="agentes_agencia" value="<?php echo $id_autor_publicacion; ?>">
                    
                    <div class="dropdown wpresidence_dropdown wpestate_dashhboard_filter">
                        <button type="button" class="btn btn-default dropdown-toggle property_dashboard_actions_button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo isset($agentes_agencia[$id_autor_publicacion]) ? htmlspecialchars($agentes_agencia[$id_autor_publicacion]) : esc_html__('Seleccionar Agente', 'wpresidence'); ?> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <?php
                            foreach ($agentes_agencia as $id_usuario_agente => $agente) {
                                echo '<li><a href="#" class="ofiliaria_custom_select" data-value="' . htmlspecialchars($id_usuario_agente) . '" data-input-id="' . 'agentes_agencia_'.$post_id . '">' . htmlspecialchars($agente) . '</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php
        }

        if ($id_meli_publicacion != '' && $publicacion_meli->status == 'active') {
            $destaque_actual_mercado_libre = $publicacion_meli->listing_type_id; 
            $destaques_mercado_libre = [
                'silver'       => 'Plata',
                'gold'         => 'Oro',
                'gold_premium' => 'Oro Premium' 
            ];
            ?>    
            <br />
            <div class="row">   
                <div class="col-md-12">
                    <input type='hidden' name="<?php echo 'id_meli_publicacion_'.$post_id ?>" id="<?php echo 'id_meli_publicacion_'.$post_id ?>" value="<?php echo $id_meli_publicacion; ?>">    
                    <input type='hidden' name="<?php echo 'destaque_actual_mercado_libre_'.$post_id ?>" id="<?php echo 'destaque_actual_mercado_libre_'.$post_id ?>" class="destaques_mercado_libre" value="<?php echo $destaque_actual_mercado_libre; ?>">    
                    
                    <label for=""><?php esc_html_e('Destaque Mercado Libre:', 'wpresidence'); ?></label>
                    
                    <div class="dropdown wpresidence_dropdown wpestate_dashhboard_filter">
                        <button type="button" class="btn btn-default dropdown-toggle property_dashboard_actions_button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo isset($destaques_mercado_libre[$destaque_actual_mercado_libre]) ? htmlspecialchars($destaques_mercado_libre[$destaque_actual_mercado_libre]) : esc_html__('Seleccionar Destaque', 'wpresidence'); ?> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <?php
                            foreach ($destaques_mercado_libre as $value => $label) {
                                echo '<li><a href="#" class="ofiliaria_custom_select" data-value="' . htmlspecialchars($value) . '" data-input-id="' . 'destaque_actual_mercado_libre_'.$post_id . '">' . htmlspecialchars($label) . '</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php
        } ?>
    </div>

    <!-- Actions Section -->
    <div class="col-md-2 property_dashboard_action">
        <?php
        if (!isset($is_dasboard_fav)) {
            include(locate_template('templates/dashboard-templates/dashboard-unit-templates/dashboard-unit-actions.php'));
        } else {
            printf(
                '<div class="remove_fav_dash wpresidence_button" data-postid="%d">%s</div>',
                intval($post->ID),
                esc_html__('Remove From Favorites', 'wpresidence')
            );
        }
        ?>
    </div>

    <?php include(locate_template('templates/dashboard-templates/dashboard-unit-templates/per_listing_pay.php')); ?>
</div>