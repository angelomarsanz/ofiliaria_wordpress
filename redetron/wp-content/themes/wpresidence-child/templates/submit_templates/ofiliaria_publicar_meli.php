<?php
global $wpestate_submission_page_fields;
$check_ofiliaria_publicar_meli = '';
$id_post_publicacion = 0;
$indicador_publicar_meli = '';
$id_publicacion_meli = 0;

if (isset($_POST['ofiliaria_publicar_meli']))
{
    $check_ofiliaria_publicar_meli = 'checked';
}
else
{
    if (isset($_GET['listing_edit']) && is_numeric($_GET['listing_edit'])) 
    {
        $id_post_publicacion = intval($_GET['listing_edit']);
        $indicador_publicar_meli = get_post_meta($id_post_publicacion, '_ofiliaria_publicar_en_mercado_libre', true);
        
        if ($indicador_publicar_meli == 'Sí')
        {
            $check_ofiliaria_publicar_meli = 'checked';
        }
        $id_publicacion_meli = get_post_meta($id_post_publicacion, '_ofiliaria_id_meli_publicacion', true);  
        if ($id_publicacion_meli == '')
        {
            $id_publicacion_meli = 0;
        }          
    }
}
?>
<div id="indexAniadirNuevaPropiedad"></div>
<input type="hidden" id='id_publicacion_meli' name="id_publicacion_meli" value="<?php echo $id_publicacion_meli; ?>">
<input type='hidden' id='identificador' name='identificador' value=''> 
<input type='hidden' id='id_post_publicacion' name='id_post_publicacion' value='<?php echo $id_post_publicacion; ?>'> 
<input type='hidden' id='estatus_publicacion_meli' name='estatus_publicacion_meli' value='No publicada'>
<input type='hidden' id='check_ofiliaria_publicar_meli' name='check_ofiliaria_publicar_meli' value='<?php echo $check_ofiliaria_publicar_meli; ?>'> 
<div class="profile-onprofile row">
    <div class='wpestate_dashboard_section_title' id='titulo_publicar_mercado_libre'>
        <?php esc_html_e('Mercado Libre','wpresidence');?>
    </div>
    <div class='col-md-12' id='div_ofiliaria_publicar_meli'>
    </div>
    <div class='col-md-12' id='mensajes_generales'>
    </div>
    <div class="col-md-12" id="mensaje_no_conectado_meli">
        <div class="alert alert-warning alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            Estimado usuario para publicar sus inmuebles en Mercado Libre, primero debe configurar su conexión con Mercado Libre.
        </div>
        <div>
            <br />
            <button id="boton_configurar_conexion_meli" class="wpresidence_button">Configurar conexión con Mercado Libre</button>
            <br />
        </div>
    </div>
    <div class='col-md-12' id='div_ofiliaria_republicar_meli'>
    </div>
    <div class='col-md-12' id="mensaje_publicacion_exitosa">
    </div>
</div>