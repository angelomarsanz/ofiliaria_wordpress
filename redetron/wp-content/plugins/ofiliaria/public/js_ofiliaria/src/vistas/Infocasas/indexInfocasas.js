export const indexInfocasas = () => 
{
    (function( $ ) {
        if ($('#indexInfocasas').length > 0) 
        {
            var pathname = window.location.pathname;
            var url_base = window.location.hostname; 
            var ajaxurl = variables_php_javascript.ajax_url;
            
            function buscarUsuariosInfocasas() {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: 
                    {
                        'action' : 'buscar_usuarios_infocasas'
                    },
                    success: function(data) 
                    {
                        console.log('buscarUsuariosInfocasas, data', data);
                        $('#mensajes_infocasas').text(data.mensaje);
                        procesarUsuariosInfocasas(data.usuarios_infocasas);
                    },
                    error: function (x, xs, xt) 
                    {
                        console.log('error', JSON.stringify(x));
                    }
                });
            };
            
            async function procesarUsuariosInfocasas(usuariosInfocasas) 
            {
                // Obtener la URL base de la página actual
                const baseUrl = window.location.origin;

                // Verificar la URL base
                if (baseUrl === 'https://ofiliaria.com.uy') {
                    // Si la URL coincide, ejecutar el bucle completo
                    for (const usuario of usuariosInfocasas) {
                        const respuesta = await crearXmlInfocasas(usuario);
                        if (respuesta.success) {
                            $('#mensajes_infocasas').text(respuesta.data.message);
                        } else {
                            $('#mensajes_infocasas').text('Error: ' + (respuesta.data.message || 'Ocurrió un error desconocido.'));
                        }
                    }
                } else {
                    // Si la URL es diferente, ejecutar el bucle para los primeros 2 elementos
                    for (let i = 0; i < Math.min(2, usuariosInfocasas.length); i++) {
                        const usuario = usuariosInfocasas[i];
                        const respuesta = await crearXmlInfocasas(usuario);
                        if (respuesta.success) {
                            $('#mensajes_infocasas').text(respuesta.data.message);
                        } else {
                            $('#mensajes_infocasas').text('Error: ' + (respuesta.data.message || 'Ocurrió un error desconocido.'));
                        }
                    }
                }
            }
            
            function crearXmlInfocasas(usuarioInfocasas)
            {
                return new Promise((resolve) => {
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: ajaxurl,
                        timeout: 300000, // 5 minutos de tiempo de espera
                        data: 
                        {
                            'action' : 'crear_xml_infocasas',
                            'id_usuario_infocasas' : usuarioInfocasas.user_id
                        },
                        beforeSend: function(){
                            $('#mensajes_infocasas').text('Creando y transfiriendo XML para inmobiliaria ID ' + usuarioInfocasas.user_id + '...');
                        },
                        success: function(response) 
                        {
                            // La respuesta de wp_send_json_* ya viene parseada por jQuery
                            console.log('Respuesta de crear_xml_infocasas:', response);
                            resolve(response);
                        },
                        error: function (jqXHR, textStatus, errorThrown) 
                        {
                            console.error('Error en la llamada AJAX:', textStatus, errorThrown);
                            // --- NUEVO: Imprimir la respuesta del servidor en caso de error ---
                            console.log('Respuesta del servidor (error):', jqXHR.responseText);
                            const respuesta = {
                                success: false,
                                data: { message: 'Hubo un error en la comunicación con el servidor.' }
                            }
                            resolve(respuesta);
                        }
                    });   
                });             
            }
            $(function() {
                $('#crear_xml_infocasas').on( 'click', function(event) 
                {
                    event.preventDefault();
                    buscarUsuariosInfocasas();
                    $('#mensajes_infocasas').text('Buscando los usuarios de Infocasas, por favor espere...');
                });
            });
        }    
    })(jQuery);
}
indexInfocasas();