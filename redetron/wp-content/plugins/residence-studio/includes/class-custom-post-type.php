<?php
class WpResidence_Custom_Post_Type {

    public function __construct() {
        add_action('after_setup_theme', [$this, 'register_custom_post_type']);
    }

    public function register_custom_post_type() {
        register_post_type('wpestate-studio', array(
            'labels' => array(
                'name' => esc_html__('WpResidence Studio Templates', 'wpestate-studio-templates'),
                'singular_name' => esc_html__('WpResidence Studio Templates', 'wpestate-studio-templates'),
                'add_new' => esc_html__('Add New WpResidence Studio Template', 'wpestate-studio-templates'),
                'add_new_item' => esc_html__('Add WpResidence Studio Template', 'wpestate-studio-templates'),
                'edit' => esc_html__('Edit WpResidence Studio Templates', 'wpestate-studio-templates'),
                'edit_item' => esc_html__('Edit WpResidence Studio Template', 'wpestate-studio-templates'),
                'new_item' => esc_html__('New WpResidence Studio Template', 'wpestate-studio-templates'),
                'view' => esc_html__('View WpResidence Studio Templates', 'wpestate-studio-templates'),
                'view_item' => esc_html__('View WpResidence Studio Template', 'wpestate-studio-templates'),
                'search_items' => esc_html__('Search WpResidence Studio Templates', 'wpestate-studio-templates'),
                'not_found' => esc_html__('No WpResidence Studio Templates found', 'wpestate-studio-templates'),
                'not_found_in_trash' => esc_html__('No WpResidence Studio Templates found in trash', 'wpestate-studio-templates'),
                'parent' => esc_html__('Parent WpResidence Studio Templates', 'wpestate-studio-templates')
            ),
            'public' => true,
            'has_archive' => false,
            'hierarchical' => false,
            'can_export' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'rewrite' => array('slug' => 'wpestate-studio-templates'),
            'supports' => array('title', 'thumbnail', 'page-attributes'),
            'can_export' => true,
            'show_in_rest' => true,
            'rest_base' => 'wpestate-studio-templates',
            'menu_icon' => 'dashicons-welcome-widgets-menus',
            'exclude_from_search' => true
        ));
        add_post_type_support('wpestate-studio', 'elementor');
    }
}

new WpResidence_Custom_Post_Type();
