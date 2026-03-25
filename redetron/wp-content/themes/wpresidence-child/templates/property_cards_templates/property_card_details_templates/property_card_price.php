<?php
/** MILLDONE
 * Property Card Price Template
 * src: templates\property_cards_templates\property_card_details_templates\property_card_price.php
 * This template is responsible for displaying the price of a property
 * on property cards in the WpResidence theme.
 *
 * @package WpResidence
 * @subpackage PropertyCard
 * @since 1.0
 */

/**
 * Retrieve currency symbol and position
 */
$currency_symbol = wpresidence_get_option('wp_estate_currency_symbol', '');
$currency_position = wpresidence_get_option('wp_estate_where_currency_symbol', '');

// Obtener campo personalizado "divisa" del post meta
$divisa = get_post_meta($postID, 'divisa', true);
?>

<div class="listing_unit_price_wrapper">
    <?php
    // Mostrar campo personalizado divisa si está disponible
    if ($divisa) {
        echo '<span class="property-currency">' . esc_html($divisa) . '</span> ';
    }

    // Mostrar precio con formato nuevo
    wpestate_show_price($postID, $currency_symbol, $currency_position);
    ?>
</div>
