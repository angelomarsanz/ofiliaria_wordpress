<?php 
// wpestate_dashboard_header_permissions();
get_header(); ?>

<div class="row row_user_dashboard">
    <?php  get_template_part('templates/dashboard-templates/dashboard-left-col'); ?>
    <div class="col-md-9 dashboard-margin">
        <?php wpestate_show_dashboard_title(get_the_title()); ?>         
        <div>
          <?php 
            if (isset($_POST['resource'])):
              update_user_meta(1, '_ofiliaria_notificacion_meli', $_POST['resource']);
            endif;
          ?>   
        </div>     
    </div>
</div>

<?php get_footer(); ?>