<?php
/** MILLDONE
 * Template for displaying agent details on property cards (Type 8)
 * src: templates\property_cards_templates\property_card_details_templates\property_card_agent_details_type8.php
 * This template is part of the WpResidence theme and is used to show
 * agent information on property cards, including their image and name.
 *
 * @package WpResidence
 * @subpackage PropertyCard
 * @since WpResidence 1.0
 */

// Get the agent ID associated with the property
$agent_id = intval(get_post_meta($postID, 'property_agent', true));

// WPML compatibility: Translate the agent ID if WPML is active
if (function_exists('icl_translate')) {
    $agent_id = apply_filters('wpml_object_id', $agent_id, 'estate_agent');
}

// Get the agent's profile picture
$thumb_id = get_post_thumbnail_id($agent_id);
$agent_face = wp_get_attachment_image_src($thumb_id, 'agent_picture_thumb');
$agent_face_image = '';

if ($agent_face) {
    $agent_face_image = $agent_face[0];
}

// If no agent is assigned or no agent picture is found, use author's picture or default image
if ($agent_id == 0 || empty($agent_face_image)) {
    $post_author_id = get_post_field('post_author', $postID);
    $agent_face_image = get_the_author_meta('custom_picture',  $post_author_id );
    if (empty($agent_face_image)) {
        $agent_face_image = get_theme_file_uri('/img/default-user_1.png');
    }
}

// Get theme options for displaying agent image and name
$show_agent_image = wpresidence_get_option('property_card_agent_section_tab_show_agent_image', '');
$show_agent_name = wpresidence_get_option('property_card_agent_section_tab_show_agent_name', '');
?>

<div class="property_agent_wrapper">
    <?php if ($show_agent_image == 'yes') : ?>
        <a href="<?php echo esc_url(get_permalink($agent_id)); ?>" class="property_agent_image" style="background-image:url('<?php echo esc_attr($agent_face_image); ?>')"></a> 
    <?php endif; ?>

    <?php if ($show_agent_name == 'yes') : ?>
        <?php if ($agent_id != 0) : ?>
            <a class="wpestate_card_agent_link" href="<?php echo esc_url(get_permalink($agent_id)); ?>">
                <?php echo get_the_title($agent_id); ?>
            </a>
        <?php else : ?>
            <?php echo get_the_author_meta('first_name', get_post_field('post_author', $postID)) . ' ' . get_the_author_meta('last_name',get_post_field('post_author', $postID)); ?>
        <?php endif; ?>
    <?php endif; ?>
</div>