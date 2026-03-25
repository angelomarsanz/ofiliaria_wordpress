<?php
/** MILLDONE
 * Template for displaying agent details on a property card in the WpResidence theme.
 * This file is typically included in property listing templates.
 * src: templates\property_cards_templates\property_card_details_templates\property_card_agent_details_default.php
 * @package WpResidence
 * @subpackage PropertyCard
 */

// Retrieve agent ID associated with the property
$agent_id = intval(get_post_meta($postID, 'property_agent', true));

// Apply WPML filter if the function exists
if (function_exists('icl_translate')) {
    $agent_id = apply_filters('wpml_object_id', $agent_id, 'estate_agent');
}

// Get agent's profile picture
$thumb_id = get_post_thumbnail_id($agent_id);
$agent_face = wp_get_attachment_image_src($thumb_id, 'agent_picture_thumb');
$agent_face_image = $agent_face ? $agent_face[0] : '';
// Get the post author ID
$post_author_id = get_post_field('post_author', $postID);

// If no agent is assigned or no agent picture is available, use author's picture
if ($agent_id == 0 || empty($agent_face_image)) {




    $author_picture_meta = get_the_author_meta('custom_picture', $post_author_id);
    $agent_face_image = !empty($author_picture_meta) ? $author_picture_meta : get_theme_file_uri('/img/default-user_1.png');
}

// Get theme options for displaying agent image and name
$show_agent_image = wpresidence_get_option('property_card_agent_section_tab_show_agent_image', '') === 'yes';
$show_agent_name = wpresidence_get_option('property_card_agent_section_tab_show_agent_name', '') === 'yes';
?>

<div class="property_agent_wrapper">
    <?php if ($show_agent_image) : ?>
        <div class="property_agent_image" style="background-image:url('<?php echo esc_attr($agent_face_image); ?>')"></div>
        <div class="property_agent_image_sign"><i class="far fa-user-circle"></i></div>
    <?php endif; ?>

    <?php if ($show_agent_name) : ?>
        <?php if ($agent_id != 0) : ?>
            <a class="wpestate_card_agent_link" href="<?php echo esc_url(get_permalink($agent_id)); ?>">
                <?php echo esc_html(get_the_title($agent_id)); ?>
            </a>
        <?php else : ?>
            <?php echo esc_html(get_the_author_meta('first_name', $post_author_id) . ' ' . get_the_author_meta('last_name', $post_author_id)); ?>
        <?php endif; ?>
    <?php endif; ?>
</div>