<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


if ( !function_exists( 'wpestate_chld_thm_cfg_parent_css' ) ):
    function wpestate_chld_thm_cfg_parent_css() {
        $parent_style = 'wpestate_style';

        wp_enqueue_style( 'wpestate-child-style',
            get_stylesheet_directory_uri() . '/style.css',
                array( $parent_style ),
                wp_get_theme()->get('Version')
        );

    }
endif;


add_action('after_setup_theme', function() {
    $domain = 'wpresidence';
    $locale = get_locale();

    // 1. Load parent theme translations from WP language directory
    load_theme_textdomain($domain, WP_LANG_DIR . '/themes');

    // 2. Load child theme translations
    load_child_theme_textdomain($domain, WP_LANG_DIR . '/themes');

    // 3. Fallback to child theme languages directory
    $child_mofile = get_stylesheet_directory() . "/languages/{$locale}.mo";
    if (file_exists($child_mofile)) {
        load_textdomain($domain, $child_mofile);
    }


});

add_action( 'wp_enqueue_scripts', 'wpestate_chld_thm_cfg_parent_css' );
