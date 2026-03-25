<?php
/** MILLDONE
 * Template for displaying action buttons on a property card in the WpResidence theme.
 * This file is typically included in property listing templates.
 * src: templates\property_cards_templates\property_card_details_templates\property_card_actions_type_default.php
 * @package WpResidence
 * @subpackage PropertyCard
 */

// Get current user information
$current_user = wp_get_current_user();
$userID = $current_user->ID;

// Get user favorites
$user_option = 'favorites' . $userID;
$current_favorites = get_option($user_option, array());

// Determine if the current property is in favorites
$is_favorite = in_array($postID, $current_favorites);
$favorite_class = $is_favorite ? 'icon-fav-on' : 'icon-fav-off';
$favorite_text = $is_favorite ? esc_html__('remove from favorites', 'wpresidence') : esc_html__('add to favorites', 'wpresidence');

// Get theme options for displaying various elements
$show_share = wpresidence_get_option('property_card_agent_show_share', '') === 'yes';
$show_favorite = wpresidence_get_option('property_card_agent_show_favorite', '') === 'yes';
$show_compare = wpresidence_get_option('property_card_agent_show_compare', '') === 'yes';
?>

<div class="listing_actions">
    <?php if ($show_share) : ?>
        <?php echo wpestate_share_unit_desing($postID); ?>
        <span class="share_list" data-bs-toggle="tooltip" title="<?php esc_attr_e('share', 'wpresidence'); ?>"></span>
    <?php endif; ?>

    <?php if ($show_favorite && !isset($remove_fav)) : ?>
        <span class="icon-fav <?php echo esc_attr($favorite_class); ?>" 
            data-bs-toggle="tooltip" 
            title="<?php echo esc_attr($favorite_text); ?>" 
            data-postid="<?php echo intval($postID); ?>">
        </span>
    <?php endif; ?>

    <?php if ($show_compare) : 
        $compare = wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider_thumb');
        $compare_src = isset($compare[0]) ? esc_attr($compare[0]) : '';
    ?>
        <span class="compare-action" 
            data-bs-toggle="tooltip"
            title="<?php esc_attr_e('compare', 'wpresidence'); ?>" 
            data-pimage="<?php echo $compare_src; ?>" 
            data-pid="<?php echo intval($postID); ?>">
        </span>
    <?php endif; ?>
</div>