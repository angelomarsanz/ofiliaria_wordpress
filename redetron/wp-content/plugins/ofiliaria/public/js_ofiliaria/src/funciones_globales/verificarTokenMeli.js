export const verificarTokenMeli = (ajaxurl) => { 
    return new Promise((resolve) => {
        (function( $ ) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: 
            {
                'action' : 'verificar_token_meli'
            },
            success: function(data) 
            {
                let codigo_retorno = data.codigo_retorno_token_meli;
                if ( codigo_retorno == 0) 
                {
                    let respuesta = {
                        codigo_respuesta : 0,
                        mensaje_respuesta : 'El usuario tiene token',
                        token_meli : data.token_meli_bd
                    }
                    resolve(respuesta);
                } 
                else if ( codigo_retorno == 1)  
                {
                    let respuesta = {
                        codigo_respuesta : 1,
                        mensaje_respuesta : 'El usuario no tiene rol de agencia o agente',
                        token_meli : 'El usuario no tiene rol de agencia o agente'
                    }
                    resolve(respuesta);
                }
                else if ( codigo_retorno == 2)  
                {
                    let respuesta = {
                        codigo_respuesta : 2,
                        mensaje_respuesta : 'El usuario no está asignado a una agencia agencia o agente',
                        token_meli : 'El usuario no está asignado a una agencia agencia o agente'
                    }
                    resolve(respuesta);
                }
                else if ( codigo_retorno == 3)  
                {
                    let respuesta = {
                        codigo_respuesta : 3,
                        mensaje_respuesta : 'El usuario no tiene token',
                        token_meli : 'El usuario no tiene token'
                    }
                    resolve(respuesta);
                }
                else
                {
                    let respuesta = {
                        codigo_respuesta : 4,
                        mensaje_respuesta : 'Debe refrescar el token',
                        token_meli : 'Debe refrescar el token',
                        refresh_token_meli : data.refresh_token_meli_bd,
                        usuario_duenio_token : data.usuario_duenio_token
                    }
                    resolve(respuesta);
                }
            },
            error: function (x, xs, xt) 
            {
                let respuesta = {
                    codigo_respuesta : 5,
                    mensaje_respuesta : 'Error en el servidor de Ofiliaria: ' + xt,
                    token_meli : 'Error en el servidor de Ofiliaria: ' + xt
                }
                console.log('error', JSON.stringify(x));
                resolve(respuesta);
            }
        });
        })(jQuery);
    });
  }