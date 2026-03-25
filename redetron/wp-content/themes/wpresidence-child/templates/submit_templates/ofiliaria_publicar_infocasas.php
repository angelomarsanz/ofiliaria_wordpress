<?php
global $wpestate_submission_page_fields;
$ofiliaria_publicar_infocasas = '';
$id_post_publicacion = 0;

if (isset($_POST['ofiliaria_publicar_infocasas']))
{
    $ofiliaria_publicar_infocasas = 'checked';
}
else
{
    if (isset($_GET['listing_edit']) && is_numeric($_GET['listing_edit'])) 
    {
        $id_post_publicacion = intval($_GET['listing_edit']);
        $indicador_publicacion_infocasas = get_post_meta($id_post_publicacion, '_ofiliaria_publicar_en_infocasas', true);
        
        if ($indicador_publicacion_infocasas != '')
        {
            $ofiliaria_publicar_infocasas = 'checked';            
        }
    }
}
?>
<div class="profile-onprofile row">
    <div id='titulo_publicar_infocasas' class="wpestate_dashboard_section_title">
        <?php esc_html_e('Infocasas','wpresidence');?>
    </div>
    <div class="col-md-12">
        <input type="checkbox" id="ofiliaria_publicar_infocasas" name="ofiliaria_publicar_infocasas" <?php echo $ofiliaria_publicar_infocasas; ?>>
        <label class="checklabel" for="ofiliaria_publicar_infocasas"><?php esc_html_e('Sincronizar con Infocasas ','wpresidence');?></label>
        <br /><br />
    </div>
</div>