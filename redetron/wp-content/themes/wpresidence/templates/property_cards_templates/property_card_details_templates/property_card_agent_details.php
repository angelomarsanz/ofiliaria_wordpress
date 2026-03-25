<?php
/** MILLDONE
 * Template for displaying agent information on property cards
 * src: templates\property_cards_templates\property_card_details_templates\property_card_agent_details.php
 * This template is part of the WpResidence theme and is used to show
 * agent details, including their image and name, on property listings.
 *
 * @package WpResidence
 * @subpackage PropertyCard
 * @since WpResidence 1.0
 */

// Retrieve the agent ID associated with the property
$agent_id = intval(get_post_meta($postID, 'property_agent', true));

// Get the agent's profile picture
$thumb_id = get_post_thumbnail_id($agent_id);
$agent_face = wp_get_attachment_image_src($thumb_id, 'agent_picture_thumb');

// Set default image if agent picture is not available
if (empty($agent_face[0])) {
    $agent_face[0] = get_theme_file_uri('/img/default-user_1.png');
}

// Retrieve theme options for displaying agent image and name
$show_agent_image = wpresidence_get_option('property_card_agent_section_tab_show_agent_image', '');
$show_agent_name = wpresidence_get_option('property_card_agent_section_tab_show_agent_name', '');
?>

<div class="property_agent_wrapper property_agent_wrapper_type1">
    <span><strong><?php esc_html_e('Agent', 'wpresidence'); ?>:</strong></span>
    <?php
    if ($agent_id != 0) {
        // Display linked agent information if an agent is assigned
        $agent_permalink = esc_url(get_permalink($agent_id));
        $agent_name = get_the_title($agent_id);
        ?>
        <a href="<?php echo $agent_permalink; ?>">
            <?php
            // Display agent image if enabled in theme options
            if ($show_agent_image == 'yes') {
                echo '<i class="far fa-user-circle unit3agent"></i> ';
            }
            // Display agent name if enabled in theme options
            if ($show_agent_name == 'yes') {
                echo esc_html($agent_name);
            }
            ?>
        </a>
        <?php
    } else {
        // Display post author's name if no agent is assigned
        $author_first_name = get_the_author_meta('first_name', get_post_field('post_author', $postID) );
        $author_last_name = get_the_author_meta('last_name', get_post_field('post_author', $postID) );
        echo esc_html($author_first_name . ' ' . $author_last_name);
    }
    ?>
</div>