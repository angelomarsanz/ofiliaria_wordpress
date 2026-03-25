<?php
/** MILLDONE
 * Template for displaying Property Card Price (Type 3)
 * src: templates\property_cards_templates\property_card_details_templates\property_card_price_type3.php
 * This file is part of the WpResidence theme and is used to render
 * the price section of a property card for Type 3 layout.
 */

// Set up necessary variables
$wpestate_currency = esc_html(wpresidence_get_option('wp_estate_currency_symbol', ''));
$where_currency = esc_html(wpresidence_get_option('wp_estate_where_currency_symbol', ''));
$link = get_permalink();

// Determine the target attribute for the link
$target = (wpresidence_get_option('wp_estate_unit_card_new_page', '') == '_self') ? '' : ' target="' . esc_attr(wpresidence_get_option('wp_estate_unit_card_new_page', '')) . '"';
// Obtener campo personalizado "divisa" del post meta
$divisa = get_post_meta($postID, 'divisa', true);
?>

<div class="listing_unit_price_wrapper">
    <a href="<?php echo esc_url($link); ?>"<?php echo $target; ?>>
        <?php
        /**
         aca se defina el formato de precio, simbolo de moneda y posicion.
         */
        <?php
    // Mostrar campo personalizado divisa si está disponible
    if ($divisa) {
        echo '<span class="property-currency">' . esc_html($divisa) . '</span> ';
    }
        wpestate_show_price($postID, $wpestate_currency, $where_currency);
        ?>
    </a>
</div>