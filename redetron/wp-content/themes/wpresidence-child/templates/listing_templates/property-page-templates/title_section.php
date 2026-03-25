<?php
/** MILLDONE
 * WpResidence Property Price Display
 * src: templates\listing_templates\property-page-templates\price_display.php
 */

// Obtener campo divisa
$custom_currency = get_post_meta($selectedPropertyID, 'divisa', true);

// Fetch primary price details
$price_details = array(
    'price' => floatval(get_post_meta($selectedPropertyID, 'property_price', true)),
    'label' => esc_html(get_post_meta($selectedPropertyID, 'property_label', true)),
    'label_before' => esc_html(get_post_meta($selectedPropertyID, 'property_label_before', true))
);

// Fetch secondary price details
$second_price_details = array(
    'price' => floatval(get_post_meta($selectedPropertyID, 'property_second_price', true)),
    'label' => esc_html(get_post_meta($selectedPropertyID, 'property_second_price_label', true)),
    'label_before' => esc_html(get_post_meta($selectedPropertyID, 'property_label_before_second_price', true))
);

// Formatear divisa si existe
$divisa_output = $custom_currency ? '<span class="custom-currency">' . esc_html($custom_currency) . ' </span>' : '';

// Format primary price
$price = ($price_details['price'] != 0) 
    ? $divisa_output . wpestate_show_price($selectedPropertyID, $wpestate_currency, $where_currency, 1)
    : sprintf(
        '<span class="price_label price_label_before">%s</span><span class="price_label">%s</span>',
        $price_details['label_before'],
        $price_details['label']
    );

// Format secondary price
$property_second_price = ($second_price_details['price'] != 0)
    ? $divisa_output . wpestate_show_price($selectedPropertyID, $wpestate_currency, $where_currency, 1, "yes")
    : sprintf(
        '<span class="price_label price_label_before">%s</span><span class="price_label">%s</span>',
        $second_price_details['label_before'],
        $second_price_details['label']
    );
?>

<div class="single_property_labels">
    <div class="property_title_label"><?php echo wp_kses_post($property_action); ?></div>
    <div class="property_title_label actioncat"><?php echo wp_kses_post($property_category); ?></div>
</div>

<h1 class="entry-title entry-prop"><?php echo get_the_title($selectedPropertyID); ?></h1>

<div class="price_area">
    <div class="second_price_area"><?php echo wp_kses_post($property_second_price); ?></div>    
    <?php echo wp_kses_post($price); ?>
</div>
