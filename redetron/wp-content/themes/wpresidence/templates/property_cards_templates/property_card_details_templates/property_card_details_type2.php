<?php
/** MILLDONE
 * Template for displaying property details in a type 2 card layout
 * src: templates\property_cards_templates\property_card_details_templates\property_card_details_type2.php
 * This template is part of the WpResidence theme and is used to show
 * key property features such as size, number of bedrooms, bathrooms,
 * and garage spaces in a compact format within property cards.
 *
 * @package WpResidence
 * @subpackage PropertyCard
 * @since WpResidence 1.0
 */
?>
<div class="property_listing_details">
    <?php
    // Retrieve property details
    // The wpestate_get_converted_measure function is typically defined in measurement_functions.php
    // It converts and formats the property size according to the chosen unit system (e.g., sq ft, sq m)
    $property_size = wpestate_get_converted_measure($postID, 'property_size');

    // Retrieve number of bedrooms, bathrooms, and garage spaces
    // These are custom fields added to the property post type
    $property_bedrooms = get_post_meta($postID, 'property_bedrooms', true);
    $property_bathrooms = get_post_meta($postID, 'property_bathrooms', true);
    $garage_no = get_post_meta($postID, 'property-garage', true);

    // Display number of bedrooms if available
    if ($property_bedrooms != '' && $property_bedrooms != 0) {
        echo ' <span class="inforoom_unit_type2">' . esc_html($property_bedrooms) . '</span>';
    }

    // Display number of bathrooms if available
    if ($property_bathrooms != '' && $property_bathrooms != 0) {
        echo '<span class="infobath_unit_type2">' . esc_html($property_bathrooms) . '</span>';
    }

    // Display number of garage spaces if available
    if ($garage_no != '' && $garage_no != 0) {
        echo ' <span class="infogarage_unit_type2">' . esc_html($garage_no) . '</span>';
    }

    // Display property size if available
    // Note: $property_size is not escaped here as it's already processed by wpestate_get_converted_measure
    if ($property_size != '' && $property_size != '0') {
        echo ' <span class="infosize_unit_type2">' . $property_size . '</span>';
    }
    ?>           
</div>