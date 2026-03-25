<?php
/** MILLDONE
 * Template Name: Referidos
 * src: page-templates\user_dashboard_referidos.php
 * Esta archivo es parte de las plantillas personalizadas de ofiliaria.
 * 
 * @package WpResidence
 * @subpackage UserDashboard
 * @since WpResidence 1.0
 *
 * Dependencies:
 * - WordPress core functions
 * - WpResidence theme functions (wpestate_*)
 *
 * Uso:
 * Esta Plantilla tiene como objetivo mostrar las opciones del sistema de referidos de Ofiliaria.
 * Muestra opción de compartir y generar links de referidos además de mostrar las comisiones ganadas.
 */

// Verificar permisos del usuario
wpestate_dashboard_header_permissions();

get_header();
?>

<div class="row row_user_dashboard">

    <?php  get_template_part('templates/dashboard-templates/dashboard-left-col');?>

    <div class="col-md-9 dashboard-margin">

        <?php
        wpestate_show_dashboard_title(get_the_title());
        ?>

        <div class="col-md-12 wpestate_dash_coluns">
          <div class="wpestate_dashboard_content_wrapper">
            <?php
            echo do_shortcode ('[rs_generate_referral referralbutton="show" referraltable="show"]');
            ?>
          </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>

