<?php
/* MILLDONE
*  src: libs\property_page_functions\property_map_functions.php
*/

/**
 * Display property map.
 *
 * This function generates the HTML for displaying a property map. It can output
 * the content either as a tab or as an accordion item.
 *
 * @since 3.0.3
 *
 * @param int    $postID           The ID of the property post.
 * @param string $is_tab           Optional. Whether to display as a tab. Default ''.
 * @param string $tab_active_class Optional. CSS class for active tab. Default ''.
 * @return string|void HTML output if $is_tab is 'yes', otherwise echoes the HTML.
 */
if ( ! function_exists( 'wpestate_property_map_v2' ) ) :
    function wpestate_property_map_v2( $postID, $is_tab = '', $tab_active_class = '' ) {
        // Retrieve label data for map
        $data = wpestate_return_all_labels_data( 'map' );

        // Prepare the label for display
        $label = wpestate_property_page_prepare_label( $data['label_theme_option'], $data['label_default'] );

        // Generate the map content using shortcode
        $content = do_shortcode( sprintf( '[property_page_map propertyid="%d"][/property_page_map]', $postID ) );

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