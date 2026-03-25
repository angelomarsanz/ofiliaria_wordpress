<?php
/** MILLDONE
 * Template for displaying property details on a card in the WpResidence theme.
 * This file is typically included in property listing templates.
 * src: templates\property_cards_templates\property_card_details_templates\property_card_details_default.php 
 * @package WpResidence
 * @subpackage PropertyCard
 */

// Retrieve and sanitize property details
$link                   = esc_url(get_permalink());
$property_rooms         = floatval(get_post_meta($postID, 'property_bedrooms', true) ?: 0);
$property_bathrooms     = floatval(get_post_meta($postID, 'property_bathrooms', true) ?: 0);
$property_size          = wpestate_get_converted_measure($postID, 'property_size');

/**
 * Display property details
 * Each detail is wrapped in a span with a specific class for styling
 */
?>
<div class="property_listing_details">
    <?php
    // Display number of rooms
    if ($property_rooms > 0) {
        echo '<span class="inforoom">';
     
        include(locate_template('templates/svg_icons/inforoom_unit_card_default.svg'));  
        echo esc_html($property_rooms) . '</span>';
    }

    // Display number of bathrooms
    if ($property_bathrooms > 0) {
        echo '<span class="infobath">';
        include(locate_template('templates/svg_icons/infobath_unit_card_default.svg'));  
    
        echo esc_html($property_bathrooms) . '</span>';
    }

    // Display property size
    if (!empty($property_size)) {
        echo '<span class="infosize">';
        include(locate_template('templates/svg_icons/infosize_unit_card_default.svg'));  

        echo wp_kses_post($property_size) . '</span>';
    }

    // Display "details" link
    $target = esc_attr(wpresidence_get_option('wp_estate_unit_card_new_page', ''));
    echo sprintf(
        '<a href="%s" target="%s" class="unit_details_x">%s</a>',
        $link,
        $target,
        esc_html__('details', 'wpresidence')
    );
    ?>
</div>