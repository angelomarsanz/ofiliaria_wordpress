<?php
/**
 * Template for displaying property details in a type 7 card layout
 *
 * This template is part of the WpResidence theme and is used to show
 * key property features such as bedrooms, bathrooms, property size,
 * garage size, and lot size in a compact format with icons.
 *
 * @package WpResidence
 * @subpackage PropertyCard
 * @since WpResidence 1.0
 */

$link = esc_url(get_permalink());

// Retrieve and process property details
$property_bedrooms = get_post_meta($postID, 'property_bedrooms', true);
$property_bedrooms = $property_bedrooms !== '' ? floatval($property_bedrooms) : '';

$property_bathrooms = get_post_meta($postID, 'property_bathrooms', true);
$property_bathrooms = $property_bathrooms !== '' ? floatval($property_bathrooms) : '';

$property_size = wpestate_get_converted_measure($postID, 'property_size');
$property_garage_size = get_post_meta($postID, 'property-garage-size', true);
$property_lot_size = wpestate_get_converted_measure($postID, 'property_lot_size');
?>

<div class="property_listing_details">
    <?php 
    $property_features = [
        [
            'value' => $property_bedrooms,
            'title' => esc_attr__('Bedrooms', 'wpresidence'),
            'icon' => 'css/css-images/icons/bedrooms7.svg'
        ],
        [
            'value' => $property_bathrooms,
            'title' => esc_attr__('Bathrooms', 'wpresidence'),
            'icon' => 'css/css-images/icons/bath7.svg'
        ],
        [
            'value' => $property_size,
            'title' => esc_attr__('Property Size', 'wpresidence'),
            'icon' => 'css/css-images/icons/size7.svg'
        ],
        [
            'value' => $property_garage_size,
            'title' => esc_attr__('Garage Size', 'wpresidence'),
            'icon' => 'css/css-images/icons/car7.svg'
        ],
        [
            'value' => $property_lot_size,
            'title' => esc_attr__('Lot Size', 'wpresidence'),
            'icon' => 'css/css-images/icons/lotsize7.svg'
        ]
    ];

    foreach ($property_features as $feature) {
        if ($feature['value'] !== '' && $feature['value'] != 0) {
            echo '<div class="property_listing_details_v7_item" data-bs-toggle="tooltip" title="' . $feature['title'] . '">';
            echo '<div class="icon_label">';
            include(locate_template($feature['icon']));
            echo '</div>';
            echo wp_kses_post($feature['value']);
            echo '</div>';
        }
    }
    ?>
</div>