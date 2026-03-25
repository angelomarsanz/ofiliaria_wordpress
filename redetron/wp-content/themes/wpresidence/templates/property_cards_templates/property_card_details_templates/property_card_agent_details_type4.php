<?php
/**MILLDONE
 * Template for displaying Property Card Agent Details (Type 4)
 * src: templates\property_cards_templates\property_card_details_templates\property_card_agent_details_type4.php
 * This file is part of the WpResidence theme and is used to render
 * the agent details section of a property card for Type 4 layout.
 */

// Set up necessary variables
$agent_id = intval(get_post_meta($postID, 'property_agent', true));
$thumb_id = get_post_thumbnail_id($agent_id);
$agent_face = wp_get_attachment_image_src($thumb_id, 'agent_picture_thumb');

// If no agent is set or agent image is missing
if ($agent_id == 0 || (isset($agent_face[0]) && $agent_face[0] == '')) {
    $post_author_id = get_post_field('post_author', $postID);
    $custom_picture = get_the_author_meta('custom_picture', $post_author_id);
    
    // Initialize $agent_face as array if it's not already
    if (!is_array($agent_face)) {
        $agent_face = array();
    }
    
    // Assign the picture URL to index 0
    $agent_face[0] = $custom_picture ? $custom_picture : get_theme_file_uri('/img/default-user_1.png');
}

// Check if agent image should be displayed
if (wpresidence_get_option('property_card_agent_section_tab_show_agent_image', '') == 'yes') {
?>
    <div class="property_agent_wrapper">
        <?php
        // Link to agent's page
        $agent_link = esc_url(get_permalink($agent_id));
        echo '<a href="' . $agent_link . '">';
        ?>
        <div class="property_agent_image" style="background-image:url('<?php echo esc_attr($agent_face[0]); ?>')"></div>
        <div class="property_agent_image_sign"><i class="far fa-user-circle"></i></div>
        <?php echo '</a>'; ?>
    </div>  
<?php
}
?>