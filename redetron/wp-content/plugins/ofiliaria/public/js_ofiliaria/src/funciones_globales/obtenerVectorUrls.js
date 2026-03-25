export const obtenerVectorUrls = (ajaxurl) => {
    return new Promise((resolve) => {
        (function( $ ) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxurl,
                data: 
                {
                    'action' : 'guardar_token_meli',
                    'token' : token_meli,
                    'refresh_token' : refresh_token_meli,
                },
                success: function(data) 
                {
                    let respuesta = 
                        {
                            codigo_respuesta : 0,
                            mensaje_respuesta : 'Proceso exitoso',
                            token_meli : data.access_token,
                            refresh_token_meli : data.refresh_token
                        };
                    resolve(respuesta);
                },
                error: function (x, xs, xt) 
                {
                    let respuesta = 
                        {
                            codigo_respuesta : 1,
                            mensaje_respuesta : 'Error en el servidor',
                            token_meli : 'Error en el servidor',
                            refresh_token_meli : 'Error en el servidor'
                    }
                    console.log('error', JSON.stringify(x));
                    resolve(respuesta);
                }
            });

        })(jQuery);
    });
}