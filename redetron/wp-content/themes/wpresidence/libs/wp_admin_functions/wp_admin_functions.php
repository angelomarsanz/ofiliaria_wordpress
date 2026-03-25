<?php


/**
 * WPResidence Admin Menu functions for managing the WordPress admin menu
 * specific to the WPResidence theme, including adding custom submenu items.
 *
 * @package WPResidence
 * @subpackage AdminCustomization
 * @since 1.0.0
 */

// Only run in admin
if ( is_admin() ) {
    add_action( 'admin_menu', 'wpestate_manage_admin_menu' );
}

if ( ! function_exists( 'wpestate_manage_admin_menu' ) ) :
    /**
     * Manage WPResidence admin menu
     *
     * This function adds custom submenu items to the WordPress admin menu
     * for the WPResidence theme, including demo import and cache clearing options.
     */
    function wpestate_manage_admin_menu() {
       // Define the parent slug for Redux Framework menu
       $redux_parent_slug = 'wpresidence_admin'; // Default slug for Redux menu, adjust if necessary

       // Check if Redux Framework is active and accessible
       if (!class_exists('ReduxFramework')) {
           return; // Exit if Redux is not active
       }

       // Define the submenu label and link
       $label_import = esc_html__("Import Demo","wpresidence"); ;
       $link = 'themes.php?page=one-click-demo-import';

       // Check if the One Click Demo Import plugin is active
       if (!class_exists('OCDI_Plugin')) {
           $label_import = esc_html__( "Import Demo - Activate Plugin","wpresidence"); 
           $link         = admin_url('plugins.php'); // Redirect to plugins page if plugin isn't active
       }

       // Add the submenu under Redux Framework menu
       add_submenu_page(
           $redux_parent_slug, // Parent menu slug (Redux Framework menu)
           $label_import,      // Page title
           $label_import,      // Menu title
           'manage_options',   // Capability
           $link,              // Menu slug or link
           '',                 // Callback (not used for external links)
           1                   // Position (low value ensures it appears first)
       );

        add_submenu_page(
            'libs/theme-admin.php',
            $label_import,
            $label_import,
            'manage_options',
            $link,
            ''
        );
        
        add_submenu_page(
            'libs/theme-admin.php',
            'Clear Theme Cache',
            'Clear Theme Cache',
            'manage_options',
            'libs/theme-cache.php',
            'wpestate_clear_cache_theme'
        );
        
        // Include required files
        require_once get_theme_file_path( 'libs/property-admin.php' );
        require_once get_theme_file_path( 'libs/theme-admin.php' );
    }
endif;





/**
 * Counts the total number of pages in the WordPress site.
 *
 * This function retrieves the count of all pages, regardless of their status.
 * It's used within the WpResidence theme to determine the total number of pages.
 *
 * @package WpResidence
 * @subpackage Functions
 * @since WpResidence 1.0
 *
 * @return int The total number of pages.
 */

if (!function_exists('wpestate_how_many_pages')) :
    function wpestate_how_many_pages() {
        // Set up arguments for WP_Query
        $args = array(
            'post_type'   => 'page',
            'post_status' => 'any',
            'fields'      => 'ids', // Only get post IDs to improve performance
            'nopaging'    => true,  // Get all pages without pagination
        );

        // Perform the query
        $query = new WP_Query($args);

        // Get the total number of pages found
        $current_pages = $query->found_posts;

        // Clean up after the query
        wp_reset_postdata();

        // Return the total number of pages
        return $current_pages;
    }
endif;




if( !function_exists('wpestate_ajax_apperance_set') ):
    function wpestate_ajax_apperance_set(){
        $args = array(
            'post_type'         => 'estate_property',
            'post_status'       => 'any',
            'paged'             => -1,
        );

        $query = new WP_Query($args);

        $current_listed= $query->found_posts;
        wp_reset_postdata();
        wp_reset_query();
        return $current_listed;

    }
endif;


/**
 * Counts the total number of properties in the WordPress site.
 *
 * This function retrieves the count of all estate_property posts, regardless of their status.
 * It's used within the WpResidence theme to determine the total number of properties.
 * Note: The function name doesn't accurately reflect its purpose and should be considered for renaming.
 *
 * @package WpResidence
 * @subpackage Functions
 * @since WpResidence 1.0
 *
 * @return int The total number of properties.
 */

if (!function_exists('wpestate_ajax_apperance_set')) :
    function wpestate_ajax_apperance_set() {
        // Set up arguments for WP_Query
        $args = array(
            'post_type'   => 'estate_property',
            'post_status' => 'any',
            'fields'      => 'ids', // Only get post IDs to improve performance
            'nopaging'    => true,  // Get all properties without pagination
        );

        // Perform the query
        $query = new WP_Query($args);

        // Get the total number of properties found
        $current_listed = $query->found_posts;

        // Clean up after the query
        wp_reset_postdata();

        // Return the total number of properties
        return $current_listed;
    }
endif;





/**
 * Updates the Google Maps API key in WpResidence theme options via AJAX.
 *
 * This function is triggered by an AJAX request to update the Google Maps API key.
 * It checks for proper permissions and nonce verification before updating the option.
 *
 * @package WpResidence
 * @subpackage AJAX
 * @since WpResidence 1.0
 */

// Register the AJAX action for both logged in and non-logged in users
add_action('wp_ajax_wpestate_ajax_start_map', 'wpestate_ajax_start_map');
add_action('wp_ajax_nopriv_wpestate_ajax_start_map', 'wpestate_ajax_start_map');

if (!function_exists('wpestate_ajax_start_map')) :
    function wpestate_ajax_start_map() {
        // Verify nonce for security
        check_ajax_referer('wpestate_setup_nonce', 'security');

        // Check if user has administrator capabilities
        if (!current_user_can('administrator')) {
            wp_send_json_error('Unauthorized access');
        }

        // Sanitize and validate the API key
        $api_key = isset($_POST['api_key']) ? sanitize_text_field($_POST['api_key']) : '';

        if (empty($api_key)) {
            wp_send_json_error('API key cannot be empty');
        }

        // Update the option using Redux framework
        if (class_exists('Redux')) {
            Redux::setOption('wpresidence_admin', 'wp_estate_api_key', $api_key);
            wp_send_json_success('API key updated successfully');
        } else {
            wp_send_json_error('Redux framework not available');
        }
    }
endif;












/**
 * Updates general settings in WpResidence theme options via AJAX.
 *
 * This function is triggered by an AJAX request to update several general settings
 * including country, measurement system, currency symbol, and date language.
 * It checks for proper permissions and nonce verification before updating the options.
 *
 * @package WpResidence
 * @subpackage AJAX
 * @since WpResidence 1.0
 */

// Register the AJAX action for both logged in and non-logged in users
add_action('wp_ajax_wpestate_ajax_general_set', 'wpestate_ajax_general_set');
add_action('wp_ajax_nopriv_wpestate_ajax_general_set', 'wpestate_ajax_general_set');

if (!function_exists('wpestate_ajax_general_set')) :
    function wpestate_ajax_general_set() {
        // Verify nonce for security
        check_ajax_referer('wpestate_setup_nonce', 'security');

        // Check if user has administrator capabilities
        if (!current_user_can('administrator')) {
            wp_send_json_error('Unauthorized access');
        }

        // Sanitize and validate input data
        $settings = array(
            'wp_estate_general_country' => isset($_POST['general_country']) ? sanitize_text_field($_POST['general_country']) : '',
            'wp_estate_measure_sys'     => isset($_POST['measure_sys']) ? sanitize_text_field($_POST['measure_sys']) : '',
            'wp_estate_currency_symbol' => isset($_POST['currency_symbol']) ? sanitize_text_field($_POST['currency_symbol']) : '',
            'wp_estate_date_lang'       => isset($_POST['date_lang']) ? sanitize_text_field($_POST['date_lang']) : '',
        );

        // Check if Redux framework is available
        if (!class_exists('Redux')) {
            wp_send_json_error('Redux framework not available');
        }

        // Update options using Redux framework
        $updated = array();
        foreach ($settings as $option_name => $option_value) {
            if (!empty($option_value)) {
                Redux::setOption('wpresidence_admin', $option_name, $option_value);
                $updated[] = $option_name;
            }
        }

        // Check if any options were updated
        if (empty($updated)) {
            wp_send_json_error('No valid options to update');
        }

        wp_send_json_success('General settings updated successfully: ' . implode(', ', $updated));
    }
endif;




/**
 * Updates appearance settings in WpResidence theme options via AJAX.
 *
 * This function is triggered by an AJAX request to update appearance settings
 * including property list type and property unit.
 * It checks for proper permissions and nonce verification before updating the options.
 *
 * @package WpResidence
 * @subpackage AJAX
 * @since WpResidence 1.0
 */

add_action( 'wp_ajax_wpestate_ajax_apperance_set', 'wpestate_ajax_apperance_set' );  
    if( !function_exists('wpestate_ajax_apperance_set') ):
    function wpestate_ajax_apperance_set(){ 
        check_ajax_referer( 'wpestate_setup_nonce', 'security' );
        $property_list_type_adv =   sanitize_text_field($_POST['property_list_type_adv']) ;
      


        if(current_user_can('administrator')){
            Redux::setOption('wpresidence_admin','wp_estate_property_list_type_adv', $property_list_type_adv);
            Redux::setOption('wpresidence_admin','wp_estate_prop_unit', $prop_unit);
        }
        die();


    }
endif; 