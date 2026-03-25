export const obtenerTokenMeli = (client_id_meli, client_secret_meli, codigo_temporal, url_base) => {
    return new Promise((resolve) => {
        (function( $ ) {
            $.ajax({
                url: 'https://api.mercadolibre.com/oauth/token',
                type: 'POST',
                headers : 
                {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "accept": "application/json",
                },
                dataType: 'json',
                data: "grant_type=authorization_code&client_id="+client_id_meli+"&client_secret="+client_secret_meli+"&code="+codigo_temporal+"&redirect_uri=https://"+url_base+"/mercadolibre",
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
                error: function(xhr, status, errorThrown) {
                    var errorResponse = JSON.parse(xhr.responseText);
                    console.error("Error en la autorización:", errorResponse.error);
                    console.error("Mensaje:", errorResponse.message);
                    let respuesta = 
                        {
                            codigo_respuesta : 1,
                            error : errorResponse.error,
                            mensaje_error : errorResponse.message,
                        }
                        resolve(respuesta);
                }
            });

        })(jQuery);
    });
}