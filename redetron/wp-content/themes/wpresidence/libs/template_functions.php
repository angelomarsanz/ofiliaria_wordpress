<?php
/**
 * Retrieve the URL for a specific page template.
 *
 * This function checks for a cached version of the URL first. If not found or bypass is set,
 * it queries the database for pages using the specified template and returns the URL of the first match.
 * The result is then cached for future use.
 *
 * @param string $template_name The filename of the page template.
 * @param int $bypass Optional. Set to 1 to bypass the cache. Default 0.
 * @return string The URL of the page using the specified template, or home URL if not found.
 */

if (!function_exists('wpestate_get_template_link')):
 
    function wpestate_get_template_link($template_name, $bypass = 0) {
        // Generate a unique transient name, considering WPML if active
        $transient_name = 'wpestate_get_template_link_' . sanitize_key($template_name);
        if (defined('ICL_LANGUAGE_CODE')) {
            $transient_name .= '_' . ICL_LANGUAGE_CODE;
        }
    
        // Try to get the cached template link
        $template_link = ($bypass == 0) ? wpestate_request_transient_cache($transient_name) : false;
    
        // If cache is empty or bypass is set, query for the template
        if ($template_link === false) {
            $args = array(
                'post_type'      => 'page',
                'post_status'    => 'publish',
                'posts_per_page' => 1,
                'meta_key'       => '_wp_page_template',
                'meta_value'     => $template_name,
                'no_found_rows'  => true,
                'fields'         => 'ids'
            );
    
            $query = new WP_Query($args);
    
            if ($query->have_posts()) {
                $template_link = get_permalink($query->posts[0]);
            } else {
                $template_link = home_url('/');
            }
    
            // Cache the result for 24 hours
            wpestate_set_transient_cache($transient_name, $template_link, DAY_IN_SECONDS);
        }
    
        return esc_url($template_link);
    }
endif;


// basename
//get_page_template_slug
//is_page_template





if (!function_exists('wpestate_get_template_name')):
 
    function wpestate_get_template_name($postID, $bypass = 0) {
      
          return basename( get_page_template($postID));


    }
endif;