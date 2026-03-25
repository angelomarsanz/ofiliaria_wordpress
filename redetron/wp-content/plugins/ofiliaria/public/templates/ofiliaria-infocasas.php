<?php
wpestate_dashboard_header_permissions(); 
get_header(); 
$usuario_conectado = wp_get_current_user();
?>

<div id='indexInfocasas'></div>
<div class="row row_user_dashboard">
    <?php  get_template_part('templates/dashboard-templates/dashboard-left-col'); ?>
    <div class="col-md-9 dashboard-margin">
        <?php wpestate_show_dashboard_title(get_the_title()); ?>
        <div class="col-md-12 wpestate_dash_coluns">
            <?php
            if ($usuario_conectado->ID == 2): ?>
              <div>
                <div id='mensajes_infocasas'></div>
                <br /><br />
                <button id="crear_xml_infocasas" class="wpresidence_button">Crear xml Infocasas</button>
                <br />
              </div>
            <?php
            endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>