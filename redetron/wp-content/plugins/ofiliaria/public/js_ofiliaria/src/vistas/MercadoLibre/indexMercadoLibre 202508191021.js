import { 
    guardarTokenMeli,
    obtenerTokenMeli,
    refrescarTokenMeli,
    verificarTokenMeli } from "../../funciones_globales";

export const indexMercadoLibre = () => 
{
    (function( $ ) {
        if ($('#indexMercadoLibre').length > 0) 
        {
            var pathname = window.location.pathname;
            var url_base = window.location.hostname; 
            var ajaxurl = variables_php_javascript.ajax_url;
            var client_id_meli = variables_php_javascript.client_id_meli;
            var client_secret_meli = variables_php_javascript.client_secret_meli;
            var token_meli = "";
            var refresh_token_meli = ""; 
            var totalArchivosImportar = 0;
            var contadorArchivosImportados = 0;
            var totalPublicacionesProcesar = 0;
            var contadorPublicacionesEliminadas = 0;
            var publicacionesEliminadas = [];
            var contadorPublicacionesNoEliminadas = 0;
            var totalPublicacionesDescripcion = 0;
            var contadorPublicacionesDescripcion = 0;
            var contadorPublicacionesDescripcionNoActualizadas = 0;
            var mensajes_parametros = {
                "cambiar_agente": "No tiene parámetros",
                "reparar_tabla_imagenes": "No tiene parámetros",
                "eliminar_publicaciones_pausadas": "No tiene parámetros",
                "agregar_whatsapp": "No tiene parámetros",
                "verificar_datos_envio": "Por favor ingresar el ID de la categoría de Mercado Libre"
            };
    
            async function solicitarTokenML() {
                const respuestaObtenerTokenMeli = await obtenerTokenMeli(client_id_meli, client_secret_meli, $("#codigo_temporal").val(), url_base);
                if (respuestaObtenerTokenMeli.codigo_respuesta == 0)
                {
                    token_meli = respuestaObtenerTokenMeli.token_meli;
                    refresh_token_meli = respuestaObtenerTokenMeli.refresh_token_meli;
                    guardarTokenMeli('obtener', token_meli, refresh_token_meli, ajaxurl, 0);
                    console.log('indexMercadoLibre, solicitarTokenML, token_meli', token_meli);
                    console.log('indexMercadoLibre, solicitarTokenML, refresh_token_meli', refresh_token_meli);
                }
                else
                {
                    $("#configuracion_conexion_meli").text("Estimado usuario no se pudo obtener su token de Mercado Libre");
                }
            }

            async function buscarTokenBaseDatos() {
                const respuestaVerificarToken = await verificarTokenMeli(ajaxurl);
                token_meli = respuestaVerificarToken.token_meli;
                let usuario_duenio_token = respuestaVerificarToken.usuario_duenio_token;
                let codigo_respuesta = respuestaVerificarToken.codigo_respuesta;
                if (codigo_respuesta == 4)
                {
                    refresh_token_meli = respuestaVerificarToken.refresh_token_meli;
                    const respuestaRefrescarToken = await refrescarTokenMeli(client_id_meli, client_secret_meli, refresh_token_meli);
                    if (respuestaRefrescarToken.codigo_respuesta == 0)
                    {
                        token_meli = respuestaRefrescarToken.token_meli;
                        refresh_token_meli = respuestaRefrescarToken.refresh_token_meli;
                        guardarTokenMeli("refrescar", token_meli, refresh_token_meli, ajaxurl, usuario_duenio_token);
                        $("#configuracion_conexion_meli").text("Estimado usuario su conexión con Mercado Libre está activa");
                        $("#configurar_conexion_meli").hide();    
                    }    
                    else
                    {
                        $("#configuracion_conexion_meli").text("Estimado usuario no se pudo refrescar su token de Mercado Libre");
                    }
                }
                else
                {
                    otrosResultados(codigo_respuesta);
                }
                console.log('indexMercadoLibre, buscarTokenBaseDatos, token_meli', token_meli);
                console.log('indexMercadoLibre, buscarTokenBaseDatos, refresh_token_meli', refresh_token_meli);
            }  

            function otrosResultados(codigo_respuesta) 
            {
                if (codigo_respuesta == 0)
                {
                    $("#configuracion_conexion_meli").text(`¡ Estimado usuario su conexión con Mercado Libre está activa !`);
                    $("#configurar_conexion_meli").hide();
                }
                else if (codigo_respuesta == 1)
                {
                    $("#configuracion_conexion_meli").text("Estimado usuario por favor haga clic en el siguiente botón y será redirigido al sitio web de Mercado Libre para que autorice a OFILIARIA a publicar sus inmuebles automáticamente. Despúes será nuevamente redirigido a esta página");
                }
                else
                {
                    $("#configuracion_conexion_meli").text("Estimado usuario no se pudo verificar su token de Mercado Libre");
                }
            } 
            
            function importarPublicacionesMeli() {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: 
                    {
                        'action' : 'importar_publicaciones_meli'
                    },
                    success: function(data) 
                    {
                        console.log('importarPublicacionesMeli, data', data);
                        $('#mensajes_importacion_meli').text(data.mensaje);
                    },
                    error: function (x, xs, xt) 
                    {
                        console.log('error', JSON.stringify(x));
                    }
                });
            };

            function obtenerUrlArchivos() {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: 
                    {
                        'action' : 'obtener_url_archivos'
                    },
                    success: function(data) 
                    {
                        console.log('obtener_url_archivos, data', data);
                        importarArchivosMeli(data.url_archivos);
                    },
                    error: function (x, xs, xt) 
                    {
                        console.log('error', JSON.stringify(x));
                    }
                });
            };
            
            async function importarArchivosMeli(urlArchivos) {
                totalArchivosImportar = urlArchivos.length;
                for (let i = 0; i < urlArchivos.length; i++) 
                {
                    const respuestaImportarArchivo = await importarArchivoMeli(urlArchivos[i]);
                    if (respuestaImportarArchivo.codigo_retorno == 0)
                    {
                        contadorArchivosImportados++;
                        $('#mensajes_importacion_meli').text(`Importado(s) ${contadorArchivosImportados} archivo(s) de ${totalArchivosImportar}`);
                    }
                    else
                    {
                        $('#mensajes_importacion_meli').text(respuestaImportarArchivo.mensaje);
                    }
                }
            }
            
            function importarArchivoMeli(registroUrlArchivo)
            {
                return new Promise((resolve) => {
                    var respuesta = {};
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: ajaxurl,
                        data: 
                        {
                            'action' : 'importar_archivo_meli',
                            'id_url_archivo' : registroUrlArchivo.id,
                            'id_post_crm' : registroUrlArchivo.id_post_crm,
                            'url_imagen' : registroUrlArchivo.url_imagen,
                            'tipo_imagen' : registroUrlArchivo.tipo_imagen
                        },
                        beforeSend: function(){
                            console.log('importarArchivoMeli, registroUrlArchivo', registroUrlArchivo);
                        },
                        success: function(data) 
                        {
                            console.log('importarArchivoMeli, data', data);
                            resolve(data);
                        },
                        error: function (x, xs, xt) 
                        {
                            console.log('error', JSON.stringify(x));
                            respuesta = 
                            {
                                codigo_retorno : 2,
                                mensaje : 'Hubo un error en el servidor',
                                id_post_imagen : 0
                            };
                            resolve(respuesta);
                        }
                    });   
                });             
            }
            
            function asociarArchivosPublicacion() {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: 
                    {
                        'action' : 'asociar_archivos_publicacion'
                    },
                    success: function(data) 
                    {
                        console.log('asociarArchivosPublicacion, data', data);
                        $('#mensajes_importacion_meli').text(`Los archivos se asociaron correctamente a las publicaciones`);
                    },
                    error: function (x, xs, xt) 
                    {
                        console.log('error', JSON.stringify(x));
                    }
                });
            };

            function cambiarAgente() {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: 
                    {
                        'action' : 'cambiar_agente'
                    },
                    success: function(data) 
                    {
                        console.log('cambiarAgente, data', data);
                        $('#mensajes_importacion_meli').text(data.mensaje);
                    },
                    error: function (x, xs, xt) 
                    {
                        $('#mensajes_importacion_meli').text(`Hubo un error en el servidor`);
                        console.log('error', JSON.stringify(x));
                    }
                });
            };

            function repararTablaImagenes() {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: 
                    {
                        'action' : 'reparar_tabla_imagenes'
                    },
                    success: function(data) 
                    {
                        console.log('reparar_tabla_imagenes, data', data);
                        $('#mensajes_importacion_meli').text(data.mensaje);
                    },
                    error: function (x, xs, xt) 
                    {
                        console.log('error', JSON.stringify(x));
                    }
                });
            };

            function buscarPublicacionesOfiliaria() 
            {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: 
                    {
                        'action' : 'buscar_publicaciones_ofiliaria'
                    },
                    success: function(data) 
                    {
                        console.log('buscarPublicacionesOfiliaria, data', data);
                        $('#mensajes_importacion_meli').text(data.mensaje);
                        if (data.codigo_retorno == 0)
                        {
                            procesarPublicacionesOfiliaria(data.publicaciones_ofiliaria_meli, data.token_meli);
                        }
                    },
                    error: function (x, xs, xt) 
                    {
                        console.log('error', JSON.stringify(x));
                    }
                });
            };
            
            async function procesarPublicacionesOfiliaria(publicacionesOfiliariaMeli, tokenMeli) 
            {
                totalPublicacionesProcesar = publicacionesOfiliariaMeli.length;
                for (let i = 0; i < publicacionesOfiliariaMeli.length; i++)
                {
                    const respuestaProcesarPublicacion = await procesarPublicacionOfiliaria(publicacionesOfiliariaMeli[i], tokenMeli);
                    if (respuestaProcesarPublicacion.codigo_retorno == 0)
                    {
                        contadorPublicacionesEliminadas++;
                        $('#mensajes_importacion_meli').text(`Eliminada(s) ${contadorPublicacionesEliminadas} publicación(es) de ${totalPublicacionesProcesar}. ${respuestaProcesarPublicacion.mensaje}`);
                    }
                    else
                    {
                        contadorPublicacionesNoEliminadas++;
                        $('#mensajes_adicionales_meli').text(`No se han eliminado ${contadorPublicacionesNoEliminadas} publicación(es). ${respuestaProcesarPublicacion.mensaje}`);
                    }
                }
            }
            
            function procesarPublicacionOfiliaria(publicacionOfiliariaMeli, tokenMeli)
            {
                return new Promise((resolve) => {
                    var respuesta = {};
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: ajaxurl,
                        data: 
                        {
                            'action' : 'procesar_publicacion_ofiliaria',
                            'id_post' : publicacionOfiliariaMeli.id_post,
                            'id_meli' : publicacionOfiliariaMeli.id_meli,
                            'token_meli' : tokenMeli
                        },
                        beforeSend: function()
                        {
                            // 
                        },
                        success: function(data) 
                        {
                            console.log('procesarPublicacionOfiliaria, data', data);
                            resolve(data);
                        },
                        error: function (x, xs, xt) 
                        {
                            console.log('error', JSON.stringify(x));
                            respuesta = 
                            {
                                codigo_retorno : 3,
                                mensaje : 'Hubo un error en el servidor'
                            };
                            resolve(respuesta);
                        }
                    });   
                });             
            }

            function buscarPublicacionesDescripcion() 
            {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: 
                    {
                        'action' : 'buscar_publicaciones_descripcion'
                    },
                    success: function(data) 
                    {
                        console.log('buscarPublicacionesDescripcion, data', data);
                        $('#mensajes_importacion_meli').text(data.mensaje);
                        if (data.codigo_retorno == 0)
                        {
                            procesarPublicacionesDescripcion(data.ofiliaria_publicaciones_descripcion, data.token_meli, data.indicador_actualizar_descripcion);
                        }
                    },
                    error: function (x, xs, xt) 
                    {
                        console.log('error', JSON.stringify(x));
                    }
                });
            };
            
            async function procesarPublicacionesDescripcion(ofiliariaPublicacionesDescripcion, tokenMeli, indicadorActualizarDescripcion) 
            {
                totalPublicacionesDescripcion = ofiliariaPublicacionesDescripcion.length;
                for (let i = 0; i < ofiliariaPublicacionesDescripcion.length; i++)
                {
                    const respuestaProcesarPublicacionDescripcion = await procesarPublicacionDescripcion(ofiliariaPublicacionesDescripcion[i], tokenMeli, indicadorActualizarDescripcion);
                    if (respuestaProcesarPublicacionDescripcion.codigo_retorno == 0)
                    {
                        contadorPublicacionesDescripcion++;
                        $('#mensajes_importacion_meli').text(`Actualizadas(s) la descripción de ${contadorPublicacionesDescripcion} publicación(es) de ${totalPublicacionesDescripcion}. ${respuestaProcesarPublicacionDescripcion.mensaje}`);
                    }
                    else
                    {
                        contadorPublicacionesDescripcionNoActualizadas++;
                        $('#mensajes_adicionales_meli').text(`No se han actualizado ${contadorPublicacionesDescripcionNoActualizadas} publicación(es). ${respuestaProcesarPublicacionDescripcion.mensaje}`);
                    }
                }
            }
            
            function procesarPublicacionDescripcion(ofiliariaPublicacionDescripcion, tokenMeli, indicadorActualizarDescripcion)
            {
                return new Promise((resolve) => {
                    var respuesta = {};
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: ajaxurl,
                        data: 
                        {
                            'action' : 'procesar_publicacion_descripcion',
                            'id_post' : ofiliariaPublicacionDescripcion.id_post,
                            'id_meli' : ofiliariaPublicacionDescripcion.id_meli,
                            'id_autor' : ofiliariaPublicacionDescripcion.id_autor,
                            'token_meli' : tokenMeli,
                            'indicador_actualizar_descripcion' : indicadorActualizarDescripcion
                        },
                        beforeSend: function()
                        {
                            // 
                        },
                        success: function(data) 
                        {
                            console.log('procesarPublicacionDescripcion, data', data);
                            resolve(data);
                        },
                        error: function (x, xs, xt) 
                        {
                            console.log('error', JSON.stringify(x));
                            respuesta = 
                            {
                                codigo_retorno : 3,
                                mensaje : 'Hubo un error en el servidor'
                            };
                            resolve(respuesta);
                        }
                    });   
                });             
            }

            // Inicio utilitarios

            function eliminarIndicadorInfocasasPublicacionesImportadas() 
            {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: 
                    {
                        'action' : 'eliminar_indicador_infocasas_publicaciones_importadas'
                    },
                    success: function(data) 
                    {
                        console.log('utilitarioMeli, data', data);
                        $('#mensajes_importacion_meli').text(data.mensaje);
                    },
                    error: function (x, xs, xt) 
                    {
                        $('#mensajes_importacion_meli').text('Hubo un error en el servidor');
                        console.log('error', JSON.stringify(x));
                    }
                });
            };

            function buscarPublicacionesImportadasMeli() 
            {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: 
                    {
                        'action' : 'buscar_publicaciones_importadas_meli'
                    },
                    success: function(data) 
                    {
                        console.log('buscarPublicacionesImportadasMeli, data', data);
                        $('#mensajes_importacion_meli').text(data.mensaje);
                        if (data.codigo_retorno == 0)
                        {
                            procesarPublicacionesImportadasMeli(data.publicaciones_importadas_meli, data.token_meli, data.indicador_agregar_permalink);
                        }
                    },
                    error: function (x, xs, xt) 
                    {
                        console.log('error', JSON.stringify(x));
                    }
                });
            };
            
            async function procesarPublicacionesImportadasMeli(publicacionesImportadasMeli, tokenMeli, indicadorAgregarPermalink) 
            {
                var totalPublicacionesImportadasMeli = publicacionesImportadasMeli.length;
                var contadorPublicacionesAgregadoPermalink = 0;
                var contadorPublicacionesNoAgregadoPermalink = 0;
                for (let i = 0; i < publicacionesImportadasMeli.length; i++)
                {
                    const respuestaProcesarPublicacionImportadaMeli = await procesarPublicacionImportadaMeli(publicacionesImportadasMeli[i], tokenMeli, indicadorAgregarPermalink);
                    if (respuestaProcesarPublicacionImportadaMeli.codigo_retorno == 0)
                    {
                        contadorPublicacionesAgregadoPermalink++;
                        $('#mensajes_importacion_meli').text(`Agregado el permalink de ${contadorPublicacionesAgregadoPermalink} publicación(es) de ${totalPublicacionesImportadasMeli}. ${respuestaProcesarPublicacionImportadaMeli.mensaje}`);
                    }
                    else
                    {
                        contadorPublicacionesNoAgregadoPermalink++;
                        $('#mensajes_adicionales_meli').text(`No se ha agregado el permalink a ${contadorPublicacionesNoAgregadoPermalink} publicación(es). ${respuestaProcesarPublicacionImportadaMeli.mensaje}`);
                    }
                }
            }
            
            function procesarPublicacionImportadaMeli(publicacionImportadaMeli, tokenMeli, indicadorAgregarPermalink)
            {
                return new Promise((resolve) => {
                    var respuesta = {};
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: ajaxurl,
                        data: 
                        {
                            'action' : 'procesar_publicacion_importada_meli',
                            'id_post' : publicacionImportadaMeli.id_post,
                            'id_meli' : publicacionImportadaMeli.id_meli,
                            'id_autor' : publicacionImportadaMeli.id_autor,
                            'token_meli' : tokenMeli,
                            'indicador_agregar_permalink' : indicadorAgregarPermalink
                        },
                        beforeSend: function()
                        {
                            // 
                        },
                        success: function(data) 
                        {
                            console.log('procesarPublicacionImportadaMeli, data', data);
                            resolve(data);
                        },
                        error: function (x, xs, xt) 
                        {
                            console.log('error', JSON.stringify(x));
                            respuesta = 
                            {
                                codigo_retorno : 3,
                                mensaje : 'Hubo un error en el servidor'
                            };
                            resolve(respuesta);
                        }
                    });   
                });             
            }

            function buscarPublicacionesRedimensionImagenesMeli() 
            {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: 
                    {
                        'action' : 'buscar_publicaciones_redimension_imagenes_meli'
                    },
                    success: function(data) 
                    {
                        console.log('buscarPublicacionesRedimensionImagenesMeli, data', data);
                        $('#mensajes_importacion_meli').text(data.mensaje);
                        if (data.codigo_retorno == 0)
                        {
                            procesarPublicacionesRedimensionImagenesMeli(data);
                        }
                    },
                    error: function (x, xs, xt) 
                    {
                        console.log('error', JSON.stringify(x));
                    }
                });
            };
            
            async function procesarPublicacionesRedimensionImagenesMeli(data) 
            {
                var totalPublicacionesRedimensionImagenesMeli = data.publicaciones_redimension_imagenes_meli.length;
                var contadorPublicacionesRedimensionImagenesMeli = 0;
                var contadorPublicacionesNoRedimensionImagenesMeli = 0;
                for (let i = 0; i < data.publicaciones_redimension_imagenes_meli.length; i++)
                {
                    /*if (data.publicaciones_redimension_imagenes_meli[i].id_post > 13785 &&
                        data.publicaciones_redimension_imagenes_meli[i].id_post < 16749 )
                    {*/
                        const respuestaProcesarPublicacionRedimensionImagenesMeli = await procesarPublicacionRedimensionImagenesMeli(data.id_agencia_agente, data.publicaciones_redimension_imagenes_meli[i]);
                        if (respuestaProcesarPublicacionRedimensionImagenesMeli.codigo_retorno == 0)
                        {
                            contadorPublicacionesRedimensionImagenesMeli++;
                            $('#mensajes_importacion_meli').text(`Redimensionadas las imágenes de ${contadorPublicacionesRedimensionImagenesMeli} publicación(es) de ${totalPublicacionesRedimensionImagenesMeli}. ${respuestaProcesarPublicacionRedimensionImagenesMeli.mensaje}`);
                        }
                        else
                        {
                            contadorPublicacionesNoRedimensionImagenesMeli++;
                            $('#mensajes_adicionales_meli').text(`No redimensionadas las imágenes de a ${contadorPublicacionesNoRedimensionImagenesMeli} publicación(es). ${respuestaProcesarPublicacionRedimensionImagenesMeli.mensaje}`);
                        }
                    //}   
                }
            }
            
            function procesarPublicacionRedimensionImagenesMeli(idAgenciaAgente, publicacionRedimensionImagenesMeli)
            {
                return new Promise((resolve) => {
                    var respuesta = {};
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: ajaxurl,
                        data: 
                        {
                            'action' : 'procesar_publicacion_redimension_imagenes_meli',
                            'id_agencia_agente' : idAgenciaAgente,
                            'id_post' : publicacionRedimensionImagenesMeli.id_post,
                            'id_meli' : publicacionRedimensionImagenesMeli.id_meli,
                            'id_autor' : publicacionRedimensionImagenesMeli.id_autor,
                            'target_width' : 800, 
		                    'target_height' : 600
                        },
                        beforeSend: function()
                        {
                            // 
                        },
                        success: function(data) 
                        {
                            console.log('procesarPublicacionRedimensionImagenesMeli, data', data);
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

            function buscarPublicacionesAgregarWhatsapp() 
            {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: 
                    {
                        'action' : 'buscar_publicaciones_agregar_whatsapp'
                    },
                    success: function(data) 
                    {
                        console.log('buscarPublicacionesAgregarWhatsapp, data', data);
                        $('#mensajes_importacion_meli').text(data.mensaje);
                        if (data.codigo_retorno == 0)
                        {
                            procesarPublicacionesAgregarWhatsapp(data);
                        }
                    },
                    error: function (x, xs, xt) 
                    {
                        console.log('error', JSON.stringify(x));
                    }
                });
            };
            
            async function procesarPublicacionesAgregarWhatsapp(data) 
            {
                var totalPublicacionesAgregarWhatsapp = data.publicaciones_agregar_whatsapp.length;
                var contadorPublicacionesWhatsappAgregado = 0;
                var contadorPublicacionesWhatsappNoAgregado = 0;
                for (let i = 0; i < data.publicaciones_agregar_whatsapp.length; i++)
                {
                    /*if (data.publicaciones_agregar_whatsapp[i].id_post > 13785)
                    {*/
                        const respuestaProcesarPublicacionAgregarWhatsapp = await procesarPublicacionAgregarWhatsapp(data.id_agencia_agente, data.token_meli, data.publicaciones_agregar_whatsapp[i]);
                        if (respuestaProcesarPublicacionAgregarWhatsapp.codigo_retorno == 0)
                        {
                            contadorPublicacionesWhatsappAgregado++;
                            $('#mensajes_importacion_meli').text(`Se agregó el Whatsapp a de ${contadorPublicacionesWhatsappAgregado} publicación(es) de ${totalPublicacionesAgregarWhatsapp}. ${respuestaProcesarPublicacionAgregarWhatsapp.mensaje}`);
                        }
                        else
                        {
                            contadorPublicacionesWhatsappNoAgregado++;
                            $('#mensajes_adicionales_meli').text(`No se agregó el Whatsapp a ${contadorPublicacionesWhatsappNoAgregado} publicación(es). ${respuestaProcesarPublicacionAgregarWhatsapp.mensaje}`);
                        }
                    //}   
                }
            }
            
            function procesarPublicacionAgregarWhatsapp(idAgenciaAgente, tokenMeli, publicacionAgregarWhatsapp)
            {
                return new Promise((resolve) => {
                    var respuesta = {};
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: ajaxurl,
                        data: 
                        {
                            'action' : 'procesar_publicacion_agregar_whatsapp',
                            'id_agencia_agente' : idAgenciaAgente,
                            'token_meli' : tokenMeli,
                            'id_post' : publicacionAgregarWhatsapp.id_post,
                            'id_meli' : publicacionAgregarWhatsapp.id_meli,
                            'id_autor' : publicacionAgregarWhatsapp.id_autor,
                        },
                        beforeSend: function()
                        {
                            // 
                        },
                        success: function(data) 
                        {
                            console.log('procesarPublicacionAgregarWhatsapp, data', data);
                            resolve(data);
                        },
                        error: function (x, xs, xt) 
                        {
                            console.log('error', JSON.stringify(x));
                            respuesta = 
                            {
                                codigo_retorno : 9,
                                mensaje : 'Hubo un error en el servidor'
                            };
                            resolve(respuesta);
                        }
                    });   
                });             
            }

            function verificarDatosEnvioPublicacionesMeli(idCategoria) 
            {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: 
                    {
                        'action' : 'verificar_datos_envio_publicaciones_meli',
                        'id_categoria' : idCategoria
                    },
                    beforeSend: function(){
                        $('#mensajes_utilitarios_meli').html('<div class="alert alert-info">Función verificarDatosEnvioPublicacionesMeli() llamada con ID de categoría: <strong>' + idCategoria + '</strong></div>');
                        console.log('verificarDatosEnvioPublicacionesMeli, idCategoria', idCategoria);
                    },
                    success: function(data) 
                    {
                        console.log('verificarDatosEnvioPublicacionesMeli, data', data);
                        $('#mensajes_utilitarios_meli').html(`<div class="alert alert-info">${data.mensaje}</div>`);
                    },
                    error: function (x, xs, xt) 
                    {
                        $('#mensajes_utilitarios_meli').html(`<div class="alert alert-danger">Hubo un error en el servidor</div>`);
                        console.log('error', JSON.stringify(x));
                    }
                });
            }

            // Fin utilitarios

            $(function() {
                if ($("#codigo_temporal").val() != "error")
                {
                    console.log('indexMercadoLibre, ir a solicitarTokenML');
                    solicitarTokenML();
                }
                else
                {
                    console.log('indexMercadoLibre, ir a buscarTokenBaseDatos');
                    buscarTokenBaseDatos();
                }  
                $('#opcion_configurar_conexion_meli').on( 'click', function(event) 
                {
                    event.preventDefault();
                    location.href ="https://auth.mercadolibre.com.uy/authorization?response_type=code&client_id="+client_id_meli+"&redirect_uri=https://"+url_base+"/mercadolibre";
                });
                $('#importar_publicaciones_meli').on( 'click', function(event) 
                {
                    event.preventDefault();
                    importarPublicacionesMeli();
                    $('#mensajes_importacion_meli').text('Importando publicaciones, por favor espere...');
                });
                $('#importar_descripcion_publicaciones_meli').on( 'click', function(event) 
                {
                    event.preventDefault();
                    buscarPublicacionesDescripcion();
                    $('#mensajes_importacion_meli').text('Buscando publicaciones para importar la descripción, por favor espere...');
                });
                $('#importar_archivos_meli').on( 'click', function(event) 
                {
                    event.preventDefault();
                    obtenerUrlArchivos();
                    $('#mensajes_importacion_meli').text('Enviando archivos, por favor espere...');
                });
                $('#asociar_archivos_publicacion_meli').on( 'click', function(event) 
                {
                    event.preventDefault();
                    asociarArchivosPublicacion();
                    $('#mensajes_importacion_meli').text('Asociando los archivos, por favor espere...');
                });
                $('#redimensionar_imagenes_meli').on( 'click', function(event) 
                {
                    event.preventDefault();
                    buscarPublicacionesRedimensionImagenesMeli();
                    $('#mensajes_importacion_meli').text('Buscando las imágenes a redimensionar, por favor espere...');
                });

                // Mostrar mensaje de parámetros al seleccionar una opción
                $('#utilitarios_meli').change(function() {
                    var selectedOption = $(this).val();
                    var mensaje = mensajes_parametros[selectedOption];
                    if (mensaje) {
                        $('#mensaje_parametros').text(mensaje).fadeIn();
                    } else {
                        $('#mensaje_parametros').fadeOut();
                    }
                });

                // Función on.click para el botón enviar
                $('#enviar_utilitario_meli').on('click', function() {
                    var opcionSeleccionada = $('#utilitarios_meli').val();
                    var parametros = $('#parametros_meli').val();

                    // Limpiar mensajes anteriores
                    $('#mensajes_utilitarios_meli').empty();
                    $('#mensajes_adicionales_utilitarios_meli').empty();

                    switch (opcionSeleccionada) {
                        case 'cambiar_agente':
                            cambiarAgente();
                            break;
                        case 'reparar_tabla_imagenes':
                            repararTablaImagenes();
                            break;
                        case 'eliminar_publicaciones_pausadas':
                            buscarPublicacionesOfiliaria();
                            break;
                        case 'agregar_whatsapp':
                            buscarPublicacionesAgregarWhatsapp();
                            break;
                        case 'verificar_datos_envio':
                            // Aquí asumimos que verificarDatosEnvioPublicacionesMeli espera el ID de la categoría como parámetro
                            // Si necesitas procesar los parámetros de otra forma (ej. separarlos por coma), lo podemos ajustar.
                            verificarDatosEnvioPublicacionesMeli(parametros); 
                            break;
                        default:
                            $('#mensajes_utilitarios_meli').html('<div class="alert alert-warning">Por favor, seleccione una opción válida.</div>');
                            break;
                    }
                });
            });
        }    
    })(jQuery);
}
indexMercadoLibre();