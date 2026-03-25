<?php
/*
Plugin Name: Redetronic
Plugin URI: https://redetronic.com/
Description: Funciones personalizadas para adaptar procesos de Ofiliaria, eliminar notificaciones invasivas y restringir acceso a contenidos para usuarios no registrados.
Version: 1.2.2
Author: Juan Salas (redetronic.com)
Author URI: https://redetronic.com
License: GPLv2
*/
function hide_notices_dashboard() {
    global $wp_filter;

    if (is_network_admin() and isset($wp_filter["network_admin_notices"])) {
        unset($wp_filter['network_admin_notices']);
    } elseif(is_user_admin() and isset($wp_filter["user_admin_notices"])) {
        unset($wp_filter['user_admin_notices']);
    } else {
        if(isset($wp_filter["admin_notices"])) {
            unset($wp_filter['admin_notices']);
        }
    }

    if (isset($wp_filter["all_admin_notices"])) {
        unset($wp_filter['all_admin_notices']);
    }
}
add_action( 'admin_init', 'hide_notices_dashboard' );
add_filter( 'login_display_language_dropdown', '__return_false' );
//ajustar copy backend
function eliminar_footer_admin () {
    echo "Gracias por crear tu Plataforma con <a href='https://redetronic.com' target='_blank'><b>Redetronic</b></a>"; }
add_filter('admin_footer_text', 'eliminar_footer_admin');
//eliminar version wp del footer admin
function change_footer_version() {
    return ' ';
}
add_filter( 'update_footer', 'change_footer_version', 9999 );
//Restringir contenidos a usuario no identificados
function restringir_acceso() {
    if (!is_user_logged_in() && !is_admin()) {
        // IDs de las páginas a restringir
        $paginas_restringidas = array(683,7,18); //IDs de páginas restringidas

        //ID de la categoría a restringir
        $categoria_restringida = '53'; // ID numérico

        // Redirigir si el usuario intenta acceder
        if (is_page($paginas_restringidas) || is_category($categoria_restringida)) {
            wp_redirect('https://ofiliaria.com.uy/registrate-en-ofiliaria/'); // Redirige al login y regresa a la página
            exit;
        }
    }
}
add_action('template_redirect', 'restringir_acceso');
//eliminar campos molestos de woocommece
/*add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {

unset($fields['billing']['billing_address_1']);

unset($fields['billing']['billing_address_2']);

unset($fields['billing']['billing_city']);

unset($fields['billing']['billing_postcode']);

unset($fields['billing']['billing_state']);

unset($fields['order']['order_comments']);

unset($fields['billing']['billing_address_2']);

unset($fields['billing']['billing_postcode']);

unset($fields['billing']['billing_city']);

unset( $tabs['additional_information'] );

return $fields;

}

add_filter('woocommerce_enable_order_notes_field', '__return_false'); */

//eliminar miniaturas extras del theme:
function clm_disable_image_sizes($sizes) {
    unset($sizes['thumbnail']);                 // WordPress default
    unset($sizes['medium']);
    unset($sizes['medium_large']);
    unset($sizes['large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    unset($sizes['woocommerce_thumbnail']);     // WooCommerce
    unset($sizes['woocommerce_single']);
    unset($sizes['woocommerce_gallery_thumbnail']);
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'clm_disable_image_sizes');

function clm_remove_custom_image_sizes() {
    // Avatares y miniaturas menores
    remove_image_size('custom_slider_thumb');
    remove_image_size('user_thumb');
    // Blog y sliders si no los usas
    remove_image_size('blog_unit');
    remove_image_size('post-thumbnail'); // alias de post_thumbnail_size
    remove_image_size('post_thumbnail_size');
    remove_image_size('blog_thumb');
    remove_image_size('property_featured_sidebar');
    remove_image_size('listing_full_slider');
    remove_image_size('listing_full_slider_1');
    remove_image_size('property_full_map');
    remove_image_size('custom_slider_thumb');
}
add_action('after_setup_theme', 'clm_remove_custom_image_sizes', 20);

//devolver post title de agentes para exportaciones
function export_agent_title_from_author($author_id) {

    if (empty($author_id)) {
        return '';
    }

    $agent_post_id = get_user_meta($author_id, 'user_agent_id', true);

    if (!empty($agent_post_id)) {
        return get_the_title($agent_post_id);
    }

    // fallback: buscar estate_agent que tenga meta user_agent_id = author_id
    $agent = get_posts(array(
        'post_type' => 'estate_agent',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key'   => 'user_agent_id',
                'value' => $author_id,
                'compare' => '='
            )
        )
    ));

    if (!empty($agent)) {
        return $agent[0]->post_title;
    }

    return '';
}

?>
