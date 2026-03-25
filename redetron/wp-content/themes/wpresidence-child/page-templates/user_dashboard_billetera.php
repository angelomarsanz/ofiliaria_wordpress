<?php
/** MILLDONE
 * Template Name: User Dashboard Billetera
 * src: page-templates\user_dashboard_billetera.php
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
 * Esta Plantilla tiene como objetivo mostrar las opciones del sistema de saldos virtuales de Ofiliaria.
 * Muestra opción de ver transacciones, saldos y comisiones acumuladas del usuario.
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
          <?php echo do_shortcode ('[rs_my_rewards_log]'); ?>
          </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
