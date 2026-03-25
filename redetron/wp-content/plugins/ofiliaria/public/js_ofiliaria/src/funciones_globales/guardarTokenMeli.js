export const guardarTokenMeli = (accion, token_meli, refresh_token_meli, ajaxurl, usuario_duenio_token) => 
{
    
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
                'usuario_duenio_token' : usuario_duenio_token
            },
            success: function(data) 
            {
                if (accion == "obtener")
                {
                    $("#configuracion_conexion_meli").text("Felicidades has configurado correctamente tu conexión con Mercado Libre !");
                }
            },
            error: function (x, xs, xt) 
            {
                console.log('error', JSON.stringify(x));
            }
        });
    })(jQuery);
}