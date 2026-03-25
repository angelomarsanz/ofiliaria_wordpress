<?php
wpestate_dashboard_header_permissions();
get_header();

// Obtener la URL base del sitio WordPress
$base_url = home_url();

// Construir la URL completa de redirección
// Usamos trim para eliminar cualquier barra final si home_url() la devuelve,
// aunque home_url() generalmente no la incluye por defecto.
$redirect_url = trim($base_url, '/') . '/garantias';

?>

<div class="row row_user_dashboard">
    <?php  get_template_part('templates/dashboard-templates/dashboard-left-col'); ?>
    <div class="col-md-9 dashboard-margin">
        <?php wpestate_show_dashboard_title(get_the_title()); ?>
        <div>
            <?php
                // Redireccionar usando la URL dinámica
                header("Location: " . $redirect_url);
                exit();
            ?>
        </div>
    </div>
</div>
<div id='con_editor_js'></div>
<?php get_footer(); ?>
<script>
    const global = globalThis;
</script>