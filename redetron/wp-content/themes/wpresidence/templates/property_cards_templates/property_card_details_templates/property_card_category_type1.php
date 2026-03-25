<?php
/** MILLDONE
 * Template for displaying property category and action on Type 1 property cards
 * src: templates\property_cards_templates\property_card_details_templates\property_card_category_type1.php
 * This template is responsible for rendering the property category and action information
 * on Type 1 property cards. It displays the property's category followed by the action category.
 */
?>
<div class="property_categories_type1_wrapper">
    <?php
    // Retrieve property category and action information
    $property_category = get_the_term_list($postID, 'property_category', '', ', ', '');
    $property_action   = get_the_term_list($postID, 'property_action_category', '', ', ', '');

    // Display property category and action if available
    if (!empty($property_category) || !empty($property_action)) {
        if (!empty($property_category)) {
            echo wp_kses_post($property_category);
            
            if (!empty($property_action)) {
                echo ' ' . esc_html__('in', 'wpresidence') . ' ';
            }
        }
        
        if (!empty($property_action)) {
            echo wp_kses_post($property_action);
        }
    } else {
        echo '&nbsp;'; // Output a non-breaking space if no category or action is available
    }
    ?>
</div>