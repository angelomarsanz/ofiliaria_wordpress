export const errorTokenMeli = (error_token_meli, mensaje_error_token_meli, ajaxurl) => 
{
    (function( $ ) {
        console.log('En errorTokenMeli');
        console.log('error_token_meli:', error_token_meli);
        console.log('mensaje_error_token_meli:', mensaje_error_token_meli);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: 
            {
                'action' : 'error_token_meli',
                'error_token_meli' : error_token_meli,
                'mensaje_error_token_meli' : mensaje_error_token_meli
            },
            beforeSend: function() {
                console.log('Enviando error y mensaje del token Meli al servidor...');
            },
            success: function(data) 
            {
                console.log('El error y mensaje del token Meli se guardaron correctamente en la base de datos');
            },
            error: function (x, xs, xt) 
            {
                console.log('error', JSON.stringify(x));
            }
        });
    })(jQuery);
}