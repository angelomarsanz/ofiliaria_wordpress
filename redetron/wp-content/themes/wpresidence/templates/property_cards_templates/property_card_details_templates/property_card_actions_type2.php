<?php
/** MILLDONE
 * Template for displaying property card actions (Type 2)
 * src: templates\property_cards_templates\property_card_details_templates\property_card_actions_type2.php
 * This template is responsible for rendering action buttons (share and compare)
 * on Type 2 property cards.
 */
?>
<div class="listing_actions">
    <?php 
    // Display the share button if enabled in theme options
    if (wpresidence_get_option('property_card_agent_show_share', '') == 'yes') {
        // Generate and display the share unit design
        print wpestate_share_unit_desing($postID);
        
        // Get the property thumbnail for the compare feature
        $compare = wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider_thumb');
        ?>
        <span class="share_list" data-bs-toggle="tooltip" title="<?php esc_attr_e('share', 'wpresidence'); ?>"></span>
    <?php 
    }

    // Display the compare button if enabled in theme options
    if (wpresidence_get_option('property_card_agent_show_compare', '') == 'yes') {
        // Prepare the compare image URL
        $compare_image = isset($compare[0]) ? esc_attr($compare[0]) : '';
        ?>
        <span class="compare-action" 
            data-bs-toggle="tooltip"  
            title="<?php esc_attr_e('compare', 'wpresidence'); ?>" 
            data-pimage="<?php echo $compare_image; ?>" 
            data-pid="<?php echo intval($postID); ?>">
        </span>
    <?php 
    }
    ?>
</div>