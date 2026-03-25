<?php 
wpestate_dashboard_header_permissions();
get_header(); ?>
<div class="row row_user_dashboard">
    <?php  get_template_part('templates/dashboard-templates/dashboard-left-col'); ?>
    <div class="col-md-9 dashboard-margin">
        <?php wpestate_show_dashboard_title(get_the_title()); ?>
        <div class="col-md-12 wpestate_dash_coluns">
            <p>Estimado usuario al conectar Ofiliaria con tu cuenta de Mercado Libre, los inmuebles que agregues a nuestra plataforma también podrás publicarlos opcionalmente en Mercado Libre.</p>
            <br />
            <p>Para configurar la conexión de Ofiliaria con Mercado Libre, primero debes acceder a tu cuenta de mercado libre con tu usuario y clave y después regresar a esta página nuevamente para continuar con la configuración de la conexión.</p>
            <br />
            <button class="wpresidence_button" id="acceder_a_meli">Acceder a mi cuenta de Mercado Libre</button>
            <br />
            <p>Si ya has ingresado a tu cuenta de Mercado Libre pulsa el siguiente botón para continuar con la configuración de la conexión:</p>
            <br />
            <button class="wpresidence_button" id="continuar_configuracion">Continuar con la configuración de la conexión</button>
            <br />
        </div>
        <div id='indexMercadoLibre'><div>
    </div>
</div>

<?php get_footer(); ?>