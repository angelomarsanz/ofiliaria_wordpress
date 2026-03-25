<?php
/** MILLDONE
 * Template for displaying property address on Type 2 property cards
 * src: templates\property_cards_templates\property_card_details_templates\property_card_adress_type2.php
 * This template is responsible for rendering the property address information,
 * including city, area, and custom address fields on Type 2 property cards.
 */
?>

<div class="property_address_type1_wrapper">
    <?php
    // Retrieve property location information
    $property_city  = get_the_term_list($postID, 'property_city', '', ', ', '');
    $property_area  = get_the_term_list($postID, 'property_area', '', ', ', '');
    $property_address = get_post_meta($postID, 'property_address', true);

    // Display the location icon
    echo '<i class="fas fa-map-marker-alt"></i>';

    // Display property address if available
    if (!empty($property_address)) {
        echo '<span class="property_address_type1">' . esc_html($property_address) . ', </span>';
    }

    // Display property area if available
    if (!empty($property_area)) {
        echo '<span class="property_area_type1">' . wp_kses_post($property_area) . ', </span>';
    }

    // Display property city if available
    if (!empty($property_city)) {
        echo '<span class="property_city_type1">' . wp_kses_post($property_city) . '</span>';
    }
    ?>
</div>