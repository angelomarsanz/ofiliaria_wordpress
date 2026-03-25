<?php
/**
 * Template for displaying Property Card Details (Type 3)
 * 
 * This file is part of the WpResidence theme and is used to render
 * the details section of a property card for Type 3 layout.
 */

// Set up necessary variables
$link = esc_url(get_permalink());
$property_bedrooms = floatval(get_post_meta($postID, 'property_bedrooms', true) ?? '');
$property_bathrooms = floatval(get_post_meta($postID, 'property_bathrooms', true) ?? '');
$property_size = wpestate_get_converted_measure($postID, 'property_size');
$property_garage_size = get_post_meta($postID, 'property-garage-size', true);
$property_lot_size = wpestate_get_converted_measure($postID, 'property_lot_size');
?>

<div class="property_listing_details">
    <?php
    // Display number of bedrooms
    if ($property_bedrooms != '' && $property_bedrooms != 0) {
        echo '<div class="property_listing_details_v3_item" data-bs-toggle="tooltip" title="' . esc_attr__('Bedrooms', 'wpresidence') . '">';
        echo '<div class="icon_label">';
        include(locate_template('css/css-images/icons/bedrooms7.svg'));
        echo '</div>';
        echo esc_html($property_bedrooms);
        echo '</div>';
    }

    // Display number of bathrooms
    if ($property_bathrooms != '' && $property_bathrooms != 0) {
        echo '<div class="property_listing_details_v3_item" data-bs-toggle="tooltip" title="' . esc_attr__('Bathrooms', 'wpresidence') . '">';
        echo '<div class="icon_label">';
        include(locate_template('css/css-images/icons/bath7.svg'));
        echo '</div>';
        echo esc_html($property_bathrooms);
        echo '</div>';
    }

    // Display property size
    if ($property_size != '') {
        echo '<div class="property_listing_details_v3_item" data-bs-toggle="tooltip" title="' . esc_attr__('Property Size', 'wpresidence') . '">';
        echo '<div class="icon_label">';
        include(locate_template('css/css-images/icons/size7.svg'));
        echo '</div>';
        echo trim($property_size);
        echo '</div>';
    }

    // Display garage size
    if ($property_garage_size != '') {
        echo '<div class="property_listing_details_v3_item" data-bs-toggle="tooltip" title="' . esc_attr__('Garage Size', 'wpresidence') . '">';
        echo '<div class="icon_label">';
        include(locate_template('css/css-images/icons/car7.svg'));
        echo '</div>';
        echo trim($property_garage_size);
        echo '</div>';
    }
    ?>
</div>