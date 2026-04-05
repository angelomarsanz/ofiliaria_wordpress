<?php
/** MILLDONE
 * Property Status Display Template
 * src: templates\dashboard-templates\dashboard-unit-templates\dashboard-unit-status.php
 * Displays the current status of a property listing including its publication
 * and payment status. Handles different states: published, expired, disabled,
 * draft, and pending approval.
 *
 * Required variables:
 * @param int    $post_id               The property post ID
 * @param string $paid_submission_status The type of submission payment system
 */

// Get current post status
$post_status = get_post_status($post_id);
$status = '';
$link = '';

// Determine status label and link based on post status
if ($post_status == 'expired') {
    $status = 'Ofiliaria: Expirada';
} elseif ($post_status == 'publish') {
    $link = get_permalink();
    $status = 'Ofiliaria: Publicada';
} elseif ($post_status == 'disabled') {
    $status = 'Ofiliaria: Deshabilitada';
} elseif ($post_status == 'draft') {
    $status = 'Ofiliaria: Borrador';
} else {
    $status = 'Ofiliaria: Esperando por aprobación';
}

// Handle payment status for per listing submissions
$is_pay_status = '';
if ($paid_submission_status == 'per listing') {
    $pay_status = get_post_meta($post_id, 'pay_status', true);
    if ($pay_status == 'paid') {
        $is_pay_status = esc_html__('Paid', 'wpresidence');
    } else {
        $is_pay_status = esc_html__('Not Paid', 'wpresidence');
    }
}

// Display status with appropriate CSS class
?>
<br />
<div class="property_list_status_label <?php echo sanitize_key($post_status); ?>">
    <?php echo esc_html($status).' <span>#'.$post_id.'</span>' ?>
</div>
<br />
<?php
if ($id_meli_publicacion != '')
{ 
    if ($publicacion_meli->status == 'active')
    { ?>
        <div class="property_list_status_label publish">
            <a href="<?php echo $publicacion_meli->permalink; ?>" target="_blank">Mercado Libre: <?php echo $publicacion_meli->status.' <span style="font-size: 0.75rem">#'.$id_meli_publicacion ?></span></a>
        </div>
    <?php
    }
    else
    { ?>
        <div class="property_list_status_label expired">
            <a href="<?php echo $publicacion_meli->permalink; ?>" target="_blank">Mercado Libre: <?php echo $publicacion_meli->status.' <span style="font-size: 0.75rem">#'.$id_meli_publicacion ?></span></a>
        </div>
    <?php
    }
}
else
{ ?>
    <div class="property_list_status_label disabled">
        <span>Mercado Libre: No Sincronizada</span>
    </div>
<?php
} ?>
<?php
$id_infocasas_agencia_agente = '';
if ($id_post_agencia_agente != '')
{
    $post_agencia_agente = get_post($id_post_agencia_agente);
    if ($post_agencia_agente->post_author == 0)
    {
        $id_infocasas_agencia_agente = get_user_meta($id_autor_publicacion, '_ofiliaria_id_infocasas_agencia_agente', true);
    }
    else
    {
        $id_infocasas_agencia_agente = get_user_meta($post_agencia_agente->post_author, '_ofiliaria_id_infocasas_agencia_agente', true);
    }
}
$url_infocasas = 'http://infocasas.com.uy/apps/getIdImport/index.php?k=hfGKf6e8fgGDF8b4!&IDinmo='.$id_infocasas_agencia_agente.'&id2='.$post_id;
if ($id_infocasas_agencia_agente != '')
{
    if ($indicador_publicar_infocasas_enviado == 'Sí')
    {
        $indicador_publicacion_en_infocasas = 0;
    }
    elseif ($indicador_publicar_infocasas == 'Sí')
    {
        $indicador_publicacion_en_infocasas = 1;
    }
    else
    {
        $indicador_publicacion_en_infocasas = 2;
    }
} ?>
<br />
<?php
if ($indicador_publicacion_en_infocasas == 0)
{ ?>      
    <div class="property_list_status_label publish">
        <a href="<?php echo $url_infocasas; ?>" target="_blank">Infocasas: Enviada <span style="font-size: 0.75rem">#<?php echo $post_id ?></span></a>
    </div>
<?php
}
else if ($indicador_publicacion_en_infocasas == 1)
{ ?>
    <div class="property_list_status_label pending">
        <span>Infocasas: Por enviar</span>
    </div>
<?php
} 
else 
{ ?>
    <div class="property_list_status_label disabled">
        <span>Infocasas: No sincronizada</span>
    </div>
<?php
} ?>
<br />