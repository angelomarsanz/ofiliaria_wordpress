<?php
/** MILLDONE
 * Property Card Location Template
 * src: templates\property_cards_templates\property_card_details_templates\property_card_location.php
 * This template is responsible for displaying the location information
 * (city and area) for a property card in the WpResidence theme.
 *
 * @package WpResidence
 * @subpackage PropertyCard
 * @since 1.0
 */

// Retrieve property city and area terms
$property_city = get_the_term_list($postID, 'property_city', '', ', ', '');
$property_area = get_the_term_list($postID, 'property_area', '', ', ', '');

// Check if either city or area exists
if (!empty($property_city) || !empty($property_area)) {
    // Start building the location HTML
    $location_html = '<div class="property_location_image">';
    $location_html .= '<i class="fas fa-map-marker-alt"></i>';
    
    // Add area if it exists
    if (!empty($property_area)) {
        $location_html .= wp_kses_post($property_area);
    }
    
    // Add comma between area and city if both exist
    $location_html .= (!empty($property_area) && !empty($property_city)) ? ', ' : '';
    
    // Add city if it exists
    if (!empty($property_city)) {
        $location_html .= wp_kses_post($property_city);
    }
    
    // Close the location div
    $location_html .= '</div>';
    
    // Output the location HTML
    echo $location_html;
}
?>