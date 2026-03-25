<?php
/** MILLDONE
 * Template for displaying Property Card Details (Type 5)
 * src: templates\property_cards_templates\property_card_details_templates\property_card_details_type5.php
 * This file is part of the WpResidence theme and is used to render
 * the details section of a property card for Type 5 layout.
 */

// Set up necessary variables
$property_size = wpestate_get_converted_measure($postID, 'property_size');
$property_bedrooms = get_post_meta($postID, 'property_bedrooms', true) ?? '';
$property_bathrooms = get_post_meta($postID, 'property_bathrooms', true) ?? '';
$prop_id = $postID;
?>

<div class="property_unit_type5_content_details_second_row">
    <?php
    // Display number of bedrooms
    if ($property_bedrooms != '' && $property_bedrooms != 0) {
        echo '<div class="inforoom_unit_type5">' . esc_html($property_bedrooms) . ' ' . esc_html__('BD', 'wpresidence') . '</div>';
    }

    // Display number of bathrooms
    if ($property_bathrooms != '' && $property_bathrooms != 0) {
        echo '<div class="inforoom_unit_type5">' . esc_html($property_bathrooms) . ' ' . esc_html__('BA', 'wpresidence') . '<span></span></div>';
    }

    // Display property size
    if ($property_size != '' && strval($property_size) != '0') {
        echo '<div class="inforoom_unit_type5">' . trim($property_size) . '</div>';
    }
    ?>
</div>