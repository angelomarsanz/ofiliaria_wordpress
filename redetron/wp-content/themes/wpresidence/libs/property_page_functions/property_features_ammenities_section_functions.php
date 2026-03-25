<?php  
/* MILLDONE
*  src: libs\property_page_functions\property_features_ammenities_section_functions.php
*/

/**
 * Display property features and amenities.
 *
 * This function generates the HTML for displaying property features and amenities.
 * It can output the content either as a tab or as an accordion item.
 *
 * @since 3.0.3
 *
 * @param int    $postID           The ID of the property post.
 * @param string $is_tab           Optional. Whether to display as a tab. Default ''.
 * @param string $tab_active_class Optional. CSS class for active tab. Default ''.
 * @return string|void HTML output if $is_tab is 'yes', otherwise echoes the HTML.
 */
if ( ! function_exists( 'wpestate_property_features_v2' ) ) :
    function wpestate_property_features_v2( $postID, $is_tab = '', $tab_active_class = '' ) {
        // Retrieve all label data for features
        $data = wpestate_return_all_labels_data( 'features' );

        // Prepare the label for display
        $label = wpestate_property_page_prepare_label( $data['label_theme_option'], $data['label_default'] );

        // Generate the content (list of features)
        $content = estate_listing_features( $postID, '', 0, '' );

        // Determine whether to display as a tab or accordion
        if ( $is_tab === 'yes' ) {
            // Return the content as a tab item
            return wpestate_property_page_create_tab_item( $content, $label, $data['tab_id'], $tab_active_class );
        } else {
            // Echo the content as an accordion item
            echo (
                wpestate_property_page_create_acc(
                    $content,
                    $label,
                    $data['accordion_id'],
                    $data['accordion_id'] . '_collapse'
                )
            );
        }
    }
endif;


/**
 * Generate HTML for property listing features.
 *
 * This function creates a formatted string of property features, categorizing them
 * and handling both multi-level and single-level features.
 *
 * @param int    $post_id   The ID of the property post.
 * @param string $col       The column class for feature items.
 * @param int    $is_print  Optional. Whether this is for print view. Default 0.
 * @return string The HTML markup for the property listing features.
 */
if ( ! function_exists( 'estate_listing_features' ) ) :
    function estate_listing_features( $post_id, $col, $is_print = 0 ) {
        // Retrieve property features and settings
        $property_features  = get_the_terms( $post_id, 'property_features' );
        $show_no_features   = esc_html( wpresidence_get_option( 'wp_estate_show_no_features', '' ) );
        $parsed_features    = wpestate_build_terms_array();

        $multi_return_string  = '';
        $single_return_string = '';

        if ( is_array( $parsed_features ) ) {
            foreach ( $parsed_features as $item ) {
                if ( ! empty( $item['childs'] ) ) {
                    $multi_return_string .= wpresidence_generate_multi_feature_block( $item, $show_no_features, $post_id, $property_features, $is_print, $col );
                } else {
                    $single_return_string .= wpestate_display_feature( $show_no_features, $item['name'], $post_id, $property_features, $is_print, $col );
                }
            }
        }

        // Add single features to the end if any exist
        if ( ! empty( $single_return_string ) ) {
            $multi_return_string .= sprintf(
                '<div class="listing_detail col-md-12 row feature_block_others"><div class="feature_chapter_name col-md-12">%s</div>%s</div>',
                esc_html__( 'Other Features', 'wpresidence' ),
                $single_return_string
            );
        }

        return $multi_return_string;
    }
endif;

/**
 * Generate HTML for a multi-feature block.
 *
 * @param array  $item              The feature item array.
 * @param string $show_no_features  Whether to show features that are not present.
 * @param int    $post_id           The ID of the property post.
 * @param array  $property_features The property features array.
 * @param int    $is_print          Whether this is for print view.
 * @param string $col               The column class for feature items.
 * @return string The HTML for the multi-feature block.
 */
if ( ! function_exists( 'wpresidence_generate_multi_feature_block' ) ) :
    function wpresidence_generate_multi_feature_block( $item, $show_no_features, $post_id, $property_features, $is_print, $col ) {
        $multi_return_string = sprintf(
            '<div class="listing_detail col-md-12 row feature_block_%s"><div class="feature_chapter_name col-md-12">%s</div>',
            esc_attr( $item['name'] ),
            esc_html( $item['name'] )
        );

        $feature_content = '';
        foreach ( $item['childs'] as $child ) {
            $feature_content .= wpestate_display_feature( $show_no_features, $child, $post_id, $property_features, $is_print, $col );
        }

        if ( ! empty( $feature_content ) ) {
            $multi_return_string .= $feature_content . '</div>';
            return $multi_return_string;
        }

        return '';
    }
endif;



/**
 * Display a single property feature.
 *
 * This function generates the HTML for a single property feature, including its icon
 * and whether it's present or not for the given property.
 *
 * @param string $show_no_features   Whether to show features that are not present.
 * @param string $term_name          The name of the feature term.
 * @param int    $post_id            The ID of the property post.
 * @param array  $property_features  The property features array.
 * @param int    $is_print           Whether this is for print view.
 * @param string $col                The column class for feature items.
 * @return string The HTML markup for the single property feature.
 */
if ( ! function_exists( 'wpestate_display_feature' ) ) :
    function wpestate_display_feature( $show_no_features, $term_name, $post_id, $property_features, $is_print, $col ) {
        $term_object = get_term_by( 'name', $term_name, 'property_features' );
        
        if ( ! $term_object || ! isset( $term_object->term_id ) ) {
            return '';
        }

        $term_meta = get_option( "taxonomy_$term_object->term_id" );
        $term_icon = wpresidence_get_feature_icon( $term_meta );
        $colmd = wpestat_get_content_comuns( $col, 'features' );
        $slug = sanitize_key( wpestate_limit45( sanitize_title( $term_name ) ) );
        
        $is_feature_present = is_array( $property_features ) && 
            array_search( $term_name, array_column( $property_features, 'name' ) ) !== false;

        if ( $show_no_features === 'no' && $is_print === 0 && ! $is_feature_present ) {
            return '';
        }

        return wpresidence_generate_feature_html( $is_feature_present, $term_icon, $term_name, $colmd, $slug );
    }
endif;

/**
 * Get the icon for a feature.
 *
 * @param array $term_meta The term metadata.
 * @return string The HTML for the feature icon.
 */
if ( ! function_exists( 'wpresidence_get_feature_icon' ) ) :
    function wpresidence_get_feature_icon( $term_meta ) {
        if ( empty( $term_meta ) || empty( $term_meta['category_featured_image'] ) ) {
            return '';
        }

        $term_icon_wp = wp_remote_get( $term_meta['category_featured_image'] );
        
        if ( is_wp_error( $term_icon_wp ) ) {
            return '';
        }

        return wp_remote_retrieve_body( $term_icon_wp );
    }
endif;

/**
 * Generate the HTML for a feature.
 *
 * @param bool   $is_feature_present Whether the feature is present for this property.
 * @param string $term_icon          The icon for the feature.
 * @param string $term_name          The name of the feature.
 * @param string $colmd              The column class.
 * @param string $slug               The slug of the feature.
 * @return string The HTML for the feature.
 */
if ( ! function_exists( 'wpresidence_generate_feature_html' ) ) :
    function wpresidence_generate_feature_html( $is_feature_present, $term_icon, $term_name, $colmd, $slug ) {
        $class = $is_feature_present ? '' : ' not_present';
        $icon = $term_icon ?: ( $is_feature_present ? '<i class="far fa-check-circle"></i>' : '<i class="fas fa-times"></i>' );
        
        return sprintf(
            '<div class="listing_detail%s col-md-%s %s">%s%s</div>',
            esc_attr( $class ),
            esc_attr( $colmd ),
            esc_attr( $slug ),
            $icon,
            esc_html( trim( $term_name ) )
        );
    }
endif;