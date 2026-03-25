<?php
/** MILLDONE
 * Template for displaying property address on Type 3 property cards
 * src:templates\property_cards_templates\property_card_details_templates\property_card_adress_type3.php
 * This template is responsible for rendering the property address information,
 * including city and address fields on Type 3 property cards.
 */

$property_city      =   get_the_term_list($postID, 'property_city', '', ', ', ''); 
$property_address   =   get_post_meta($postID,'property_address',true);
?> 
<div class="property_card_categories_wrapper">
    <?php
        // Check and print property address if it exists
        if (!empty($property_address)) {
            print esc_html($property_address);
        }

        // Only print the city if it exists
        if (!empty($property_city)) {
            print ', ' . wp_kses_post($property_city);
        }
    ?>
</div>
