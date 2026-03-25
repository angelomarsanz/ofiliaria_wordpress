<?php
wpestate_dashboard_header_permissions(); 
get_header(); 
$usuario_conectado = wp_get_current_user();
// Definición del vector de opciones para el select
$opciones_utilitarios_meli = [
  'cambiar_agente' => 'Cambiar agente',
  'reparar_tabla_imagenes' => 'Reparar tabla imágenes',
  'eliminar_publicaciones_pausadas' => 'Eliminar de Ofiliaria publicaciones pausadas/cerradas en MELI',
  'agregar_whatsapp' => 'Agregar Whatsapp',
  'verificar_datos_envio' => 'Verificar datos envío publicaciones Meli',
];
?>

<div id='indexMercadoLibre'></div>
<div class="row row_user_dashboard">
    <?php  get_template_part('templates/dashboard-templates/dashboard-left-col'); ?>
    <div class="col-md-9 dashboard-margin">
        <?php wpestate_show_dashboard_title(get_the_title()); ?>
        <div class="col-md-12 wpestate_dash_coluns">
            <input type="hidden" name="codigo_temporal" id="codigo_temporal" value=<?php echo isset($_GET['code']) ? $_GET['code'] : "error"; ?> />
            <p id="configuracion_conexion_meli"></p>
            <div id="configurar_conexion_meli">
              <br />
              <button id="opcion_configurar_conexion_meli" class="wpresidence_button">Configurar conexión con Mercado Libre</button>
              <br />
            </div>
            <?php
            if ($usuario_conectado->ID == 2): ?>
              <div>
                <div id='mensajes_importacion_meli'></div>
                <br /><br />
                <div id='mensajes_adicionales_meli'></div>
                <br /><br />
                <button id="previo_importar_publicaciones_meli" class="wpresidence_button">Paso 1: Previo de importación de Mercado Libre</button>
                <br /><br />
                <button id="importar_publicaciones_meli" class="wpresidence_button">Paso 2: Importar publicaciones de Mercado Libre</button>
                <br /><br />
                <button id="importar_descripcion_publicaciones_meli" class="wpresidence_button">Paso 3: Importar la descripción de las publicaciones de Mercado Libre</button>
                <br /><br />
                <button id="importar_archivos_meli" class="wpresidence_button">Paso 4: Importar archivos de Mercado Libre</button>
                <br /><br />
                <button id="asociar_archivos_publicacion_meli" class="wpresidence_button">Paso 5: Asociar archivos a publicaciones de Mercado Libre</button>
                <br /><br />
                <div class="row"> 
                  <div class="col-xs-12 col-sm-6"> 
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                          <h3 class="panel-title">Utilitarios MELI</h3>
                      </div>
                      <div class="panel-body">
                        <form id="form_utilitarios_meli" role="form">
                            <div class="form-group">
                                <label for="utilitarios_meli">Seleccione una opción:</label>
                                <select class="form-control" id="utilitarios_meli" name="utilitarios_meli">
                                    <option value="">-- Seleccione --</option>
                                    <?php foreach ($opciones_utilitarios_meli as $value => $label): ?>
                                        <option value="<?php echo htmlspecialchars($value); ?>"><?php echo htmlspecialchars($label); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <br /> 
                            <div class="form-group">
                                <label for="parametros_meli">Parámetros (separados por coma si son varios):</label>
                                <input type="text" class="form-control" id="parametros_meli" name="parametros_meli" placeholder="Ingrese los parámetros aquí">
                            </div>
                            <br /> 
                            <div id="mensaje_parametros" class="alert alert-info" style="display: none;">
                            </div>
                            <br /> 
                            <button type="button" id="enviar_utilitario_meli" class="btn btn-primary">Enviar</button>
                        </form>
                      </div>
                      <br />
                      <div id='mensajes_utilitarios_meli'></div>
                      <div id='mensajes_adicionales_utilitarios_meli'></div>
                    </div>
                  </div>
                </div>
              </div>
            <?php
            endif; ?>
        </div>
        <div>
          <?php // echo do_shortcode( '[mercadolibre]' ); ?>   
        </div>     
    </div>
</div>

<?php get_footer(); ?>