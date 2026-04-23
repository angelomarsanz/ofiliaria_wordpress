<?php
/** MILLDONE
 * WpResidence Theme - Property Submission Form
 * src: templates/submit_templates/property_details.php
 * This code handles the rendering of custom fields and property details
 * in the property submission form.
 *
 * @package WpResidence
 * @subpackage PropertySubmission
 * @since 1.0.0
 */

$show_settings_value = 1;
$measure_sys = wpestate_get_meaurement_unit_formated($show_settings_value);
$measure_sys_lot_size = wpestate_get_meaurement_unit_formated_lot_size($show_settings_value);

$custom_fields_show = '';
$custom_fields = wpresidence_get_option('wp_estate_custom_fields', '');
$i = 0;

// Process custom fields
if (!empty($custom_fields)) {
    while ($i < count($custom_fields)) {
        $name = $custom_fields[$i][0];
        $type = $custom_fields[$i][1];
        $slug = wpestate_limit45(sanitize_title($name));
        $slug = sanitize_key($slug);
        if (isset($_POST[$slug])) {
            $custom_fields_array[$slug] = wp_kses(esc_html($_POST[$slug]), $allowed_html);
        }
        $i++;
    }
}

// Generar campos personalizados, excluyendo "divisa"
$i = 0;
if (!empty($custom_fields)):
    while ($i < count($custom_fields)) {
        $name = $custom_fields[$i][0];
        $slug = sanitize_key(wpestate_limit45(sanitize_title($name)));

        // Omitir el campo "divisa"
        if ($slug === 'divisa') {
            $i++;
            continue;
        }

        $label = stripslashes($custom_fields[$i][1]);
        $type = $custom_fields[$i][2];
        $order = $custom_fields[$i][3];
        $dropdown_values = $custom_fields[$i][4];
        $prslig = str_replace(' ', '_', $name);
        $prslig1 = htmlspecialchars(str_replace(' ', '_', trim($name)), ENT_QUOTES);
        $post_id = isset($get_listing_edit) && is_numeric($get_listing_edit) ? intval($get_listing_edit) : $post->ID;
        $value = isset($custom_fields_array[$slug]) ? $custom_fields_array[$slug] : '';

        // Traducir etiqueta si WPML está activo
        if (function_exists('icl_translate')) {
            $label = icl_translate('wpestate', 'wp_estate_property_custom_front_' . $label, $label);
        }

        // Solo agregar si está en los campos permitidos
        if (is_array($wpestate_submission_page_fields) && (in_array($prslig, $wpestate_submission_page_fields) || in_array($prslig1, $wpestate_submission_page_fields))) 
        {
            // Inicio cambios Ofiliaria
            if (substr($slug, 0, 10) == '_ofiliaria')
            {
                $custom_fields_show .= '<div id="div'.$slug.'" class="col-md-6 ofiliaria_detalle_anuncio" >';    
            }
            else
            {
                $custom_fields_show .= '<div id="div_'.$slug.'" class="col-md-6">';
            }
            // Fin cambios Ofiliaria
            $custom_fields_show .= wpestate_show_custom_field(0, $slug, $name, $label, $type, $order, $dropdown_values, $post_id, $value);
            $custom_fields_show .= '</div>';
        }
        
        $i++;
    }
endif;

// Check if property details section should be displayed
$show_property_details = is_array($wpestate_submission_page_fields) && (
    in_array('property_size', $wpestate_submission_page_fields) ||
    in_array('property_lot_size', $wpestate_submission_page_fields) ||
    in_array('property_rooms', $wpestate_submission_page_fields) ||
    in_array('property_bedrooms', $wpestate_submission_page_fields) ||
    in_array('property_bathrooms', $wpestate_submission_page_fields) ||
    in_array('owner_notes', $wpestate_submission_page_fields) ||
    $custom_fields_show != ''
);

if ($show_property_details) : ?>

<style>
    /* Estilo para el contenedor de los radio buttons */
    .radio-buttons-container {
        /* Se añade un margen vertical para separar cada grupo de opciones */
        margin-bottom: 1rem;
    }

    /* Estilo para las etiquetas de las opciones */
    .radio-buttons-container label {
        /* Se mantiene la separación horizontal entre las opciones "Sí" y "No" */
        margin-right: 3rem;
    }

    /* Se añade un margen izquierdo específico a la primera opción ("Sí") */
    .radio-buttons-container label:first-of-type {
        margin-left: 2rem;
    }
</style>

<div class="profile-onprofile row">
    <div class="wpestate_dashboard_section_title"><?php esc_html_e('Listing Details', 'wpresidence'); ?></div>

    <?php
    // Display property size field
    if (is_array($wpestate_submission_page_fields) && in_array('property_size', $wpestate_submission_page_fields)) : ?>
        <div id="div_property_size" class="col-md-6">
            <label for="property_size"><?php echo esc_html__('Size in', 'wpresidence') . ' ' . wp_kses_post($measure_sys) . ' ' . esc_html__(' (*only numbers)', 'wpresidence'); ?></label>
            <input type="number" step="any" id="property_size" size="40" class="form-control" name="property_size"
                value="<?php echo esc_attr(stripslashes(wpestate_submit_return_value('property_size', $get_listing_edit, 'numeric'))); ?>">
        </div>
    <?php endif; ?>

    <?php
    // Display property lot size field
    if (is_array($wpestate_submission_page_fields) && in_array('property_lot_size', $wpestate_submission_page_fields)) : ?>
        <div id="div_property_lot_size" class="col-md-6">
            <label for="property_lot_size"><?php echo esc_html__('Lot Size in', 'wpresidence') . ' ' . wp_kses_post($measure_sys_lot_size) . ' ' . esc_html__(' (*only numbers)', 'wpresidence'); ?></label>
            <input type="number" step="any" id="property_lot_size" size="40" class="form-control" name="property_lot_size"
                value="<?php echo esc_attr(stripslashes(wpestate_submit_return_value('property_lot_size', $get_listing_edit, 'numeric'))); ?>">
        </div>
    <?php endif; ?>

    <?php
    // Display property rooms field
    if (is_array($wpestate_submission_page_fields) && in_array('property_rooms', $wpestate_submission_page_fields)) : ?>
        <div id="div_property_rooms" class="col-md-6">
            <label for="property_rooms"><?php esc_html_e('Rooms (*only numbers)', 'wpresidence'); ?></label>
            <input type="number" step="any" id="property_rooms" size="40" class="form-control" name="property_rooms"
                value="<?php echo esc_attr(stripslashes(wpestate_submit_return_value('property_rooms', $get_listing_edit, 'numeric'))); ?>">
        </div>
    <?php endif; ?>

    <?php
    // Display property bedrooms field
    if (is_array($wpestate_submission_page_fields) && in_array('property_bedrooms', $wpestate_submission_page_fields)) : ?>
        <div id="div_property_bedrooms" class="col-md-6">
            <label for="property_bedrooms"><?php esc_html_e('Dormitorios (*cero para monoambiente, solo números)', 'wpresidence'); ?></label>
            <input type="number" step="any" id="property_bedrooms" size="40" class="form-control" name="property_bedrooms"
                value="<?php echo esc_attr(stripslashes(wpestate_submit_return_value('property_bedrooms', $get_listing_edit, 'numeric'))); ?>">
        </div>
    <?php endif; ?>

    <?php
    // Display property bathrooms field
    if (is_array($wpestate_submission_page_fields) && in_array('property_bathrooms', $wpestate_submission_page_fields)) : ?>
        <div id="div_property_bathrooms" class="col-md-6">
            <label for="property_bathrooms"><?php esc_html_e('Bathrooms (*only numbers)', 'wpresidence'); ?></label>
            <input type="number" step="any" id="property_bathrooms" size="40" class="form-control" name="property_bathrooms"
                value="<?php echo esc_attr(stripslashes(wpestate_submit_return_value('property_bathrooms', $get_listing_edit, 'numeric'))); ?>">
        </div>
    <?php endif; ?>

    <!-- Inicio cambios Ofiliaria -->

    <!-- Campos principales -->

    <?php
    $_ofiliaria_banio_social = get_post_meta($get_listing_edit, '_ofiliaria_banio_social', true);
    ?>

    <div id="div_ofiliaria_banio_social" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Baño social', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_banio_social_si" name="_ofiliaria_banio_social" value="Sí"
                    <?php echo ($_ofiliaria_banio_social === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_banio_social_no" name="_ofiliaria_banio_social" value="No"
                    <?php echo ($_ofiliaria_banio_social === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_dormitorio_de_servicio = get_post_meta($get_listing_edit, '_ofiliaria_dormitorio_de_servicio', true);
    ?>

    <div id="div_ofiliaria_dormitorio_de_servicio" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Dormitorio de servicio', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_dormitorio_de_servicio_si" name="_ofiliaria_dormitorio_de_servicio" value="Sí"
                    <?php echo ($_ofiliaria_dormitorio_de_servicio === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_dormitorio_de_servicio_no" name="_ofiliaria_dormitorio_de_servicio" value="No"
                    <?php echo ($_ofiliaria_dormitorio_de_servicio === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_m2_terraza_propiedad = get_post_meta($get_listing_edit, '_ofiliaria_m2_terraza_propiedad', true);
    ?>

    <div id="div_ofiliaria_m2_terraza_propiedad" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_m2_terraza_propiedad">Metros cuadrados de la terraza de la propiedad(solo números)</label>
        <input type="number" step="any" id="_ofiliaria_m2_terraza_propiedad" class="form-control" name="_ofiliaria_m2_terraza_propiedad" value="<?php echo $_ofiliaria_m2_terraza_propiedad; ?>">

    </div>

    <?php
    $_ofiliaria_superficie_de_balcon = get_post_meta($get_listing_edit, '_ofiliaria_superficie_de_balcon', true);
    ?>

    <div id="div_ofiliaria_superficie_de_balcon" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_superficie_de_balcon">Superficie de balcón (m2, solo números)</label>
        <input type="number" step="any" id="_ofiliaria_superficie_de_balcon" class="form-control" name="_ofiliaria_superficie_de_balcon" value="<?php echo $_ofiliaria_superficie_de_balcon; ?>">

    </div>

    <?php
    $_ofiliaria_ambientes = get_post_meta($get_listing_edit, '_ofiliaria_ambientes', true);
    ?>

    <div id="div_ofiliaria_ambientes" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_ambientes">Ambientes (solo números)</label>
        <input type="number" step="any" id="_ofiliaria_ambientes" class="form-control" name="_ofiliaria_ambientes" value="<?php echo $_ofiliaria_ambientes; ?>">

    </div>

    <?php
    $_ofiliaria_parrillero = get_post_meta($get_listing_edit, '_ofiliaria_parrillero', true);
    ?>

    <div id="div_ofiliaria_parrillero" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Parrillero', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_parrillero_si" name="_ofiliaria_parrillero" value="Sí"
                    <?php echo ($_ofiliaria_parrillero === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_parrillero_no" name="_ofiliaria_parrillero" value="No"
                    <?php echo ($_ofiliaria_parrillero === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_piscina = get_post_meta($get_listing_edit, '_ofiliaria_piscina', true);
    ?>

    <div id="div_ofiliaria_piscina" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Piscina', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_piscina_si" name="_ofiliaria_piscina" value="Sí"
                    <?php echo ($_ofiliaria_piscina === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_piscina_no" name="_ofiliaria_piscina" value="No"
                    <?php echo ($_ofiliaria_piscina === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_terraza = get_post_meta($get_listing_edit, '_ofiliaria_terraza', true);
    ?>

    <div id="div_ofiliaria_terraza" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Terraza', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_terraza_si" name="_ofiliaria_terraza" value="Sí"
                    <?php echo ($_ofiliaria_terraza === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_terraza_no" name="_ofiliaria_terraza" value="No"
                    <?php echo ($_ofiliaria_terraza === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_bodegas = get_post_meta($get_listing_edit, '_ofiliaria_bodegas', true);
    ?>

    <div id="div_ofiliaria_bodegas" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_bodegas">Bodegas (solo números)</label>
        <input type="number" step="any" id="_ofiliaria_bodegas" class="form-control" name="_ofiliaria_bodegas" value="<?php echo $_ofiliaria_bodegas; ?>">

    </div>

    <?php
    $estacionamiento = get_post_meta($get_listing_edit, 'estacionamiento', true);
    ?>

    <div id="div_estacionamiento" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="estacionamiento">Cocheras (solo números)</label>
        <input type="number" step="any" id="estacionamiento" class="form-control" name="estacionamiento" value="<?php echo $estacionamiento; ?>">

    </div>

    <?php
    $_ofiliaria_camas = get_post_meta($get_listing_edit, '_ofiliaria_camas', true);
    ?>

    <div id="div_ofiliaria_camas" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_camas">Camas o colchón (solo números)</label>
        <input type="number" step="any" id="_ofiliaria_camas" class="form-control" name="_ofiliaria_camas" value="<?php echo $_ofiliaria_camas; ?>">

    </div>

    <?php
    $_ofiliaria_amoblado = get_post_meta($get_listing_edit, '_ofiliaria_amoblado', true);
    ?>

    <div id="div_ofiliaria_amoblado" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Amoblado', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_amoblado_si" name="_ofiliaria_amoblado" value="Sí"
                    <?php echo ($_ofiliaria_amoblado === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_amoblado_no" name="_ofiliaria_amoblado" value="No"
                    <?php echo ($_ofiliaria_amoblado === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_huespedes = get_post_meta($get_listing_edit, '_ofiliaria_huespedes', true);
    ?>

    <div id="div_ofiliaria_huespedes" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_huespedes">Huéspedes (solo números)</label>
        <input type="number" step="any" id="_ofiliaria_huespedes" class="form-control" name="_ofiliaria_huespedes" value="<?php echo $_ofiliaria_huespedes; ?>">

    </div>

    <?php
    $_ofiliaria_admite_mascotas = get_post_meta($get_listing_edit, '_ofiliaria_admite_mascotas', true);
    ?>

    <div id="div_ofiliaria_admite_mascotas" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Admite mascotas', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_admite_mascotas_si" name="_ofiliaria_admite_mascotas" value="Sí"
                    <?php echo ($_ofiliaria_admite_mascotas === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_admite_mascotas_no" name="_ofiliaria_admite_mascotas" value="No"
                    <?php echo ($_ofiliaria_admite_mascotas === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_uso_comercial = get_post_meta($get_listing_edit, '_ofiliaria_uso_comercial', true);
    ?>

    <div id="div_ofiliaria_uso_comercial" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Uso comercial', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_uso_comercial_si" name="_ofiliaria_uso_comercial" value="Sí"
                    <?php echo ($_ofiliaria_uso_comercial === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_uso_comercial_no" name="_ofiliaria_uso_comercial" value="No"
                    <?php echo ($_ofiliaria_uso_comercial === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_tipo_de_departamento = get_post_meta($get_listing_edit, '_ofiliaria_tipo_de_departamento', true);
    ?>

    <div id="div_ofiliaria_tipo_de_departamento" class="col-md-6 ofiliaria_detalle_anuncio" style="">
        <label for="_ofiliaria_tipo_de_departamento">Tipo de departamento</label>
        <select id="_ofiliaria_tipo_de_departamento" name="_ofiliaria_tipo_de_departamento">
            <option value="No disponible" <?php selected($_ofiliaria_tipo_de_departamento, 'No disponible'); ?>>No disponible</option>
            <option value="Monoambiente" <?php selected($_ofiliaria_tipo_de_departamento, 'Monoambiente'); ?>>Monoambiente</option>
            <option value="Loft" <?php selected($_ofiliaria_tipo_de_departamento, 'Loft'); ?>>Loft</option>
            <option value="Departamento" <?php selected($_ofiliaria_tipo_de_departamento, 'Departamento'); ?>>Departamento</option>
            <option value="Dúplex" <?php selected($_ofiliaria_tipo_de_departamento, 'Dúplex'); ?>>Dúplex</option>
            <option value="Tríplex" <?php selected($_ofiliaria_tipo_de_departamento, 'Tríplex'); ?>>Tríplex</option>
            <option value="Semi piso" <?php selected($_ofiliaria_tipo_de_departamento, 'Semi piso'); ?>>Semi piso</option>
            <option value="Piso" <?php selected($_ofiliaria_tipo_de_departamento, 'Piso'); ?>>Piso</option>
            <option value="Ph" <?php selected($_ofiliaria_tipo_de_departamento, 'Ph'); ?>>Ph</option>
            <option value="Penthhouse" <?php selected($_ofiliaria_tipo_de_departamento, 'Penthhouse'); ?>>Penthhouse</option>
        </select>
    </div>

    <?php
    $_ofiliaria_cantidad_plantas_propiedad = get_post_meta($get_listing_edit, '_ofiliaria_cantidad_plantas_propiedad', true);
    ?>

    <div id="div_ofiliaria_cantidad_plantas_propiedad" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_cantidad_plantas_propiedad">Cantidad de plantas de la propiedad (solo números)</label>
        <input type="number" step="any" id="_ofiliaria_cantidad_plantas_propiedad" class="form-control" name="_ofiliaria_cantidad_plantas_propiedad" value="<?php echo $_ofiliaria_cantidad_plantas_propiedad; ?>">

    </div>

    <?php
    $_ofiliaria_tipo_de_casa = get_post_meta($get_listing_edit, '_ofiliaria_tipo_de_casa', true);
    ?>

    <div id="div_ofiliaria_tipo_de_casa" class="col-md-6 ofiliaria_detalle_anuncio" style="">
        <label for="_ofiliaria_tipo_de_casa">Tipo de casa</label>
        <select id="_ofiliaria_tipo_de_casa" name="_ofiliaria_tipo_de_casa">
            <option value="No disponible" <?php selected($_ofiliaria_tipo_de_casa, 'No disponible'); ?>>No disponible</option>
            <option value="Cabaña" <?php selected($_ofiliaria_tipo_de_casa, 'Cabaña'); ?>>Cabaña</option>
            <option value="Casa" <?php selected($_ofiliaria_tipo_de_casa, 'Casa'); ?>>Casa</option>
            <option value="Chalet" <?php selected($_ofiliaria_tipo_de_casa, 'Chalet'); ?>>Chalet</option>
            <option value="Dúplex" <?php selected($_ofiliaria_tipo_de_casa, 'Dúplex'); ?>>Dúplex</option>
            <option value="Tríplex" <?php selected($_ofiliaria_tipo_de_casa, 'Tríplex'); ?>>Tríplex</option>
            <option value="Ph" <?php selected($_ofiliaria_tipo_de_casa, 'Ph'); ?>>Ph</option>
        </select>
    </div>

    <?php
    $_ofiliaria_tipo_de_campo = get_post_meta($get_listing_edit, '_ofiliaria_tipo_de_campo', true);
    ?>

    <div id="div_ofiliaria_tipo_de_campo" class="col-md-6 ofiliaria_detalle_anuncio" style="">
        <label for="_ofiliaria_tipo_de_campo">Tipo de campo</label>
        <select id="_ofiliaria_tipo_de_campo" name="_ofiliaria_tipo_de_campo">
            <option value="No disponible" <?php selected($_ofiliaria_tipo_de_campo, 'No disponible'); ?>>No disponible</option>
            <option value="Agrícola" <?php selected($_ofiliaria_tipo_de_campo, 'Agrícola'); ?>>Agrícola</option>
            <option value="Chacra" <?php selected($_ofiliaria_tipo_de_campo, 'Chacra'); ?>>Chacra</option>
            <option value="Criadero" <?php selected($_ofiliaria_tipo_de_campo, 'Criadero'); ?>>Criadero</option>
            <option value="Forestal" <?php selected($_ofiliaria_tipo_de_campo, 'Forestal'); ?>>Forestal</option>
            <option value="Floricultura" <?php selected($_ofiliaria_tipo_de_campo, 'Floricultura'); ?>>Floricultura</option>
            <option value="Frutícola" <?php selected($_ofiliaria_tipo_de_campo, 'Frutícola'); ?>>Frutícola</option>
            <option value="Ganadero" <?php selected($_ofiliaria_tipo_de_campo, 'Ganadero'); ?>>Ganadero</option>
            <option value="Haras" <?php selected($_ofiliaria_tipo_de_campo, 'Haras'); ?>>Haras</option>
            <option value="Tambero" <?php selected($_ofiliaria_tipo_de_campo, 'Tambero'); ?>>Tambero</option>
            <option value="Otro" <?php selected($_ofiliaria_tipo_de_campo, 'Otro'); ?>>Otro</option>
        </select>
    </div>

    <?php
    $_ofiliaria_cantidad_de_pisos = get_post_meta($get_listing_edit, '_ofiliaria_cantidad_de_pisos', true);
    ?>

    <div id="div_ofiliaria_cantidad_de_pisos" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_cantidad_de_pisos">Cantidad de pisos (solo números)</label>
        <input type="number" step="any" id="_ofiliaria_cantidad_de_pisos" class="form-control" name="_ofiliaria_cantidad_de_pisos" value="<?php echo $_ofiliaria_cantidad_de_pisos; ?>">

    </div>

    <?php
    $_ofiliaria_numero_de_piso_de_la_unidad = get_post_meta($get_listing_edit, '_ofiliaria_numero_de_piso_de_la_unidad', true);
    ?>

    <div id="div_ofiliaria_numero_de_piso_de_la_unidad" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_numero_de_piso_de_la_unidad">Número de piso de la unidad (solo números)</label>
        <input type="number" step="any" id="_ofiliaria_numero_de_piso_de_la_unidad" class="form-control" name="_ofiliaria_numero_de_piso_de_la_unidad" value="<?php echo $_ofiliaria_numero_de_piso_de_la_unidad; ?>">

    </div>

    <?php
    $_ofiliaria_apartamentos_por_piso = get_post_meta($get_listing_edit, '_ofiliaria_apartamentos_por_piso', true);
    ?>

    <div id="div_ofiliaria_apartamentos_por_piso" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_apartamentos_por_piso">Apartamentos por piso (solo números)</label>
        <input type="number" step="any" id="_ofiliaria_apartamentos_por_piso" class="form-control" name="_ofiliaria_apartamentos_por_piso" value="<?php echo $_ofiliaria_apartamentos_por_piso; ?>">

    </div>

    <?php
    $_ofiliaria_disposicion = get_post_meta($get_listing_edit, '_ofiliaria_disposicion', true);
    ?>

    <div id="div_ofiliaria_disposicion" class="col-md-6 ofiliaria_detalle_anuncio" style="">
        <label for="_ofiliaria_disposicion">Disposición</label>
        <select id="_ofiliaria_disposicion" name="_ofiliaria_disposicion">
            <option value="No disponible" <?php selected($_ofiliaria_disposicion, 'No disponible'); ?>>No disponible</option>
            <option value="Contrafrente" <?php selected($_ofiliaria_disposicion, 'Contrafrente'); ?>>Contrafrente</option>
            <option value="Frente" <?php selected($_ofiliaria_disposicion, 'Frente'); ?>>Frente</option>
            <option value="Interno" <?php selected($_ofiliaria_disposicion, 'Interno'); ?>>Interno (Interior)</option>
            <option value="Lateral" <?php selected($_ofiliaria_disposicion, 'Lateral'); ?>>Lateral</option>
        </select>
    </div>

    <?php
    $_ofiliaria_orientacion = get_post_meta($get_listing_edit, '_ofiliaria_orientacion', true);
    ?>

    <div id="div_ofiliaria_orientacion" class="col-md-6 ofiliaria_detalle_anuncio" style="">
        <label for="_ofiliaria_orientacion">Orientación</label>
        <select id="_ofiliaria_orientacion" name="_ofiliaria_orientacion">
            <option value="No disponible" <?php selected($_ofiliaria_orientacion, 'No disponible'); ?>>No disponible</option>
            <option value="Norte" <?php selected($_ofiliaria_orientacion, 'Norte'); ?>>Norte</option>
            <option value="Sur" <?php selected($_ofiliaria_orientacion, 'Sur'); ?>>Sur</option>
            <option value="Este" <?php selected($_ofiliaria_orientacion, 'Este'); ?>>Este</option>
            <option value="Oeste" <?php selected($_ofiliaria_orientacion, 'Oeste'); ?>>Oeste</option>
        </select>
    </div>

    <?php
    $_ofiliaria_superficie_cubierta_del_casco = get_post_meta($get_listing_edit, '_ofiliaria_superficie_cubierta_del_casco', true);
    ?>

    <div id="div_ofiliaria_superficie_cubierta_del_casco" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_superficie_cubierta_del_casco">Superficie cubierta del casco (m2, solo números)</label>
        <input type="number" step="any" id="_ofiliaria_superficie_cubierta_del_casco" class="form-control" name="_ofiliaria_superficie_cubierta_del_casco" value="<?php echo $_ofiliaria_superficie_cubierta_del_casco; ?>">

    </div>

    <?php
    $_ofiliaria_superficie_de_terreno = get_post_meta($get_listing_edit, '_ofiliaria_superficie_de_terreno', true);
    ?>

    <div id="div_ofiliaria_superficie_de_terreno" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_superficie_de_terreno">Superficie de terreno (m2, solo números)</label>
        <input type="number" step="any" id="_ofiliaria_superficie_de_terreno" class="form-control" name="_ofiliaria_superficie_de_terreno" value="<?php echo $_ofiliaria_superficie_de_terreno; ?>">

    </div>

    <?php
    $_ofiliaria_forma_del_terreno = get_post_meta($get_listing_edit, '_ofiliaria_forma_del_terreno', true);
    ?>

    <div id="div_ofiliaria_forma_del_terreno" class="col-md-6 ofiliaria_detalle_anuncio" style="">
        <label for="_ofiliaria_forma_del_terreno">Forma del terreno</label>
        <select id="_ofiliaria_forma_del_terreno" name="_ofiliaria_forma_del_terreno">
            <option value="No disponible" <?php selected($_ofiliaria_forma_del_terreno, 'No disponible'); ?>>No disponible</option>
            <option value="Regular" <?php selected($_ofiliaria_forma_del_terreno, 'Regular'); ?>>Regular</option>
            <option value="Irregular" <?php selected($_ofiliaria_forma_del_terreno, 'Irregular'); ?>>Irregular</option>
            <option value="Plano" <?php selected($_ofiliaria_forma_del_terreno, 'Plano'); ?>>Plano</option>
        </select>
    </div>

    <?php
    $_ofiliaria_acceso_lote_terreno = get_post_meta($get_listing_edit, '_ofiliaria_acceso_lote_terreno', true);
    ?>

    <div id="div_ofiliaria_acceso_lote_terreno" class="col-md-6 ofiliaria_detalle_anuncio" style="">
        <label for="_ofiliaria_acceso_lote_terreno">Acceso</label>
        <select id="_ofiliaria_acceso_lote_terreno" name="_ofiliaria_acceso_lote_terreno">
            <option value="No disponible" <?php selected($_ofiliaria_acceso_lote_terreno, 'No disponible'); ?>>No disponible</option>
            <option value="Tierra" <?php selected($_ofiliaria_acceso_lote_terreno, 'Tierra'); ?>>Tierra</option>
            <option value="Arena" <?php selected($_ofiliaria_acceso_lote_terreno, 'Arena'); ?>>Arena</option>
            <option value="Ripio" <?php selected($_ofiliaria_acceso_lote_terreno, 'Ripio'); ?>>Ripio</option>
            <option value="Asfalto" <?php selected($_ofiliaria_acceso_lote_terreno, 'Asfalto'); ?>>Asfalto</option>
            <option value="Otro" <?php selected($_ofiliaria_acceso_lote_terreno, 'Otro'); ?>>Otro</option>
        </select>
    </div>

    <?php
    $_ofiliaria_distancia_al_asfalto = get_post_meta($get_listing_edit, '_ofiliaria_distancia_al_asfalto', true);
    ?>

    <div id="div_ofiliaria_distancia_al_asfalto" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_distancia_al_asfalto">Distancia al asfalto (km, solo números)</label>
        <input type="number" step="any" id="_ofiliaria_distancia_al_asfalto" class="form-control" name="_ofiliaria_distancia_al_asfalto" value="<?php echo $_ofiliaria_distancia_al_asfalto; ?>">

    </div>

    <?php
    $_ofiliaria_anio_construccion_de_la_propiedad = get_post_meta($get_listing_edit, '_ofiliaria_anio_construccion_de_la_propiedad', true);
    ?>

    <div id="div_ofiliaria_anio_construccion_de_la_propiedad" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_anio_construccion_de_la_propiedad">Año de construcción de la propiedad (Infocasas, solo números)</label>
        <input type="number" step="any" id="_ofiliaria_anio_construccion_de_la_propiedad" class="form-control" name="_ofiliaria_anio_construccion_de_la_propiedad" value="<?php echo $_ofiliaria_anio_construccion_de_la_propiedad; ?>">

    </div>

    <?php
    $_ofiliaria_antiguedad = get_post_meta($get_listing_edit, '_ofiliaria_antiguedad', true);
    ?>

    <div id="div_ofiliaria_antiguedad" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_antiguedad">Antigüedad (años, solo números)</label>
        <input type="number" step="any" id="_ofiliaria_antiguedad" class="form-control" name="_ofiliaria_antiguedad" value="<?php echo $_ofiliaria_antiguedad; ?>">

    </div>

    <?php
    $_ofiliaria_numero_del_apartamento = get_post_meta($get_listing_edit, '_ofiliaria_numero_del_apartamento', true);
    ?>

    <div id="div_ofiliaria_numero_del_apartamento" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_numero_del_apartamento">Número del apartamento</label>
        <input type="text" id="_ofiliaria_numero_del_apartamento" class="form-control" name="_ofiliaria_numero_del_apartamento" value="<?php echo $_ofiliaria_numero_del_apartamento; ?>">

    </div>

    <?php
    $_ofiliaria_numero_de_la_casa = get_post_meta($get_listing_edit, '_ofiliaria_numero_de_la_casa', true);
    ?>

    <div id="div_ofiliaria_numero_de_la_casa" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_numero_de_la_casa">Número de la casa</label>
        <input type="text" id="_ofiliaria_numero_de_la_casa" class="form-control" name="_ofiliaria_numero_de_la_casa" value="<?php echo $_ofiliaria_numero_de_la_casa; ?>">

    </div>

    <?php
    $_ofiliaria_codigo_de_la_propiedad = get_post_meta($get_listing_edit, '_ofiliaria_codigo_de_la_propiedad', true);
    ?>

    <div id="div_ofiliaria_codigo_de_la_propiedad" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_codigo_de_la_propiedad">Código de la propiedad</label>
        <input type="text" id="_ofiliaria_codigo_de_la_propiedad" class="form-control" name="_ofiliaria_codigo_de_la_propiedad" value="<?php echo $_ofiliaria_codigo_de_la_propiedad; ?>">

    </div>

    <?php
    $_ofiliaria_horario_de_contacto = get_post_meta($get_listing_edit, '_ofiliaria_horario_de_contacto', true);
    ?>

    <div id="div_ofiliaria_horario_de_contacto" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_horario_de_contacto">Horario de contacto</label>
        <input type="text" id="_ofiliaria_horario_de_contacto" class="form-control" name="_ofiliaria_horario_de_contacto" value="<?php echo $_ofiliaria_horario_de_contacto; ?>">

    </div>

    <?php
    $_ofiliaria_sobre = get_post_meta($get_listing_edit, '_ofiliaria_sobre', true);
    ?>

    <div id="div_ofiliaria_sobre" class="col-md-6 ofiliaria_detalle_anuncio" style="">
        <label for="_ofiliaria_sobre">Sobre (disposición de la propiedad)</label>
        <select id="_ofiliaria_sobre" name="_ofiliaria_sobre">
            <option value="No disponible" <?php selected($_ofiliaria_sobre, 'No disponible'); ?>>No disponible</option>
            <option value="Sobre rambla" <?php selected($_ofiliaria_sobre, 'Sobre rambla'); ?>>Sobre rambla</option>
            <option value="Sobre avenida" <?php selected($_ofiliaria_sobre, 'Sobre avenida'); ?>>Sobre avenida</option>
        </select>
    </div>

    <?php
    $_ofiliaria_vivienda_social = get_post_meta($get_listing_edit, '_ofiliaria_vivienda_social', true);
    ?>

    <div id="div_ofiliaria_vivienda_social" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Vivienda social', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_vivienda_social_si" name="_ofiliaria_vivienda_social" value="Sí"
                    <?php echo ($_ofiliaria_vivienda_social === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_vivienda_social_no" name="_ofiliaria_vivienda_social" value="No"
                    <?php echo ($_ofiliaria_vivienda_social === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_estado = get_post_meta($get_listing_edit, '_ofiliaria_estado', true);
    ?>

    <div id="div_ofiliaria_estado" class="col-md-6 ofiliaria_detalle_anuncio" style="">
        <label for="_ofiliaria_estado">Estado de la propiedad</label>
        <select id="_ofiliaria_estado" name="_ofiliaria_estado">
            <option value="No disponible" <?php selected($_ofiliaria_estado, 'No disponible'); ?>>No disponible</option>
            <option value="A estrenar" <?php selected($_ofiliaria_estado, 'A estrenar'); ?>>A estrenar</option>
            <option value="Reciclada" <?php selected($_ofiliaria_estado, 'Reciclada'); ?>>Reciclada</option>
            <option value="Excelente estado" <?php selected($_ofiliaria_estado, 'Excelente estado'); ?>>Excelente estado</option>
            <option value="Buen estado" <?php selected($_ofiliaria_estado, 'Buen estado'); ?>>Buen estado</option>
            <option value="Requiere mantenimiento" <?php selected($_ofiliaria_estado, 'Requiere mantenimiento'); ?>>Requiere mantenimiento</option>
            <option value="A reciclar" <?php selected($_ofiliaria_estado, 'A reciclar'); ?>>A reciclar</option>
            <option value="A definir" <?php selected($_ofiliaria_estado, 'A definir'); ?>>A definir</option>
            <option value="En construcción" <?php selected($_ofiliaria_estado, 'En construcción'); ?>>En construcción</option>
            <option value="En pozo" <?php selected($_ofiliaria_estado, 'En pozo'); ?>>En pozo</option>
        </select>
    </div>

    <?php
    $_ofiliaria_acepta_permuta = get_post_meta($get_listing_edit, '_ofiliaria_acepta_permuta', true);
    ?>

    <div id="div_ofiliaria_acepta_permuta" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Acepta permuta', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_acepta_permuta_si" name="_ofiliaria_acepta_permuta" value="Sí"
                    <?php echo ($_ofiliaria_acepta_permuta === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_acepta_permuta_no" name="_ofiliaria_acepta_permuta" value="No"
                    <?php echo ($_ofiliaria_acepta_permuta === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_gastos_comunes_propiedad = get_post_meta($get_listing_edit, '_ofiliaria_gastos_comunes_propiedad', true);
    ?>

    <div id="div_ofiliaria_gastos_comunes_propiedad" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_gastos_comunes_propiedad">Gastos comunes de la propiedad (solo números)</label>
        <input type="number" step="any" id="_ofiliaria_gastos_comunes_propiedad" class="form-control" name="_ofiliaria_gastos_comunes_propiedad" value="<?php echo $_ofiliaria_gastos_comunes_propiedad; ?>">

    </div>

    <?php
    $_ofiliaria_moneda_gastos_comunes = get_post_meta($get_listing_edit, '_ofiliaria_moneda_gastos_comunes', true);
    ?>

    <div id="div_ofiliaria_moneda_gastos_comunes" class="col-md-6 ofiliaria_detalle_anuncio" style="">
        <label for="_ofiliaria_moneda_gastos_comunes">Moneda de los gastos comunes</label>
        <select id="_ofiliaria_moneda_gastos_comunes" name="_ofiliaria_moneda_gastos_comunes">
            <option value="No disponible" <?php selected($_ofiliaria_moneda_gastos_comunes, 'No disponible'); ?>>No disponible</option>
            <option value="USD" <?php selected($_ofiliaria_moneda_gastos_comunes, 'USD'); ?>>USD</option>
            <option value="UYU" <?php selected($_ofiliaria_moneda_gastos_comunes, 'UYU'); ?>>UYU</option>
        </select>
    </div>

    <?php
    $_ofiliaria_horario_check_in = get_post_meta($get_listing_edit, '_ofiliaria_horario_check_in', true);
    ?>

    <div id="div_ofiliaria_horario_check_in" class="col-md-6 ofiliaria_detalle_anuncio" style="">
        <label for="_ofiliaria_horario_check_in">Horario check in</label>
        <select id="_ofiliaria_horario_check_in" name="_ofiliaria_horario_check_in">
            <option value="No disponible" <?php selected($_ofiliaria_horario_check_in, 'No disponible'); ?>>No disponible</option>
            <option value="00:00" <?php selected($_ofiliaria_horario_check_in, '00:00'); ?>>00:00</option>
            <option value="01:00" <?php selected($_ofiliaria_horario_check_in, '01:00'); ?>>01:00</option>
            <option value="02:00" <?php selected($_ofiliaria_horario_check_in, '02:00'); ?>>02:00</option>
            <option value="03:00" <?php selected($_ofiliaria_horario_check_in, '03:00'); ?>>03:00</option>
            <option value="04:00" <?php selected($_ofiliaria_horario_check_in, '04:00'); ?>>04:00</option>
            <option value="05:00" <?php selected($_ofiliaria_horario_check_in, '05:00'); ?>>05:00</option>
            <option value="06:00" <?php selected($_ofiliaria_horario_check_in, '06:00'); ?>>06:00</option>
            <option value="07:00" <?php selected($_ofiliaria_horario_check_in, '07:00'); ?>>07:00</option>
            <option value="08:00" <?php selected($_ofiliaria_horario_check_in, '08:00'); ?>>08:00</option>
            <option value="09:00" <?php selected($_ofiliaria_horario_check_in, '09:00'); ?>>09:00</option>
            <option value="10:00" <?php selected($_ofiliaria_horario_check_in, '10:00'); ?>>10:00</option>
            <option value="11:00" <?php selected($_ofiliaria_horario_check_in, '11:00'); ?>>11:00</option>
            <option value="12:00" <?php selected($_ofiliaria_horario_check_in, '12:00'); ?>>12:00</option>
            <option value="13:00" <?php selected($_ofiliaria_horario_check_in, '13:00'); ?>>13:00</option>
            <option value="14:00" <?php selected($_ofiliaria_horario_check_in, '14:00'); ?>>14:00</option>
            <option value="15:00" <?php selected($_ofiliaria_horario_check_in, '15:00'); ?>>15:00</option>
            <option value="16:00" <?php selected($_ofiliaria_horario_check_in, '16:00'); ?>>16:00</option>
            <option value="17:00" <?php selected($_ofiliaria_horario_check_in, '17:00'); ?>>17:00</option>
            <option value="18:00" <?php selected($_ofiliaria_horario_check_in, '18:00'); ?>>18:00</option>
            <option value="19:00" <?php selected($_ofiliaria_horario_check_in, '19:00'); ?>>19:00</option>
            <option value="20:00" <?php selected($_ofiliaria_horario_check_in, '20:00'); ?>>20:00</option>
            <option value="21:00" <?php selected($_ofiliaria_horario_check_in, '21:00'); ?>>21:00</option>
            <option value="22:00" <?php selected($_ofiliaria_horario_check_in, '22:00'); ?>>22:00</option>
            <option value="23:00" <?php selected($_ofiliaria_horario_check_in, '23:00'); ?>>23:00</option>                                             
        </select>
    </div>

    <?php
    $_ofiliaria_horario_check_out = get_post_meta($get_listing_edit, '_ofiliaria_horario_check_out', true);
    ?>

    <div id="div_ofiliaria_horario_check_out" class="col-md-6 ofiliaria_detalle_anuncio" style="">
        <label for="_ofiliaria_horario_check_out">Horario check out</label>
        <select id="_ofiliaria_horario_check_out" name="_ofiliaria_horario_check_out">
            <option value="No disponible" <?php selected($_ofiliaria_horario_check_out, 'No disponible'); ?>>No disponible</option>
            <option value="00:00" <?php selected($_ofiliaria_horario_check_out, '00:00'); ?>>00:00</option>
            <option value="01:00" <?php selected($_ofiliaria_horario_check_out, '01:00'); ?>>01:00</option>
            <option value="02:00" <?php selected($_ofiliaria_horario_check_out, '02:00'); ?>>02:00</option>
            <option value="03:00" <?php selected($_ofiliaria_horario_check_out, '03:00'); ?>>03:00</option>
            <option value="04:00" <?php selected($_ofiliaria_horario_check_out, '04:00'); ?>>04:00</option>
            <option value="05:00" <?php selected($_ofiliaria_horario_check_out, '05:00'); ?>>05:00</option>
            <option value="06:00" <?php selected($_ofiliaria_horario_check_out, '06:00'); ?>>06:00</option>
            <option value="07:00" <?php selected($_ofiliaria_horario_check_out, '07:00'); ?>>07:00</option>
            <option value="08:00" <?php selected($_ofiliaria_horario_check_out, '08:00'); ?>>08:00</option>
            <option value="09:00" <?php selected($_ofiliaria_horario_check_out, '09:00'); ?>>09:00</option>
            <option value="10:00" <?php selected($_ofiliaria_horario_check_out, '10:00'); ?>>10:00</option>
            <option value="11:00" <?php selected($_ofiliaria_horario_check_out, '11:00'); ?>>11:00</option>
            <option value="12:00" <?php selected($_ofiliaria_horario_check_out, '12:00'); ?>>12:00</option>
            <option value="13:00" <?php selected($_ofiliaria_horario_check_out, '13:00'); ?>>13:00</option>
            <option value="14:00" <?php selected($_ofiliaria_horario_check_out, '14:00'); ?>>14:00</option>
            <option value="15:00" <?php selected($_ofiliaria_horario_check_out, '15:00'); ?>>15:00</option>
            <option value="16:00" <?php selected($_ofiliaria_horario_check_out, '16:00'); ?>>16:00</option>
            <option value="17:00" <?php selected($_ofiliaria_horario_check_out, '17:00'); ?>>17:00</option>
            <option value="18:00" <?php selected($_ofiliaria_horario_check_out, '18:00'); ?>>18:00</option>
            <option value="19:00" <?php selected($_ofiliaria_horario_check_out, '19:00'); ?>>19:00</option>
            <option value="20:00" <?php selected($_ofiliaria_horario_check_out, '20:00'); ?>>20:00</option>
            <option value="21:00" <?php selected($_ofiliaria_horario_check_out, '21:00'); ?>>21:00</option>
            <option value="22:00" <?php selected($_ofiliaria_horario_check_out, '22:00'); ?>>22:00</option>
            <option value="23:00" <?php selected($_ofiliaria_horario_check_out, '23:00'); ?>>23:00</option>                                             
        </select>
    </div>

    <?php
    $_ofiliaria_servicio_de_desayuno = get_post_meta($get_listing_edit, '_ofiliaria_servicio_de_desayuno', true);
    ?>

    <div id="div_ofiliaria_servicio_de_desayuno" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Servicio de desayuno', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_servicio_de_desayuno_si" name="_ofiliaria_servicio_de_desayuno" value="Sí"
                    <?php echo ($_ofiliaria_servicio_de_desayuno === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_servicio_de_desayuno_no" name="_ofiliaria_servicio_de_desayuno" value="No"
                    <?php echo ($_ofiliaria_servicio_de_desayuno === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_servicio_de_limpieza = get_post_meta($get_listing_edit, '_ofiliaria_servicio_de_limpieza', true);
    ?>

    <div id="div_ofiliaria_servicio_de_limpieza" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Servicio de limpieza', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_servicio_de_limpieza_si" name="_ofiliaria_servicio_de_limpieza" value="Sí"
                    <?php echo ($_ofiliaria_servicio_de_limpieza === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_servicio_de_limpieza_no" name="_ofiliaria_servicio_de_limpieza" value="No"
                    <?php echo ($_ofiliaria_servicio_de_limpieza === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_estadia_minima_noches = get_post_meta($get_listing_edit, '_ofiliaria_estadia_minima_noches', true);
    ?>

    <div id="div_ofiliaria_estadia_minima_noches" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_estadia_minima_noches">Estadía mínima (noches) (solo números)</label>
        <input type="number" step="any" id="_ofiliaria_estadia_minima_noches" class="form-control" name="_ofiliaria_estadia_minima_noches" value="<?php echo $_ofiliaria_estadia_minima_noches; ?>">

    </div>

    <?php
    $_ofiliaria_apto_para_oficina = get_post_meta($get_listing_edit, '_ofiliaria_apto_para_oficina', true);
    ?>

    <div id="div_ofiliaria_apto_para_oficina" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Apto para oficina', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_apto_para_oficina_si" name="_ofiliaria_apto_para_oficina" value="Sí"
                    <?php echo ($_ofiliaria_apto_para_oficina === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_apto_para_oficina_no" name="_ofiliaria_apto_para_oficina" value="No"
                    <?php echo ($_ofiliaria_apto_para_oficina === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <!-- Campos secundarios -->

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_numero_de_torre = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_numero_de_torre', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_numero_de_torre" class="col-md-6 ofiliaria_detalle_anuncio">

        <label for="_ofiliaria_adicional_comodidades_equipamiento_numero_de_torre">Número de torre (solo números)</label>
        <input type="number" id="_ofiliaria_adicional_comodidades_equipamiento_numero_de_torre" class="form-control" name="_ofiliaria_adicional_comodidades_equipamiento_numero_de_torre" value="<?php echo $_ofiliaria_adicional_comodidades_equipamiento_numero_de_torre; ?>">

    </div>

    <?php
    $_ofiliaria_adicional_servicios_acceso_a_internet = get_post_meta($get_listing_edit, '_ofiliaria_adicional_servicios_acceso_a_internet', true);
    ?>

    <div id="div_ofiliaria_adicional_servicios_acceso_a_internet" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Acceso a internet', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_acceso_a_internet_si" name="_ofiliaria_adicional_servicios_acceso_a_internet" value="Sí"
                    <?php echo ($_ofiliaria_adicional_servicios_acceso_a_internet === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_acceso_a_internet_no" name="_ofiliaria_adicional_servicios_acceso_a_internet" value="No"
                    <?php echo ($_ofiliaria_adicional_servicios_acceso_a_internet === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_servicios_gas_natural = get_post_meta($get_listing_edit, '_ofiliaria_adicional_servicios_gas_natural', true);
    ?>

    <div id="div_ofiliaria_adicional_servicios_gas_natural" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Gas natural', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_gas_natural_si" name="_ofiliaria_adicional_servicios_gas_natural" value="Sí"
                    <?php echo ($_ofiliaria_adicional_servicios_gas_natural === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_gas_natural_no" name="_ofiliaria_adicional_servicios_gas_natural" value="No"
                    <?php echo ($_ofiliaria_adicional_servicios_gas_natural === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_servicios_linea_telefonica = get_post_meta($get_listing_edit, '_ofiliaria_adicional_servicios_linea_telefonica', true);
    ?>

    <div id="div_ofiliaria_adicional_servicios_linea_telefonica" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Línea telefónica', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_linea_telefonica_si" name="_ofiliaria_adicional_servicios_linea_telefonica" value="Sí"
                    <?php echo ($_ofiliaria_adicional_servicios_linea_telefonica === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_linea_telefonica_no" name="_ofiliaria_adicional_servicios_linea_telefonica" value="No"
                    <?php echo ($_ofiliaria_adicional_servicios_linea_telefonica === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_servicios_tv_por_cable = get_post_meta($get_listing_edit, '_ofiliaria_adicional_servicios_tv_por_cable', true);
    ?>

    <div id="div_ofiliaria_adicional_servicios_tv_por_cable" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('TV por cable', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_tv_por_cable_si" name="_ofiliaria_adicional_servicios_tv_por_cable" value="Sí"
                    <?php echo ($_ofiliaria_adicional_servicios_tv_por_cable === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_tv_por_cable_no" name="_ofiliaria_adicional_servicios_tv_por_cable" value="No"
                    <?php echo ($_ofiliaria_adicional_servicios_tv_por_cable === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_servicios_aire_acondicionado = get_post_meta($get_listing_edit, '_ofiliaria_adicional_servicios_aire_acondicionado', true);
    ?>

    <div id="div_ofiliaria_adicional_servicios_aire_acondicionado" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Aire acondicionado', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_aire_acondicionado_si" name="_ofiliaria_adicional_servicios_aire_acondicionado" value="Sí"
                    <?php echo ($_ofiliaria_adicional_servicios_aire_acondicionado === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_aire_acondicionado_no" name="_ofiliaria_adicional_servicios_aire_acondicionado" value="No"
                    <?php echo ($_ofiliaria_adicional_servicios_aire_acondicionado === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_servicios_calefaccion = get_post_meta($get_listing_edit, '_ofiliaria_adicional_servicios_calefaccion', true);
    ?>

    <div id="div_ofiliaria_adicional_servicios_calefaccion" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Calefacción', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_calefaccion_si" name="_ofiliaria_adicional_servicios_calefaccion" value="Sí"
                    <?php echo ($_ofiliaria_adicional_servicios_calefaccion === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_calefaccion_no" name="_ofiliaria_adicional_servicios_calefaccion" value="No"
                    <?php echo ($_ofiliaria_adicional_servicios_calefaccion === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_servicios_agua_corriente = get_post_meta($get_listing_edit, '_ofiliaria_adicional_servicios_agua_corriente', true);
    ?>

    <div id="div_ofiliaria_adicional_servicios_agua_corriente" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Agua corriente', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_agua_corriente_si" name="_ofiliaria_adicional_servicios_agua_corriente" value="Sí"
                    <?php echo ($_ofiliaria_adicional_servicios_agua_corriente === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_agua_corriente_no" name="_ofiliaria_adicional_servicios_agua_corriente" value="No"
                    <?php echo ($_ofiliaria_adicional_servicios_agua_corriente === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_servicios_caldera_a_gas_electrica = get_post_meta($get_listing_edit, '_ofiliaria_adicional_servicios_caldera_a_gas_electrica', true);
    ?>

    <div id="div_ofiliaria_adicional_servicios_caldera_a_gas_electrica" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Caldera a gas/ eléctrica', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_caldera_a_gas_electrica_si" name="_ofiliaria_adicional_servicios_caldera_a_gas_electrica" value="Sí"
                    <?php echo ($_ofiliaria_adicional_servicios_caldera_a_gas_electrica === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_caldera_a_gas_electrica_no" name="_ofiliaria_adicional_servicios_caldera_a_gas_electrica" value="No"
                    <?php echo ($_ofiliaria_adicional_servicios_caldera_a_gas_electrica === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_servicios_con_energia_solar = get_post_meta($get_listing_edit, '_ofiliaria_adicional_servicios_con_energia_solar', true);
    ?>

    <div id="div_ofiliaria_adicional_servicios_con_energia_solar" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Con energia solar', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_con_energia_solar_si" name="_ofiliaria_adicional_servicios_con_energia_solar" value="Sí"
                    <?php echo ($_ofiliaria_adicional_servicios_con_energia_solar === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_con_energia_solar_no" name="_ofiliaria_adicional_servicios_con_energia_solar" value="No"
                    <?php echo ($_ofiliaria_adicional_servicios_con_energia_solar === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_servicios_con_conexion_para_lavarropas = get_post_meta($get_listing_edit, '_ofiliaria_adicional_servicios_con_conexion_para_lavarropas', true);
    ?>

    <div id="div_ofiliaria_adicional_servicios_con_conexion_para_lavarropas" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Con conexión para lavarropas', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_con_conexion_para_lavarropas_si" name="_ofiliaria_adicional_servicios_con_conexion_para_lavarropas" value="Sí"
                    <?php echo ($_ofiliaria_adicional_servicios_con_conexion_para_lavarropas === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_con_conexion_para_lavarropas_no" name="_ofiliaria_adicional_servicios_con_conexion_para_lavarropas" value="No"
                    <?php echo ($_ofiliaria_adicional_servicios_con_conexion_para_lavarropas === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_servicios_grupo_electrogeno = get_post_meta($get_listing_edit, '_ofiliaria_adicional_servicios_grupo_electrogeno', true);
    ?>

    <div id="div_ofiliaria_adicional_servicios_grupo_electrogeno" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Grupo electrógeno', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_grupo_electrogeno_si" name="_ofiliaria_adicional_servicios_grupo_electrogeno" value="Sí"
                    <?php echo ($_ofiliaria_adicional_servicios_grupo_electrogeno === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_grupo_electrogeno_no" name="_ofiliaria_adicional_servicios_grupo_electrogeno" value="No"
                    <?php echo ($_ofiliaria_adicional_servicios_grupo_electrogeno === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_servicios_con_tv_satelital = get_post_meta($get_listing_edit, '_ofiliaria_adicional_servicios_con_tv_satelital', true);
    ?>

    <div id="div_ofiliaria_adicional_servicios_con_tv_satelital" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Con TV satelital', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_con_tv_satelital_si" name="_ofiliaria_adicional_servicios_con_tv_satelital" value="Sí"
                    <?php echo ($_ofiliaria_adicional_servicios_con_tv_satelital === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_con_tv_satelital_no" name="_ofiliaria_adicional_servicios_con_tv_satelital" value="No"
                    <?php echo ($_ofiliaria_adicional_servicios_con_tv_satelital === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_servicios_jardinero = get_post_meta($get_listing_edit, '_ofiliaria_adicional_servicios_jardinero', true);
    ?>

    <div id="div_ofiliaria_adicional_servicios_jardinero" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Jardinero', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_jardinero_si" name="_ofiliaria_adicional_servicios_jardinero" value="Sí"
                    <?php echo ($_ofiliaria_adicional_servicios_jardinero === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_jardinero_no" name="_ofiliaria_adicional_servicios_jardinero" value="No"
                    <?php echo ($_ofiliaria_adicional_servicios_jardinero === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_servicios_luz_electrica = get_post_meta($get_listing_edit, '_ofiliaria_adicional_servicios_luz_electrica', true);
    ?>

    <div id="div_ofiliaria_adicional_servicios_luz_electrica" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Luz eléctrica', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_luz_electrica_si" name="_ofiliaria_adicional_servicios_luz_electrica" value="Sí"
                    <?php echo ($_ofiliaria_adicional_servicios_luz_electrica === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_luz_electrica_no" name="_ofiliaria_adicional_servicios_luz_electrica" value="No"
                    <?php echo ($_ofiliaria_adicional_servicios_luz_electrica === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_servicios_saneamiento = get_post_meta($get_listing_edit, '_ofiliaria_adicional_servicios_saneamiento', true);
    ?>

    <div id="div_ofiliaria_adicional_servicios_saneamiento" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Saneamiento', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_saneamiento_si" name="_ofiliaria_adicional_servicios_saneamiento" value="Sí"
                    <?php echo ($_ofiliaria_adicional_servicios_saneamiento === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_servicios_saneamiento_no" name="_ofiliaria_adicional_servicios_saneamiento" value="No"
                    <?php echo ($_ofiliaria_adicional_servicios_saneamiento === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_ascensor = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_ascensor', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_ascensor" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Ascensor', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_ascensor_si" name="_ofiliaria_adicional_comodidades_equipamiento_ascensor" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_ascensor === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_ascensor_no" name="_ofiliaria_adicional_comodidades_equipamiento_ascensor" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_ascensor === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Cancha de básquetbol', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol_si" name="_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol_no" name="_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Cancha de paddle', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle_si" name="_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle_no" name="_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Cancha de tenis', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis_si" name="_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis_no" name="_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Con cancha de fútbol', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol_si" name="_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol_no" name="_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Con cancha polideportiva', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva_si" name="_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva_no" name="_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Canchas de usos múltiples', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples_si" name="_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples_no" name="_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>


    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_chimenea = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_chimenea', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_chimenea" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Chimenea', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_chimenea_si" name="_ofiliaria_adicional_comodidades_equipamiento_chimenea" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_chimenea === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_chimenea_no" name="_ofiliaria_adicional_comodidades_equipamiento_chimenea" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_chimenea === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_con_area_verde = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_con_area_verde', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_con_area_verde" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Con área verde', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_con_area_verde_si" name="_ofiliaria_adicional_comodidades_equipamiento_con_area_verde" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_con_area_verde === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_con_area_verde_no" name="_ofiliaria_adicional_comodidades_equipamiento_con_area_verde" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_con_area_verde === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Estacionamiento para visitas', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas_si" name="_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas_no" name="_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_gimnasio = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_gimnasio', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_gimnasio" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Gimnasio', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_gimnasio_si" name="_ofiliaria_adicional_comodidades_equipamiento_gimnasio" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_gimnasio === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_gimnasio_no" name="_ofiliaria_adicional_comodidades_equipamiento_gimnasio" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_gimnasio === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_heladera = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_heladera', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_heladera" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Heladera', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_heladera_si" name="_ofiliaria_adicional_comodidades_equipamiento_heladera" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_heladera === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_heladera_no" name="_ofiliaria_adicional_comodidades_equipamiento_heladera" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_heladera === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_jacuzzi = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_jacuzzi', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_jacuzzi" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Jacuzzi', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_jacuzzi_si" name="_ofiliaria_adicional_comodidades_equipamiento_jacuzzi" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_jacuzzi === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_jacuzzi_no" name="_ofiliaria_adicional_comodidades_equipamiento_jacuzzi" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_jacuzzi === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Salón de fiestas', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas_si" name="_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas_no" name="_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_sauna = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_sauna', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_sauna" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Sauna', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_sauna_si" name="_ofiliaria_adicional_comodidades_equipamiento_sauna" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_sauna === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_sauna_no" name="_ofiliaria_adicional_comodidades_equipamiento_sauna" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_sauna === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_area_de_cine = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_area_de_cine', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_area_de_cine" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Área de cine', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_area_de_cine_si" name="_ofiliaria_adicional_comodidades_equipamiento_area_de_cine" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_area_de_cine === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_area_de_cine_no" name="_ofiliaria_adicional_comodidades_equipamiento_area_de_cine" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_area_de_cine === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Área de juegos infantiles', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles_si" name="_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles_no" name="_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_cisterna = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_cisterna', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_cisterna" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Cisterna', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_cisterna_si" name="_ofiliaria_adicional_comodidades_equipamiento_cisterna" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_cisterna === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_cisterna_no" name="_ofiliaria_adicional_comodidades_equipamiento_cisterna" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_cisterna === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_cowork = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_cowork', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_cowork" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Cowork', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_cowork_si" name="_ofiliaria_adicional_comodidades_equipamiento_cowork" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_cowork === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_cowork_no" name="_ofiliaria_adicional_comodidades_equipamiento_cowork" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_cowork === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Rampa para silla de ruedas', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas_si" name="_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas_no" name="_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_recepcion = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_recepcion', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_recepcion" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Recepción', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_recepcion_si" name="_ofiliaria_adicional_comodidades_equipamiento_recepcion" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_recepcion === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_recepcion_no" name="_ofiliaria_adicional_comodidades_equipamiento_recepcion" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_recepcion === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_bebederos = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_bebederos', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_bebederos" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Bebederos', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_bebederos_si" name="_ofiliaria_adicional_comodidades_equipamiento_bebederos" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_bebederos === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_bebederos_no" name="_ofiliaria_adicional_comodidades_equipamiento_bebederos" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_bebederos === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_casco = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_casco', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_casco" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Casco', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_casco_si" name="_ofiliaria_adicional_comodidades_equipamiento_casco" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_casco === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_casco_no" name="_ofiliaria_adicional_comodidades_equipamiento_casco" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_casco === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_corral = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_corral', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_corral" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Corral', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_corral_si" name="_ofiliaria_adicional_comodidades_equipamiento_corral" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_corral === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_corral_no" name="_ofiliaria_adicional_comodidades_equipamiento_corral" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_corral === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_galpon = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_galpon', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_galpon" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Galpón', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_galpon_si" name="_ofiliaria_adicional_comodidades_equipamiento_galpon" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_galpon === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_galpon_no" name="_ofiliaria_adicional_comodidades_equipamiento_galpon" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_galpon === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_molinos = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_molinos', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_molinos" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Molinos', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_molinos_si" name="_ofiliaria_adicional_comodidades_equipamiento_molinos" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_molinos === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_molinos_no" name="_ofiliaria_adicional_comodidades_equipamiento_molinos" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_molinos === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_silos = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_silos', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_silos" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Silos', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_silos_si" name="_ofiliaria_adicional_comodidades_equipamiento_silos" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_silos === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_silos_no" name="_ofiliaria_adicional_comodidades_equipamiento_silos" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_silos === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Tanque de agua', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua_si" name="_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua_no" name="_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_lavarropa = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_lavarropa', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_lavarropa" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Lavarropa', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_lavarropa_si" name="_ofiliaria_adicional_comodidades_equipamiento_lavarropa" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_lavarropa === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_lavarropa_no" name="_ofiliaria_adicional_comodidades_equipamiento_lavarropa" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_lavarropa === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_microondas = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_microondas', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_microondas" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Microondas', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_microondas_si" name="_ofiliaria_adicional_comodidades_equipamiento_microondas" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_microondas === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_microondas_no" name="_ofiliaria_adicional_comodidades_equipamiento_microondas" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_microondas === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_tv = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_tv', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_tv" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('TV', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_tv_si" name="_ofiliaria_adicional_comodidades_equipamiento_tv" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_tv === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_tv_no" name="_ofiliaria_adicional_comodidades_equipamiento_tv" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_tv === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_comodidades_equipamiento_vajilla = get_post_meta($get_listing_edit, '_ofiliaria_adicional_comodidades_equipamiento_vajilla', true);
    ?>

    <div id="div_ofiliaria_adicional_comodidades_equipamiento_vajilla" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Vajilla', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_vajilla_si" name="_ofiliaria_adicional_comodidades_equipamiento_vajilla" value="Sí"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_vajilla === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_comodidades_equipamiento_vajilla_no" name="_ofiliaria_adicional_comodidades_equipamiento_vajilla" value="No"
                    <?php echo ($_ofiliaria_adicional_comodidades_equipamiento_vajilla === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_seguridad_alarma = get_post_meta($get_listing_edit, '_ofiliaria_adicional_seguridad_alarma', true);
    ?>

    <div id="div_ofiliaria_adicional_seguridad_alarma" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Alarma', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_seguridad_alarma_si" name="_ofiliaria_adicional_seguridad_alarma" value="Sí"
                    <?php echo ($_ofiliaria_adicional_seguridad_alarma === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_seguridad_alarma_no" name="_ofiliaria_adicional_seguridad_alarma" value="No"
                    <?php echo ($_ofiliaria_adicional_seguridad_alarma === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_seguridad_porton_automatico = get_post_meta($get_listing_edit, '_ofiliaria_adicional_seguridad_porton_automatico', true);
    ?>

    <div id="div_ofiliaria_adicional_seguridad_porton_automatico" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Portón automático', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_seguridad_porton_automatico_si" name="_ofiliaria_adicional_seguridad_porton_automatico" value="Sí"
                    <?php echo ($_ofiliaria_adicional_seguridad_porton_automatico === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_seguridad_porton_automatico_no" name="_ofiliaria_adicional_seguridad_porton_automatico" value="No"
                    <?php echo ($_ofiliaria_adicional_seguridad_porton_automatico === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad = get_post_meta($get_listing_edit, '_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad', true);
    ?>

    <div id="div_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Circuito de cámaras de seguridad', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad_si" name="_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad" value="Sí"
                    <?php echo ($_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad_no" name="_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad" value="No"
                    <?php echo ($_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_seguridad_tipo_de_seguridad = get_post_meta($get_listing_edit, '_ofiliaria_adicional_seguridad_tipo_de_seguridad', true);
    ?>

    <div id="div_ofiliaria_adicional_seguridad_tipo_de_seguridad" class="col-md-6 ofiliaria_detalle_anuncio" style="">
        <label for="_ofiliaria_adicional_seguridad_tipo_de_seguridad">Tipo de seguridad</label>
        <select id="_ofiliaria_adicional_seguridad_tipo_de_seguridad" name="_ofiliaria_adicional_seguridad_tipo_de_seguridad">
            <option value="No disponible" <?php selected($_ofiliaria_adicional_seguridad_tipo_de_seguridad, 'No disponible'); ?>>No disponible</option>
            <option value="24 hs" <?php selected($_ofiliaria_adicional_seguridad_tipo_de_seguridad, '24 hs'); ?>>24 hs</option>
            <option value="Diurno" <?php selected($_ofiliaria_adicional_seguridad_tipo_de_seguridad, 'Diurno'); ?>>Diurno</option>
            <option value="Nocturno" <?php selected($_ofiliaria_adicional_seguridad_tipo_de_seguridad, 'Nocturno'); ?>>Nocturno</option>
            <option value="Virtual" <?php selected($_ofiliaria_adicional_seguridad_tipo_de_seguridad, 'Virtual'); ?>>Virtual</option>
        </select>
    </div>

    <?php
    $_ofiliaria_adicional_seguridad_acceso_controlado = get_post_meta($get_listing_edit, '_ofiliaria_adicional_seguridad_acceso_controlado', true);
    ?>

    <div id="div_ofiliaria_adicional_seguridad_acceso_controlado" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Acceso controlado', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_seguridad_acceso_controlado_si" name="_ofiliaria_adicional_seguridad_acceso_controlado" value="Sí"
                    <?php echo ($_ofiliaria_adicional_seguridad_acceso_controlado === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_seguridad_acceso_controlado_no" name="_ofiliaria_adicional_seguridad_acceso_controlado" value="No"
                    <?php echo ($_ofiliaria_adicional_seguridad_acceso_controlado === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_seguridad_con_barrio_cerrado = get_post_meta($get_listing_edit, '_ofiliaria_adicional_seguridad_con_barrio_cerrado', true);
    ?>

    <div id="div_ofiliaria_adicional_seguridad_con_barrio_cerrado" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Con barrio cerrado', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_seguridad_con_barrio_cerrado_si" name="_ofiliaria_adicional_seguridad_con_barrio_cerrado" value="Sí"
                    <?php echo ($_ofiliaria_adicional_seguridad_con_barrio_cerrado === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_seguridad_con_barrio_cerrado_no" name="_ofiliaria_adicional_seguridad_con_barrio_cerrado" value="No"
                    <?php echo ($_ofiliaria_adicional_seguridad_con_barrio_cerrado === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_ambientes_altillo = get_post_meta($get_listing_edit, '_ofiliaria_adicional_ambientes_altillo', true);
    ?>

    <div id="div_ofiliaria_adicional_ambientes_altillo" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Altillo', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_altillo_si" name="_ofiliaria_adicional_ambientes_altillo" value="Sí"
                    <?php echo ($_ofiliaria_adicional_ambientes_altillo === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_altillo_no" name="_ofiliaria_adicional_ambientes_altillo" value="No"
                    <?php echo ($_ofiliaria_adicional_ambientes_altillo === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_ambientes_balcon = get_post_meta($get_listing_edit, '_ofiliaria_adicional_ambientes_balcon', true);
    ?>

    <div id="div_ofiliaria_adicional_ambientes_balcon" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Balcón', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_balcon_si" name="_ofiliaria_adicional_ambientes_balcon" value="Sí"
                    <?php echo ($_ofiliaria_adicional_ambientes_balcon === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_balcon_no" name="_ofiliaria_adicional_ambientes_balcon" value="No"
                    <?php echo ($_ofiliaria_adicional_ambientes_balcon === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_ambientes_cocina = get_post_meta($get_listing_edit, '_ofiliaria_adicional_ambientes_cocina', true);
    ?>

    <div id="div_ofiliaria_adicional_ambientes_cocina" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Cocina', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_cocina_si" name="_ofiliaria_adicional_ambientes_cocina" value="Sí"
                    <?php echo ($_ofiliaria_adicional_ambientes_cocina === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_cocina_no" name="_ofiliaria_adicional_ambientes_cocina" value="No"
                    <?php echo ($_ofiliaria_adicional_ambientes_cocina === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_ambientes_comedor = get_post_meta($get_listing_edit, '_ofiliaria_adicional_ambientes_comedor', true);
    ?>

    <div id="div_ofiliaria_adicional_ambientes_comedor" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Comedor', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_comedor_si" name="_ofiliaria_adicional_ambientes_comedor" value="Sí"
                    <?php echo ($_ofiliaria_adicional_ambientes_comedor === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_comedor_no" name="_ofiliaria_adicional_ambientes_comedor" value="No"
                    <?php echo ($_ofiliaria_adicional_ambientes_comedor === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_ambientes_dormitorio_en_suite = get_post_meta($get_listing_edit, '_ofiliaria_adicional_ambientes_dormitorio_en_suite', true);
    ?>

    <div id="div_ofiliaria_adicional_ambientes_dormitorio_en_suite" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Dormitorio en suite', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_dormitorio_en_suite_si" name="_ofiliaria_adicional_ambientes_dormitorio_en_suite" value="Sí"
                    <?php echo ($_ofiliaria_adicional_ambientes_dormitorio_en_suite === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_dormitorio_en_suite_no" name="_ofiliaria_adicional_ambientes_dormitorio_en_suite" value="No"
                    <?php echo ($_ofiliaria_adicional_ambientes_dormitorio_en_suite === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_ambientes_estudio = get_post_meta($get_listing_edit, '_ofiliaria_adicional_ambientes_estudio', true);
    ?>

    <div id="div_ofiliaria_adicional_ambientes_estudio" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Estudio', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_estudio_si" name="_ofiliaria_adicional_ambientes_estudio" value="Sí"
                    <?php echo ($_ofiliaria_adicional_ambientes_estudio === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_estudio_no" name="_ofiliaria_adicional_ambientes_estudio" value="No"
                    <?php echo ($_ofiliaria_adicional_ambientes_estudio === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_ambientes_living = get_post_meta($get_listing_edit, '_ofiliaria_adicional_ambientes_living', true);
    ?>

    <div id="div_ofiliaria_adicional_ambientes_living" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Living', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_living_si" name="_ofiliaria_adicional_ambientes_living" value="Sí"
                    <?php echo ($_ofiliaria_adicional_ambientes_living === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_living_no" name="_ofiliaria_adicional_ambientes_living" value="No"
                    <?php echo ($_ofiliaria_adicional_ambientes_living === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_ambientes_patio = get_post_meta($get_listing_edit, '_ofiliaria_adicional_ambientes_patio', true);
    ?>

    <div id="div_ofiliaria_adicional_ambientes_patio" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Patio', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_patio_si" name="_ofiliaria_adicional_ambientes_patio" value="Sí"
                    <?php echo ($_ofiliaria_adicional_ambientes_patio === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_patio_no" name="_ofiliaria_adicional_ambientes_patio" value="No"
                    <?php echo ($_ofiliaria_adicional_ambientes_patio === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_ambientes_placards = get_post_meta($get_listing_edit, '_ofiliaria_adicional_ambientes_placards', true);
    ?>

    <div id="div_ofiliaria_adicional_ambientes_placards" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Placards', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_placards_si" name="_ofiliaria_adicional_ambientes_placards" value="Sí"
                    <?php echo ($_ofiliaria_adicional_ambientes_placards === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_placards_no" name="_ofiliaria_adicional_ambientes_placards" value="No"
                    <?php echo ($_ofiliaria_adicional_ambientes_placards === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_ambientes_cuarto_de_juegos = get_post_meta($get_listing_edit, '_ofiliaria_adicional_ambientes_cuarto_de_juegos', true);
    ?>

    <div id="div_ofiliaria_adicional_ambientes_cuarto_de_juegos" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Cuarto de juegos', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_cuarto_de_juegos_si" name="_ofiliaria_adicional_ambientes_cuarto_de_juegos" value="Sí"
                    <?php echo ($_ofiliaria_adicional_ambientes_cuarto_de_juegos === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_cuarto_de_juegos_no" name="_ofiliaria_adicional_ambientes_cuarto_de_juegos" value="No"
                    <?php echo ($_ofiliaria_adicional_ambientes_cuarto_de_juegos === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_ambientes_con_lavadero = get_post_meta($get_listing_edit, '_ofiliaria_adicional_ambientes_con_lavadero', true);
    ?>

    <div id="div_ofiliaria_adicional_ambientes_con_lavadero" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Con lavadero', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_con_lavadero_si" name="_ofiliaria_adicional_ambientes_con_lavadero" value="Sí"
                    <?php echo ($_ofiliaria_adicional_ambientes_con_lavadero === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_con_lavadero_no" name="_ofiliaria_adicional_ambientes_con_lavadero" value="No"
                    <?php echo ($_ofiliaria_adicional_ambientes_con_lavadero === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_ambientes_vestidor = get_post_meta($get_listing_edit, '_ofiliaria_adicional_ambientes_vestidor', true);
    ?>

    <div id="div_ofiliaria_adicional_ambientes_vestidor" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Vestidor', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_vestidor_si" name="_ofiliaria_adicional_ambientes_vestidor" value="Sí"
                    <?php echo ($_ofiliaria_adicional_ambientes_vestidor === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_vestidor_no" name="_ofiliaria_adicional_ambientes_vestidor" value="No"
                    <?php echo ($_ofiliaria_adicional_ambientes_vestidor === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_ambientes_desayunador = get_post_meta($get_listing_edit, '_ofiliaria_adicional_ambientes_desayunador', true);
    ?>

    <div id="div_ofiliaria_adicional_ambientes_desayunador" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Desayunador', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_desayunador_si" name="_ofiliaria_adicional_ambientes_desayunador" value="Sí"
                    <?php echo ($_ofiliaria_adicional_ambientes_desayunador === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_desayunador_no" name="_ofiliaria_adicional_ambientes_desayunador" value="No"
                    <?php echo ($_ofiliaria_adicional_ambientes_desayunador === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <?php
    $_ofiliaria_adicional_ambientes_jardin = get_post_meta($get_listing_edit, '_ofiliaria_adicional_ambientes_jardin', true);
    ?>

    <div id="div_ofiliaria_adicional_ambientes_jardin" class="col-md-6 ofiliaria_detalle_anuncio">

        <label><?php esc_html_e('Jardín', 'wpresidence'); ?></label>
        <div class="radio-buttons-container">
            <!-- Opción "Sí" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_jardin_si" name="_ofiliaria_adicional_ambientes_jardin" value="Sí"
                    <?php echo ($_ofiliaria_adicional_ambientes_jardin === 'Sí') ? 'checked="checked"' : ''; ?>>
                Sí
            </label>
            
            <!-- Opción "No" -->
            <label class="radio-inline">
                <input type="radio" id="_ofiliaria_adicional_ambientes_jardin_no" name="_ofiliaria_adicional_ambientes_jardin" value="No"
                    <?php echo ($_ofiliaria_adicional_ambientes_jardin === 'No') ? 'checked="checked"' : ''; ?>>
                No
            </label>
        </div>
    </div>

    <!-- Fin cambios Ofiliaira -->

    <!-- Display custom fields -->
    <?php echo ($custom_fields_show); ?>

    <?php
    // Display owner notes field
    if (is_array($wpestate_submission_page_fields) && in_array('owner_notes', $wpestate_submission_page_fields)) : ?>
        <div class="col-md-12">
            <label for="owner_notes"><?php esc_html_e('Owner/Agent notes (*not visible on front end)', 'wpresidence'); ?></label>
            <textarea id="owner_notes" class="form-control" name="owner_notes"><?php echo esc_textarea(wpestate_submit_return_value('owner_notes', $get_listing_edit, '')); ?></textarea>
        </div>
    <?php endif; ?>

</div>

<?php endif; ?>