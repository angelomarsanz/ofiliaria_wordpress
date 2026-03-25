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
                    for (let i = 0; i < usuariosInfocasas.length; i++) {
                        const respuestaCrearXmlInfocasas = await crearXmlInfocasas(usuariosInfocasas[i]);
                        $('#mensajes_infocasas').text(respuestaCrearXmlInfocasas.mensaje);
                    }
                } else {
                    // Si la URL es diferente, ejecutar el bucle para los primeros 2 elementos
                    for (let i = 0; i < 2; i++) {
                        const respuestaCrearXmlInfocasas = await crearXmlInfocasas(usuariosInfocasas[i]);
                        $('#mensajes_infocasas').text(respuestaCrearXmlInfocasas.mensaje);
                    }
                }
            }
            
            function crearXmlInfocasas(usuarioInfocasas)
            {
                return new Promise((resolve) => {
                    var respuesta = {};
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: ajaxurl,
                        data: 
                        {
                            'action' : 'crear_xml_infocasas',
                            'id_usuario_infocasas' : usuarioInfocasas.user_id
                        },
                        beforeSend: function(){
                            console.log('crearXmlInfocasas, antes, id_usuario_infocasas', usuarioInfocasas.user_id);
                        },
                        success: function(data) 
                        {
                            console.log('crearXmlInfocasas, data', data);
                            resolve(data);
                        },
                        error: function (x, xs, xt) 
                        {
                            console.log('error', JSON.stringify(x));
                            respuesta = 
                            {
                                codigo_retorno : 2,
                                mensaje : 'Hubo un error en el servidor'
                            };
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