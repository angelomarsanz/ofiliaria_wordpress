<?php


if (!function_exists('wpestate_topbar_classes')):
    /**
     * Generate CSS classes for the top bar based on theme options and post metadata.
     *
     * This function determines the appropriate CSS classes for the top bar,
     * considering mobile visibility, transparency, and border settings.
     * It handles both singular pages (posts, pages) and archive pages (category, taxonomy).
     *
     * @global WP_Post $post The current post object.
     * @return string A space-separated list of CSS classes for the top bar.
     */
    function wpestate_topbar_classes() {
        global $post;

        // Set initial class based on mobile menu visibility option
        $topbar_class = 'topbar_show_mobile_' . wpresidence_get_option('wp_estate_show_top_bar_user_menu_mobile', '');

        // Override class if mobile sticky header is enabled
        if (wpresidence_get_option('wp_estate_mobile_sticky_header') == 'yes') {
            $topbar_class = 'topbar_show_mobile_no';
        }

        // Get global settings for transparency and border
        $topbar_transparent_page_global = wpresidence_get_option('wp_estate_topbar_transparent', '');
        $topbar_border_global = wpresidence_get_option('wp_estate_topbar_border', '');

        // Check if we're on a singular page (post or page, not category or taxonomy)
        $is_singular = isset($post->ID) && !is_tax() && !is_category()  && !is_search()  && !is_404();

        if ($is_singular) {
            // Handle singular pages (posts, pages)
            $topbar_transparent_page = get_post_meta($post->ID, 'topbar_transparent', true);
            $topbar_border_page = get_post_meta($post->ID, 'topbar_border_transparent', true);

            // Apply transparency class based on page setting or global setting
            if ($topbar_transparent_page == "yes" || ($topbar_transparent_page_global == 'yes' && ($topbar_transparent_page == "global" || $topbar_transparent_page == ""))) {
                $topbar_class .= ' transparent_topbar ';
            }

            // Apply border class based on page setting or global setting
            if ($topbar_border_page == "yes" || ($topbar_border_global == 'yes' && ($topbar_border_page == "global" || $topbar_border_page == ""))) {
                $topbar_class .= ' transparent_border_topbar ';
            }
        } else {
            // Handle non-singular pages (archives, categories, etc.)
            // Apply classes based on global settings only
            if ($topbar_transparent_page_global == 'yes') {
                $topbar_class .= ' transparent_topbar ';
            }
            if ($topbar_border_global == 'yes') {
                $topbar_class .= ' transparent_border_topbar ';
            }
        }

        return $topbar_class;
    }
endif;






if (!function_exists('wpestate_header_classes')):
    /**
     * Generate an array of CSS classes and properties for the website header.
     * 
     * This function determines various classes based on theme options, page templates,
     * and post metadata. It handles different scenarios like user dashboard, half map pages,
     * and transparent headers.
     *
     * @global WP_Post $post The current post object.
     * @return array An associative array of header-related classes and properties.
     */
    function wpestate_header_classes() {
        global $post;
        $return = array();

        // Check if we're on the user dashboard
        $wpestate_is_user_dashboard = wpestate_is_user_dashboard();
        
        // Determine if we're on a half map page
        $wpestate_half_map_conditions = isset($post->ID) ? 
            wpestate_half_map_conditions($post->ID) : 
            wpestate_half_map_conditions(0);
        
        // Get the current page template
        $page_template = isset($post->ID) ? get_post_meta($post->ID, '_wp_page_template', true) : '';
        $page_template = ($page_template);
        
        // Determine if the layout is wide or boxed
        $wide_status = esc_html(wpresidence_get_option('wp_estate_wide_status', ''));
        $wide_class = ($wide_status == 1 || $page_template == 'page-templates/splash_page.php') ? " wide " : " wpresidence_is_boxed ";
        
      

        // Set body class for half map pages
        $halfmap_body_class = $wpestate_half_map_conditions ? " half_map_body " : '';
        
        // Add class if top bar user menu is enabled
        if (esc_html(wpresidence_get_option('wp_estate_show_top_bar_user_menu', '')) == "yes") {
            $halfmap_body_class .= " wpresidece_has_top_bar ";
        }

        // Get logo header type
        $logo_header_type = wpresidence_get_option('wp_estate_logo_header_type', '');
        
        // if we have dasboard or half map we need to adjust the header type
        if(  $logo_header_type=='type3' ||  $logo_header_type=='type4' ) {
            if( wpestate_is_user_dashboard() || wpestate_half_map_conditions($post->ID) ){
              $logo_header_type='type1';
            }
          }

          
        $logo_header_type = $logo_header_type ?: 'type1';

        // Determine if header should be transparent
        $header_transparent_class = '';
        $header_transparent = wpresidence_get_option('wp_estate_header_transparent', '');
        if (isset($post->ID) && !is_tax() && !is_category() && !is_search()  && !is_404() ) {
            $header_transparent_page = get_post_meta($post->ID, 'header_transparent', true);
            if (($header_transparent_page == "global" || $header_transparent_page == "") && $header_transparent == 'yes') {
                $header_transparent_class = ' header_transparent ';
            } elseif ($header_transparent_page == "yes") {
                $header_transparent_class = ' header_transparent ';
            }
        } elseif ($header_transparent == 'yes') {
            $header_transparent_class = ' header_transparent ';
        }

        // Get logo images
        $logo = wpresidence_get_option('wp_estate_logo_image', 'url');
        $stikcy_logo_image = wpresidence_get_option('wp_estate_stikcy_logo_image', 'url');
        $transparent_logo = esc_html(wpresidence_get_option('wp_estate_transparent_logo_image', 'url'));
        
        // Use transparent logo if applicable
        if ((trim($header_transparent_class) == 'header_transparent' || $page_template == 'page-templates/splash_page.php') && $transparent_logo != '') {
            $logo = $transparent_logo;
        }

        // Handle user dashboard header visibility
        $show_header_dashboard = wpresidence_get_option('wp_estate_show_header_dashboard', '');
        if ($wpestate_is_user_dashboard) {
            if ($show_header_dashboard == 'no') {
                $halfmap_body_class .= " dash_no_header ";
                $logo_header_type = '';
            } else {
                $logo_header_type = "type1  ";
                $header_transparent_class = '';
            }
        }

        // Additional classes based on user login and property submit options
        $show_top_bar_user_login = esc_html(wpresidence_get_option('wp_estate_show_top_bar_user_login', '')) ?: 'yes';
        $show_top_bar_user_login_class = $show_top_bar_user_login != 'yes' ? " no_user_submit " : '';
        
        $show_submit_symbol = esc_html(wpresidence_get_option('wp_estate_show_submit', ''));
        $show_submit_symbol_class = $show_submit_symbol != 'yes' ? " no_property_submit" : '';

        // Compile classes
        $main_wrapper_class = $wide_class . ' has_header_' . esc_attr($logo_header_type) . ' ' . esc_attr($header_transparent_class);
        $master_header_class = ' ' . esc_attr($wide_class);
        $header_wrapper_class = esc_attr($show_top_bar_user_login_class) . ' header_' . esc_attr($logo_header_type) . 
                                ' hover_type_' . esc_attr(wpresidence_get_option('wp_estate_top_menu_hover_type', '')) . 
                                esc_attr($show_submit_symbol_class);

        // Prepare return array
        $return = array(
            'main_wrapper_class' => $main_wrapper_class,
            'master_header_class' => $master_header_class,
            'header_wrapper_class' => $header_wrapper_class,
            'header_wrapper_inside_class' => '',
            'stikcy_logo_image' => $stikcy_logo_image,
            'logo' => $logo,
            'wide_class' => $wide_class
        );

        return $return;
    }
endif;


