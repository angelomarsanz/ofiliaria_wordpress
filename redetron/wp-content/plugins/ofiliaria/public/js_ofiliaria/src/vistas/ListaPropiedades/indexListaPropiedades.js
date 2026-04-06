import { 
    guardarTokenMeli,
    refrescarTokenMeli,
    verificarTokenMeli } from "../../funciones_globales";

export const indexListaPropiedades = () => 
{
    (function( $ ) {
        if ($('#indexListaPropiedades').length > 0) 
        {
            var pathname = window.location.pathname;
            var url_base = window.location.hostname; 
            var ajaxurl = variables_php_javascript.ajax_url;
            var client_id_meli = variables_php_javascript.client_id_meli;
            var client_secret_meli = variables_php_javascript.client_secret_meli;
            var token_meli = "";
            var refresh_token_meli = ""; 

            async function obtenerTokenMeliLP() {
                const respuestaVerificarToken = await verificarTokenMeli(ajaxurl);
                token_meli = respuestaVerificarToken.token_meli;
                if (respuestaVerificarToken.codigo_respuesta == 4)
                {
                    refresh_token_meli = respuestaVerificarToken.refresh_token_meli;
                    usuario_duenio_token = respuestaVerificarToken.usuario_duenio_token;
                    const respuestaRefrescarToken = await refrescarTokenMeli(client_id_meli, client_secret_meli, refresh_token_meli);
                    token_meli = respuestaRefrescarToken.token_meli;
                    refresh_token_meli = respuestaRefrescarToken.refresh_token_meli;
                    guardarTokenMeli("refrescar", token_meli, refresh_token_meli, ajaxurl, usuario_duenio_token);
                }
                console.log('indexListaPropiedades, token_meli', token_meli);
                console.log('indexListaPropiedades, refresh_token_meli', refresh_token_meli);
            }  

            function destaquePublicacionMeli(id_post, id_meli_publicacion, destaque_actual_mercado_libre, nuevo_destaque_mercado_libre) 
            {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: 
                    {
                        'action' : 'destaque_publicacion_meli',
                        'id_post' : id_post,
                        'id_meli_publicacion' : id_meli_publicacion,
                        'destaque_actual_mercado_libre' : destaque_actual_mercado_libre,
                        'nuevo_destaque_mercado_libre' : nuevo_destaque_mercado_libre
                    },
                    success: function(data) 
                    {
                        console.log('destaquePublicacionMeli, data', data);
                        if (data.codigo_retorno == 0)
                        {
                            $(`#destaque_actual_mercado_libre_${id_post}`).val(nuevo_destaque_mercado_libre); 
                            let mensaje_destaque = 
                                `
                                    <br />
                                    <div class="alert alert-success">
                                        ${data.mensaje}
                                    </div>
                                `;
                            $(`#ofiliaria_gif_espere_mensajes_${id_post}`).html(mensaje_destaque);
                        }
                        else
                        {
                            let mensaje_destaque = 
                                `
                                    <br />
                                    <div class="alert alert-warning">
                                        ${data.mensaje}
                                    </div>
                                `;
                            $(`#ofiliaria_gif_espere_mensajes_${id_post}`).html(mensaje_destaque);
                        }
                    },
                    error: function (x, xs, xt) 
                    {
                        console.log('error', JSON.stringify(x));
                    }
                });
            };

            function reasignacionDeAgente(id_post, id_usuario_agente) 
            {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: 
                    {
                        'action' : 'reasignacion_de_agente',
                        'id_post' : id_post,
                        'id_usuario_agente' : id_usuario_agente
                    },
                    success: function(data) 
                    {
                        console.log('reasignacion_de_agente, data', data);
                        if (data.codigo_retorno == 0)
                        {
                            let mensaje_reasignacion_de_agente = 
                                `
                                    <br />
                                    <div class="alert alert-success">
                                        ${data.mensaje}
                                    </div>
                                `;
                            $(`#ofiliaria_gif_espere_mensajes_${id_post}`).html(mensaje_reasignacion_de_agente);
                        }
                        else
                        {
                            let mensaje_reasignacion_de_agente = 
                                `
                                    <br />
                                    <div class="alert alert-warning">
                                        ${data.mensaje}
                                    </div>
                                `;
                            $(`#ofiliaria_gif_espere_mensajes_${id_post}`).html(mensaje_reasignacion_de_agente);
                        }
                    },
                    error: function (x, xs, xt) 
                    {
                        console.log('error', JSON.stringify(x));
                    }
                });
            };
                
            $(function() {

                $(document).on('change', '.agentes_agencia', function() {
                    const $el = $(this);
                    const id_post = $el.data('postid');
                    const id_agente = $el.val();

                    $(`#ofiliaria_gif_espere_mensajes_${id_post}`).html(
                        `<img src='https://dev-backend.ofiliaria.com/public/imagenes/loading.gif' style="width: 25px;" />`
                    );

                    // Llamada AJAX Original
                    reasignacionDeAgente(id_post, id_agente);
                }); 

                $(document).on('change', '.destaques_mercado_libre', function() {
                    const $el = $(this);
                    const id_post = $el.data('postid');
                    const nuevo_val = $el.val();
                    const id_meli = $(`#id_meli_publicacion_${id_post}`).val();
                    const anterior_val = $(`#prev_val_destaque_${id_post}`).val();

                    // Mostrar Loader
                    $(`#ofiliaria_gif_espere_mensajes_${id_post}`).html(
                        `<img src='https://dev-backend.ofiliaria.com/public/imagenes/loading.gif' style="width: 25px;" />`
                    );

                    // Llamada AJAX Original
                    destaquePublicacionMeli(id_post, id_meli, anterior_val, nuevo_val);
                    
                    // Actualizar valor previo para el siguiente cambio
                    $(`#prev_val_destaque_${id_post}`).val(nuevo_val);
                });

            });
        }    
    })(jQuery);
}
indexListaPropiedades();