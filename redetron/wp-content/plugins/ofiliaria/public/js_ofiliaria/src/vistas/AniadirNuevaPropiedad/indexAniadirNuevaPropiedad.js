import { 
    verificarTokenMeli,
    refrescarTokenMeli,
    guardarTokenMeli,
    errorTokenMeli } from "../../funciones_globales";

export const indexAniadirNuevaPropiedad = () => 
{
    (function( $ ) {
        if ($('#indexAniadirNuevaPropiedad').length > 0) 
        {
            var pathname = window.location.pathname;
            var url_base = window.location.hostname; 
            var ajaxurl = variables_php_javascript.ajax_url;
            var client_id_meli = variables_php_javascript.client_id_meli;
            var client_secret_meli = variables_php_javascript.client_secret_meli;
            var token_meli = "";
            var refresh_token_meli = ""; 
            var error_token_meli = "";
            var mensaje_error_token_meli = "";
            var campos_meli = 
                [
                    'property_size',
                    'property_lot_size',
                    'property_rooms',
                    'property_bedrooms',
                    'property_bathrooms',
                    '_ofiliaria_superficie_de_balcon',
                    'estacionamiento',
                    '_ofiliaria_acceso_lote_terreno',
                    '_ofiliaria_bodegas', 
                    '_ofiliaria_huespedes',
                    '_ofiliaria_horario_de_contacto',
                    '_ofiliaria_cantidad_de_pisos',
                    '_ofiliaria_numero_del_apartamento',
                    '_ofiliaria_apartamentos_por_piso',
                    '_ofiliaria_numero_de_piso_de_la_unidad',
                    '_ofiliaria_tipo_de_departamento',
                    '_ofiliaria_disposicion',
                    '_ofiliaria_orientacion',
                    '_ofiliaria_anio_construccion_de_la_propiedad',
                    '_ofiliaria_antiguedad',
                    '_ofiliaria_codigo_de_la_propiedad',
                    '_ofiliaria_camas',
                    '_ofiliaria_admite_mascotas',
                    '_ofiliaria_amoblado',
                    '_ofiliaria_ambientes',
                    '_ofiliaria_numero_de_la_casa',
                    '_ofiliaria_tipo_de_casa',
                    '_ofiliaria_superficie_de_terreno',
                    '_ofiliaria_parrillero',
                    '_ofiliaria_uso_comercial',
                    '_ofiliaria_tipo_de_campo',
                    '_ofiliaria_distancia_al_asfalto',
                    '_ofiliaria_forma_del_terreno',
                    '_ofiliaria_superficie_cubierta_del_casco',
                    '_ofiliaria_banio_social',
                    '_ofiliaria_dormitorio_de_servicio',
                    '_ofiliaria_piscina',
                    '_ofiliaria_terraza',
                    '_ofiliaria_adicional_servicios_acceso_a_internet',
                    '_ofiliaria_adicional_servicios_gas_natural',
                    '_ofiliaria_adicional_servicios_linea_telefonica',
                    '_ofiliaria_adicional_servicios_tv_por_cable',
                    '_ofiliaria_adicional_servicios_aire_acondicionado',
                    '_ofiliaria_adicional_servicios_calefaccion',
                    '_ofiliaria_adicional_servicios_agua_corriente',
                    '_ofiliaria_adicional_servicios_caldera_a_gas_electrica',
                    '_ofiliaria_adicional_servicios_con_energia_solar',
                    '_ofiliaria_adicional_servicios_con_conexion_para_lavarropas',
                    '_ofiliaria_adicional_servicios_grupo_electrogeno',
                    '_ofiliaria_adicional_servicios_con_tv_satelital',
                    '_ofiliaria_adicional_servicios_jardinero',
                    '_ofiliaria_adicional_servicios_luz_electrica',
                    '_ofiliaria_adicional_servicios_saneamiento',
                    '_ofiliaria_adicional_comodidades_equipamiento_ascensor',
                    '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol',
                    '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle',
                    '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis',
                    '_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol',
                    '_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva',
                    '_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples',
                    '_ofiliaria_adicional_comodidades_equipamiento_chimenea',
                    '_ofiliaria_adicional_comodidades_equipamiento_con_area_verde',
                    '_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas',
                    '_ofiliaria_adicional_comodidades_equipamiento_gimnasio',
                    '_ofiliaria_adicional_comodidades_equipamiento_heladera',
                    '_ofiliaria_adicional_comodidades_equipamiento_jacuzzi',
                    '_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas',
                    '_ofiliaria_adicional_comodidades_equipamiento_sauna',
                    '_ofiliaria_adicional_comodidades_equipamiento_area_de_cine',
                    '_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles',
                    '_ofiliaria_adicional_comodidades_equipamiento_cisterna',
                    '_ofiliaria_adicional_comodidades_equipamiento_cowork',
                    '_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas',
                    '_ofiliaria_adicional_comodidades_equipamiento_recepcion',
                    '_ofiliaria_adicional_comodidades_equipamiento_bebederos',
                    '_ofiliaria_adicional_comodidades_equipamiento_casco',
                    '_ofiliaria_adicional_comodidades_equipamiento_corral',
                    '_ofiliaria_adicional_comodidades_equipamiento_galpon',
                    '_ofiliaria_adicional_comodidades_equipamiento_molinos',
                    '_ofiliaria_adicional_comodidades_equipamiento_silos',
                    '_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua',
                    '_ofiliaria_adicional_comodidades_equipamiento_lavarropa',
                    '_ofiliaria_adicional_comodidades_equipamiento_microondas',
                    '_ofiliaria_adicional_comodidades_equipamiento_tv',
                    '_ofiliaria_adicional_comodidades_equipamiento_vajilla',
                    '_ofiliaria_adicional_seguridad_alarma',
                    '_ofiliaria_adicional_seguridad_porton_automatico',
                    '_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad',
                    '_ofiliaria_adicional_seguridad_tipo_de_seguridad',
                    '_ofiliaria_adicional_seguridad_acceso_controlado',
                    '_ofiliaria_adicional_seguridad_con_barrio_cerrado',
                    '_ofiliaria_adicional_ambientes_altillo',
                    '_ofiliaria_adicional_ambientes_balcon',
                    '_ofiliaria_adicional_ambientes_cocina',
                    '_ofiliaria_adicional_ambientes_comedor',
                    '_ofiliaria_adicional_ambientes_dormitorio_en_suite',
                    '_ofiliaria_adicional_ambientes_estudio',
                    '_ofiliaria_adicional_ambientes_living',
                    '_ofiliaria_adicional_ambientes_patio',
                    '_ofiliaria_adicional_ambientes_placards',
                    '_ofiliaria_adicional_ambientes_cuarto_de_juegos',
                    '_ofiliaria_adicional_ambientes_con_lavadero',
                    '_ofiliaria_adicional_ambientes_vestidor',
                    '_ofiliaria_adicional_ambientes_desayunador',
                    '_ofiliaria_adicional_ambientes_jardin',
                    '_ofiliaria_sobre',
                    '_ofiliaria_vivienda_social',
                    '_ofiliaria_estado',
                    '_ofiliaria_m2_terraza_propiedad',
                    '_ofiliaria_acepta_permuta',
                    '_ofiliaria_cantidad_plantas_propiedad',
                    '_ofiliaria_gastos_comunes_propiedad',
                    '_ofiliaria_moneda_gastos_comunes',
                    '_ofiliaria_horario_check_in',
                    '_ofiliaria_horario_check_out',
                    '_ofiliaria_servicio_de_desayuno',
                    '_ofiliaria_servicio_de_limpieza',
                    '_ofiliaria_estadia_minima_noches',
                    '_ofiliaria_adicional_comodidades_equipamiento_numero_de_torre',
                    '_ofiliaria_apto_para_oficina',
                ];
            var campos_numericos = 
                [
                    '_ofiliaria_superficie_de_balcon',
                    'estacionamiento',
                    '_ofiliaria_bodegas', 
                    '_ofiliaria_huespedes',
                    '_ofiliaria_cantidad_de_pisos',
                    '_ofiliaria_apartamentos_por_piso',
                    '_ofiliaria_anio_construccion_de_la_propiedad',
                    '_ofiliaria_antiguedad',
                    '_ofiliaria_camas',
                    '_ofiliaria_ambientes', 
                    '_ofiliaria_superficie_de_terreno',
                    '_ofiliaria_distancia_al_asfalto',
                    '_ofiliaria_superficie_cubierta_del_casco',
                    '_ofiliaria_numero_de_piso_de_la_unidad',
                    '_ofiliaria_m2_terraza_propiedad',
                    '_ofiliaria_cantidad_plantas_propiedad',
                    '_ofiliaria_gastos_comunes_propiedad',
                    '_ofiliaria_estadia_minima_noches',
                ];

            // Funciones de filtrado para provincia->ciudad y ciudad->área
            // Ejecutan un filtrado inicial al cargar la página si ya hay valores seleccionados
            const wpestate_filter_city_area_select = (citySelectorId = 'property_city_submit', areaSelectorId = 'property_area_submit') => {
                const citySelector = '#' + citySelectorId;
                const areaSelector = '#' + areaSelectorId;

                // Si no existen los selects no hacemos nada
                if (jQuery(citySelector).length === 0 || jQuery(areaSelector).length === 0) {
                    return;
                }

                const ciudadActual = jQuery(citySelector).val();
                if (ciudadActual && ciudadActual !== '-1' && ciudadActual !== 'none') 
                {
                    // Recorrer citySelector y ocultar aquellas áreas que no pertenezcan a la ciudad seleccionada
                    jQuery(areaSelector + ' option').each(function() {
                        const area_parentcity = jQuery(this).attr('data-parentcity') || '';
                        if (area_parentcity !== ciudadActual && area_parentcity !== 'all' && area_parentcity !== 'none') {
                            jQuery(this).hide();
                        }                               
                    });
                }  
            };


            const wpestate_filter_county_city_select = (countySelectorId = 'property_county', citySelectorId = 'property_city_submit') => {
                const countySelector = '#' + countySelectorId;
                const citySelector = '#' + citySelectorId;

                if (jQuery(countySelector).length === 0 || jQuery(citySelector).length === 0) {
                    return;
                }

                // Filtrado inicial si ya hay provincia seleccionada (editar publicación)
                const provinciaActual = jQuery(countySelector).val();
                if (provinciaActual && provinciaActual !== '-1' && provinciaActual !== 'none') {
                    // Recorrer citySelector y ocultar aquellas ciudades que no pertenezcan a la provincia seleccionada
                    jQuery(citySelector + ' option').each(function() {
                        const city_parentcounty = jQuery(this).attr('data-parentcounty') || '';
                        if (city_parentcounty !== provinciaActual && city_parentcounty !== 'all' && city_parentcounty !== 'none') {
                            jQuery(this).hide();
                        }
                    });
                }
            };

            const excepcionesTipoSeguridad =
                {
                    '2096-2100' : '24 horas',
                    '2095-2100' : '24 horas',
                    '2095-2102' : '24 horas'
                };

            var gifEspere =
                `<img src='https://dev-backend.ofiliaria.com/public/imagenes/loading.gif' 
                alt='Por favor espere' style="width: 90px; height: 90px" />`;

            var conectandoConMeli = 
                `<div class="alert alert-info alert-dismissible">
                    Estamos tratando de conectarnos con Mercado Libre.
                </div>`;

            var tokenMeliExitoso =
                `<div class="alert alert-success alert-dismissible">
                    Su token para la conexión con Mercado Libre se obtuvo exitosamente.
                </div>`;

            var tokenVencido =
                `<div class="alert alert-warning alert-dismissible">
                    Su token está vencido. Estamos intentando refrescarlo para usted.
                </div>`;
            
            var verificandoPublicacionMeli = 
                `<div class="alert alert-info alert-dismissible">
                    Estamos verificando el estado de su publicación en Mercado Libre.
                </div>`;

            var republicarMeli =
                `<div class="alert alert-warning alert-dismissible">
                    Su publicación en Mercado Libre se encuentra cerrada. Puede marcar la casilla para volver a publicarla.
                </div>`;

            var verificacionExitosaPublicacionMeli = 
                `<div class="alert alert-success alert-dismissible">
                    Se verificó exitosamente el estado de su publicación en Mercado Libre. Puede seguir editando su propiedad o marcar la casilla para sincronizarla con Mercado Libre si aún no lo ha hecho.
                </div>`;
                
            var contenidoPublicarMeli = 
                `<input type="checkbox" id="ofiliaria_publicar_meli" name="ofiliaria_publicar_meli" ${$("#check_ofiliaria_publicar_meli").val()}>
                <label class="checklabel" for="ofiliaria_publicar_meli">Sincronizar con Mercado Libre</label>
                <br /><br />`;

            var contenidoRepublicarMeli = 
                `<input type="checkbox" id="ofiliaria_republicar_meli" name="ofiliaria_republicar_meli" ?>
                <label class="checklabel" for="ofiliaria_republicar_meli">Republicar en Mercado Libre</label>
                <br /><br />`;

            function obtenerPublicacionMeli(tokenMeli, idPublicacionMeli)
            {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: 
                    {
                        'action' : 'obtener_publicacion_meli',
                        'token_meli' : tokenMeli,
                        'id_publicacion_meli' : idPublicacionMeli
                    },
                    beforeSend: function() 
                    {
                        $("#div_ofiliaria_publicar_meli").html(gifEspere);
                        $("#mensajes_generales").html(verificandoPublicacionMeli);
                    },
                    success: function(data) 
                    {
                        if (data.codigo_retorno == 0)
                        {
                            $("#estatus_publicacion_meli").val(data.vector_publicacion_meli.status);
                            if (data.vector_publicacion_meli.status == 'closed')
                            {
                                $("#div_ofiliaria_publicar_meli").html('');
                                $("#mensajes_generales").html(republicarMeli);
                                $("#div_ofiliaria_republicar_meli").html(contenidoRepublicarMeli);
                            }
                            else
                            {
                                $("#div_ofiliaria_publicar_meli").html(contenidoPublicarMeli);
                                $("#mensajes_generales").html(verificacionExitosaPublicacionMeli);
                            }
                        }
                        else
                        {
                            $("#div_ofiliaria_publicar_meli").html('');
                            let noSePudoVerificarPublicacionMeli = 
                                `<div class="alert alert-danger alert-dismissible">
                                    No se pudo verificar el estado de su publicación en Mercado Libre. Por los siguientes motivos: <br />
                                    - Código de retorno: ${data.codigo_retorno} <br />
                                    - Mensaje ${data.mensaje} <br />
                                    - Error devuelto por Mercado Libre: ${data.error_meli} <br />
                                    - Estatus devuelto por Mercado Libre: ${data.estatus_meli} <br />
                                </div>`;

                            $("#mensajes_generales").html(noSePudoVerificarPublicacionMeli);
                        }
                    },
                    error: function (x, xs, xt) 
                    {
                        console.log('error', JSON.stringify(x));
                        $("#div_ofiliaria_publicar_meli").html('');
                        let errorVerificacionPublicacionMeli = 
                            `<div class="alert alert-danger alert-dismissible">
                                No se pudo obtener el estado de su publicación en Mercado Libre por los siguientes errores técnicos en el servidor de Ofiliaria: <br />
                                - ${xt} <br />
                                - ${JSON.stringify(x)} <br />
                            </div>`;
                        $("#mensajes_generales").html(errorVerificacionPublicacionMeli);
                    }
                });
            }
    
            async function obtenerTokenMeliAP() {
                $("#div_ofiliaria_publicar_meli").html(gifEspere);
                $("#mensajes_generales").html(conectandoConMeli);
                const respuestaVerificarToken = await verificarTokenMeli(ajaxurl);
                token_meli = respuestaVerificarToken.token_meli;
                if (respuestaVerificarToken.codigo_respuesta == 0)
                {
                    mostrarInputCheckMeli();
                    $("#mensajes_generales").html(tokenMeliExitoso);
                }
                else if (respuestaVerificarToken.codigo_respuesta == 4)
                {
                    $("#mensajes_generales").html(tokenVencido);
                    refresh_token_meli = respuestaVerificarToken.refresh_token_meli;
                    let usuario_duenio_token = respuestaVerificarToken.usuario_duenio_token;
                    const respuestaRefrescarToken = await refrescarTokenMeli(client_id_meli, client_secret_meli, refresh_token_meli);
                    if (respuestaRefrescarToken.codigo_respuesta == 0) {
                        token_meli = respuestaRefrescarToken.token_meli;
                        refresh_token_meli = respuestaRefrescarToken.refresh_token_meli;
                        guardarTokenMeli("refrescar", token_meli, refresh_token_meli, ajaxurl, usuario_duenio_token);
                        mostrarInputCheckMeli();
                        $("#mensajes_generales").html(tokenMeliExitoso);
                    } else {
                        error_token_meli = respuestaRefrescarToken.error;
                        mensaje_error_token_meli = respuestaRefrescarToken.mensaje_error;
                        errorTokenMeli(error_token_meli, mensaje_error_token_meli, ajaxurl);
                        let noSePudoRefrescarToken =
                            `<div class="alert alert-danger alert-dismissible">
                                No se pudo refrescar su token por los siguientes motivos: <br />
                                - ${error_token_meli} <br />
                                - ${mensaje_error_token_meli} <br />
                            </div>`;
                        $("#div_ofiliaria_publicar_meli").html('');
                        $("#mensajes_generales").html(noSePudoRefrescarToken);
                    }   
                }
                else
                {
                    $("#div_ofiliaria_publicar_meli").html('');
                    let mensajeErrorVerificacionToken = 
                        `<div class="alert alert-danger alert-dismissible">
                            No se pudo verificar su token por los siguientes motivos: <br />
                            - ${respuestaVerificarToken.codigo_respuesta} <br />
                            - ${respuestaVerificarToken.mensaje_respuesta} <br />
                        </div>`;
                    $("#mensajes_generales").html(mensajeErrorVerificacionToken);
                }
            }

            function mostrarInputCheckMeli()
            {
                if ($('#id_publicacion_meli').val() != 0)
                {
                    obtenerPublicacionMeli(token_meli, $('#id_publicacion_meli').val());
                }
                else
                {
                    $("#div_ofiliaria_publicar_meli").html(contenidoPublicarMeli);
                }
            }

            function ocultarCamposPromesa()
            {
                return new Promise((resolve) => {
                    $('.ofiliaria_detalle_anuncio').hide();
                    $('#div_property_size').hide();
                    $('#div_property_lot_size').hide();
                    $('#div_property_rooms').hide();
                    // $('#div_property_bedrooms').hide();
                    $('#div_property_bathrooms').hide();   
                    $('#div_estacionamiento').hide();
                    resolve('Los campos se ocultaron exitosamente');
                });
            }

            async function mostrarOcultarCampos(prop_category_submit, prop_action_category_submit)
            {
                await ocultarCamposPromesa();
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: 
                    {
                        'action' : 'buscar_campos_meli',
                        'indicador_ajax' : 1,
                        'prop_category_submit' : prop_category_submit,
                        'prop_action_category_submit' : prop_action_category_submit
                    },
                    beforeSend: function() 
                    {
                        //
                    },
                    success: function(data) 
                    {
                        var campos_a_mostrar = data.campos_a_mostrar;

                        for (let i = 0; i < campos_meli.length; i++) 
                        {
                            if (campos_a_mostrar[campos_meli[i]])
                            {
                                let idDiv = '';
                                if (campos_meli[i].substring(0, 10) == '_ofiliaria')
                                {
                                    idDiv = `#div${campos_meli[i]}`;
                                }
                                else
                                {
                                    idDiv = `#div_${campos_meli[i]}`;
                                }
                                $(idDiv).show();
                            }
                        }
                        for (let i = 0; i < campos_numericos.length; i++) 
                        {
                            if ($(`#${campos_numericos[i]}`).val() == '')
                            {
                                $(`#${campos_numericos[i]}`).val(0);
                            }
                        }
                        wpestate_filter_county_city_select('property_county', 'property_city_submit');
                        wpestate_filter_city_area_select('property_city_submit', 'property_area_submit');

                    },
                    error: function (x, xs, xt) 
                    {
                        console.log('error', JSON.stringify(x));
                    }
                });
            }

            function validacionPublicacion() 
            {
                return new Promise((resolve) => {
                    var ofiliariaPublicarMeli = 0;
                    var ofiliariaPublicaInfocasas = 0;
                    if ($('#ofiliaria_publicar_meli').is(':checked'))
                    {
                        ofiliariaPublicarMeli = 1;
                    }
                    if ($('#ofiliaria_publicar_infocasas').is(':checked'))
                    {
                        ofiliariaPublicaInfocasas = 1;
                    }

                    // Campos principales de la publicación

                    const _ofiliaria_banio_social = $('#div_ofiliaria_banio_social input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_dormitorio_de_servicio = $('#div_ofiliaria_dormitorio_de_servicio input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_parrillero = $('#div_ofiliaria_parrillero input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_piscina = $('#div_ofiliaria_piscina input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_terraza = $('#div_ofiliaria_terraza input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_amoblado = $('#div_ofiliaria_amoblado input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_admite_mascotas = $('#div_ofiliaria_admite_mascotas input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_uso_comercial = $('#div_ofiliaria_uso_comercial input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_vivienda_social = $('#div_ofiliaria_vivienda_social input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_acepta_permuta = $('#div_ofiliaria_acepta_permuta input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_servicio_de_desayuno = $('#div_ofiliaria_servicio_de_desayuno input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_servicio_de_limpieza = $('#div_ofiliaria_servicio_de_limpieza input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_apto_para_oficina = $('#div_ofiliaria_apto_para_oficina input[type="radio"]:checked').val() || 'No disponible';

                    // Campos secundarios de la publicación
                    
                    const _ofiliaria_adicional_servicios_acceso_a_internet = $('#div_ofiliaria_adicional_servicios_acceso_a_internet input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_servicios_gas_natural = $('#div_ofiliaria_adicional_servicios_gas_natural input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_servicios_linea_telefonica = $('#div_ofiliaria_adicional_servicios_linea_telefonica input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_servicios_tv_por_cable = $('#div_ofiliaria_adicional_servicios_tv_por_cable input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_servicios_aire_acondicionado = $('#div_ofiliaria_adicional_servicios_aire_acondicionado input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_servicios_calefaccion = $('#div_ofiliaria_adicional_servicios_calefaccion input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_servicios_agua_corriente = $('#div_ofiliaria_adicional_servicios_agua_corriente input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_servicios_caldera_a_gas_electrica = $('#div_ofiliaria_adicional_servicios_caldera_a_gas_electrica input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_servicios_con_energia_solar = $('#div_ofiliaria_adicional_servicios_con_energia_solar input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_servicios_con_conexion_para_lavarropas = $('#div_ofiliaria_adicional_servicios_con_conexion_para_lavarropas input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_servicios_grupo_electrogeno = $('#div_ofiliaria_adicional_servicios_grupo_electrogeno input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_servicios_con_tv_satelital = $('#div_ofiliaria_adicional_servicios_con_tv_satelital input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_servicios_jardinero = $('#div_ofiliaria_adicional_servicios_jardinero input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_servicios_luz_electrica = $('#div_ofiliaria_adicional_servicios_luz_electrica input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_servicios_saneamiento = $('#div_ofiliaria_adicional_servicios_saneamiento input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_ascensor = $('#div_ofiliaria_adicional_comodidades_equipamiento_ascensor input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol = $('#div_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle = $('#div_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis = $('#div_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol = $('#div_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva = $('#div_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples = $('#div_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_chimenea = $('#div_ofiliaria_adicional_comodidades_equipamiento_chimenea input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_con_area_verde = $('#div_ofiliaria_adicional_comodidades_equipamiento_con_area_verde input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas = $('#div_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_gimnasio = $('#div_ofiliaria_adicional_comodidades_equipamiento_gimnasio input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_heladera = $('#div_ofiliaria_adicional_comodidades_equipamiento_heladera input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_jacuzzi = $('#div__ofiliaria_adicional_comodidades_equipamiento_jacuzzi input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas = $('#div_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_sauna = $('#div_ofiliaria_adicional_comodidades_equipamiento_sauna input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_area_de_cine = $('#div_ofiliaria_adicional_comodidades_equipamiento_area_de_cine input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles = $('#div_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_cisterna = $('#div_ofiliaria_adicional_comodidades_equipamiento_cisterna input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_cowork = $('#div_ofiliaria_adicional_comodidades_equipamiento_cowork input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas = $('#div_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_recepcion = $('#div_ofiliaria_adicional_comodidades_equipamiento_recepcion input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_bebederos = $('#div_ofiliaria_adicional_comodidades_equipamiento_bebederos input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_casco = $('#div_ofiliaria_adicional_comodidades_equipamiento_casco input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_corral = $('#div_ofiliaria_adicional_comodidades_equipamiento_corral input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_galpon = $('#div_ofiliaria_adicional_comodidades_equipamiento_galpon input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_molinos = $('#div_ofiliaria_adicional_comodidades_equipamiento_molinos input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_silos = $('#div_ofiliaria_adicional_comodidades_equipamiento_silos input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua = $('#div_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_lavarropa = $('#div_ofiliaria_adicional_comodidades_equipamiento_lavarropa input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_microondas = $('#div_ofiliaria_adicional_comodidades_equipamiento_microondas input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_tv = $('#div_ofiliaria_adicional_comodidades_equipamiento_tv input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_comodidades_equipamiento_vajilla = $('#div_ofiliaria_adicional_comodidades_equipamiento_vajilla input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_seguridad_alarma = $('#div_ofiliaria_adicional_seguridad_alarma input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_seguridad_porton_automatico = $('#div_ofiliaria_adicional_seguridad_porton_automatico input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad = $('#div_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_seguridad_acceso_controlado = $('#div_ofiliaria_adicional_seguridad_acceso_controlado input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_seguridad_con_barrio_cerrado = $('#div_ofiliaria_adicional_seguridad_con_barrio_cerrado input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_ambientes_altillo = $('#div_ofiliaria_adicional_ambientes_altillo input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_ambientes_balcon = $('#div_ofiliaria_adicional_ambientes_balcon input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_ambientes_cocina = $('#div_ofiliaria_adicional_ambientes_cocina input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_ambientes_comedor = $('#div_ofiliaria_adicional_ambientes_comedor input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_ambientes_dormitorio_en_suite = $('#div_ofiliaria_adicional_ambientes_dormitorio_en_suite input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_ambientes_estudio = $('#div_ofiliaria_adicional_ambientes_estudio input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_ambientes_living = $('#div_ofiliaria_adicional_ambientes_living input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_ambientes_patio = $('#div_ofiliaria_adicional_ambientes_patio input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_ambientes_placards = $('#div_ofiliaria_adicional_ambientes_placards input[type="radio"]:checked').val() || 'No disponible';
                    
                    const _ofiliaria_adicional_ambientes_cuarto_de_juegos = $('#div_ofiliaria_adicional_ambientes_cuarto_de_juegos input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_ambientes_con_lavadero = $('#div_ofiliaria_adicional_ambientes_con_lavadero input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_ambientes_vestidor = $('#div_ofiliaria_adicional_ambientes_vestidor input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_ambientes_desayunador = $('#div_ofiliaria_adicional_ambientes_desayunador input[type="radio"]:checked').val() || 'No disponible';

                    const _ofiliaria_adicional_ambientes_jardin = $('#div_ofiliaria_adicional_ambientes_jardin input[type="radio"]:checked').val() || 'No disponible';
                   
                    var _ofiliaria_adicional_seguridad_tipo_de_seguridad = $('#_ofiliaria_adicional_seguridad_tipo_de_seguridad').val();
                    
                    // si existe en excepcionesTipoSeguridad la combinación categoría-acción se cambia el valor por el valor de esa combinación
                    if (excepcionesTipoSeguridad[`${$('#prop_category_submit').val()}-${$('#prop_action_category_submit').val()}`]) 
                    {
                        _ofiliaria_adicional_seguridad_tipo_de_seguridad = excepcionesTipoSeguridad[`${$('#prop_category_submit').val()}-${$('#prop_action_category_submit').val()}`];
                    }
                    
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: ajaxurl,
                        data: 
                        {
                            'action' : 'validacion_publicacion',
                            'id_post_publicacion' : $('#id_post_publicacion').val(),
                            'wpestate_title' : $('#title').val(),
                            'wpestate_description' : $('#description').val(),
                            'property_price' : $('#property_price').val(),
                            'divisa' : $('#divisa').val(),
                            'prop_category_submit' : $('#prop_category_submit').val(),
                            'prop_action_category_submit' : $('#prop_action_category_submit').val(),
                            'property_address' : $('#property_address').val(),
                            'property_county' : $('#property_county').val(),
                            'property_city_submit' : $('#property_city_submit').val(),
                            'property_area_submit' : $('#property_area_submit').val(),
                            'property_latitude' : $('#property_latitude').val(),
                            'property_longitude' : $('#property_longitude').val(),
                            'property_size' : $('#property_size').val(),
                            'property_lot_size' : $('#property_lot_size').val(),
                            'property_rooms' : $('#property_rooms').val(),
                            'property_bedrooms' : $('#property_bedrooms').val(),
                            'property_bathrooms' : $('#property_bathrooms').val(),
                            '_ofiliaria_superficie_de_balcon' : $('#_ofiliaria_superficie_de_balcon').val(),
                            'estacionamiento' : $('#estacionamiento').val(),  
                            '_ofiliaria_acceso_lote_terreno' : $('#_ofiliaria_acceso_lote_terreno').val(),
                            '_ofiliaria_bodegas' : $('#_ofiliaria_bodegas').val(),
                            '_ofiliaria_huespedes' : $('#_ofiliaria_huespedes').val(),
                            '_ofiliaria_horario_de_contacto' : $('#_ofiliaria_horario_de_contacto').val(),
                            '_ofiliaria_cantidad_de_pisos' : $('#_ofiliaria_cantidad_de_pisos').val(),
                            '_ofiliaria_numero_del_apartamento' : $('#_ofiliaria_numero_del_apartamento').val(),
                            '_ofiliaria_apartamentos_por_piso' : $('#_ofiliaria_apartamentos_por_piso').val(),
                            '_ofiliaria_numero_de_piso_de_la_unidad' : $('#_ofiliaria_numero_de_piso_de_la_unidad').val(),
                            '_ofiliaria_tipo_de_departamento' : $('#_ofiliaria_tipo_de_departamento').val(),
                            '_ofiliaria_disposicion' : $('#_ofiliaria_disposicion').val(),
                            '_ofiliaria_orientacion' : $('#_ofiliaria_orientacion').val(),
                            '_ofiliaria_anio_construccion_de_la_propiedad' : $('#_ofiliaria_anio_construccion_de_la_propiedad').val(),
                            '_ofiliaria_antiguedad' : $('#_ofiliaria_antiguedad').val(),
                            '_ofiliaria_codigo_de_la_propiedad' : $('#_ofiliaria_codigo_de_la_propiedad').val(),
                            '_ofiliaria_camas' : $('#_ofiliaria_camas').val(),
                            '_ofiliaria_admite_mascotas' : _ofiliaria_admite_mascotas,
                            '_ofiliaria_amoblado' : _ofiliaria_amoblado,
                            '_ofiliaria_ambientes' : $('#_ofiliaria_ambientes').val(),
                            '_ofiliaria_numero_de_la_casa' : $('#_ofiliaria_numero_de_la_casa').val(),
                            '_ofiliaria_tipo_de_casa' : $('#_ofiliaria_tipo_de_casa').val(),
                            '_ofiliaria_superficie_de_terreno' : $('#_ofiliaria_superficie_de_terreno').val(),
                            '_ofiliaria_parrillero' : _ofiliaria_parrillero,
                            '_ofiliaria_uso_comercial' : _ofiliaria_uso_comercial,
                            '_ofiliaria_tipo_de_campo' : $('#_ofiliaria_tipo_de_campo').val(),
                            '_ofiliaria_distancia_al_asfalto' : $('#_ofiliaria_distancia_al_asfalto').val(),
                            '_ofiliaria_forma_del_terreno' : $('#_ofiliaria_forma_del_terreno').val(),
                            '_ofiliaria_superficie_cubierta_del_casco' : $('#_ofiliaria_superficie_cubierta_del_casco').val(),
                            '_ofiliaria_banio_social' : _ofiliaria_banio_social,
                            '_ofiliaria_dormitorio_de_servicio' : _ofiliaria_dormitorio_de_servicio, 
                            '_ofiliaria_piscina' : _ofiliaria_piscina,
                            '_ofiliaria_terraza' : _ofiliaria_terraza,
                            'ofiliaria_publicar_meli' : ofiliariaPublicarMeli,
                            'ofiliaria_publicar_infocasas' : ofiliariaPublicaInfocasas,
                            '_ofiliaria_adicional_servicios_acceso_a_internet' : _ofiliaria_adicional_servicios_acceso_a_internet,
                            '_ofiliaria_adicional_servicios_gas_natural' : _ofiliaria_adicional_servicios_gas_natural,
                            '_ofiliaria_adicional_servicios_linea_telefonica' : _ofiliaria_adicional_servicios_linea_telefonica,
                            '_ofiliaria_adicional_servicios_tv_por_cable' : _ofiliaria_adicional_servicios_tv_por_cable,
                            '_ofiliaria_adicional_servicios_aire_acondicionado' : _ofiliaria_adicional_servicios_aire_acondicionado,
                            '_ofiliaria_adicional_servicios_calefaccion' : _ofiliaria_adicional_servicios_calefaccion,
                            '_ofiliaria_adicional_servicios_agua_corriente' : _ofiliaria_adicional_servicios_agua_corriente,
                            '_ofiliaria_adicional_servicios_caldera_a_gas_electrica' : _ofiliaria_adicional_servicios_caldera_a_gas_electrica,
                            '_ofiliaria_adicional_servicios_con_energia_solar' : _ofiliaria_adicional_servicios_con_energia_solar,
                            '_ofiliaria_adicional_servicios_con_conexion_para_lavarropas' : _ofiliaria_adicional_servicios_con_conexion_para_lavarropas,
                            '_ofiliaria_adicional_servicios_grupo_electrogeno' : _ofiliaria_adicional_servicios_grupo_electrogeno,
                            '_ofiliaria_adicional_servicios_con_tv_satelital' : _ofiliaria_adicional_servicios_con_tv_satelital,
                            '_ofiliaria_adicional_servicios_jardinero' : _ofiliaria_adicional_servicios_jardinero,
                            '_ofiliaria_adicional_servicios_luz_electrica' : _ofiliaria_adicional_servicios_luz_electrica,
                            '_ofiliaria_adicional_servicios_saneamiento' : _ofiliaria_adicional_servicios_saneamiento,
                            '_ofiliaria_adicional_comodidades_equipamiento_ascensor' : _ofiliaria_adicional_comodidades_equipamiento_ascensor,
                            '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol' : _ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol,
                            '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle' : _ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle,
                            '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis' : _ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis,
                            '_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol' : _ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol,
                            '_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva' : _ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva,
                            '_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples': _ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples,
                            '_ofiliaria_adicional_comodidades_equipamiento_chimenea' : _ofiliaria_adicional_comodidades_equipamiento_chimenea,
                            '_ofiliaria_adicional_comodidades_equipamiento_con_area_verde' : _ofiliaria_adicional_comodidades_equipamiento_con_area_verde,
                            '_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas' : _ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas,
                            '_ofiliaria_adicional_comodidades_equipamiento_gimnasio' : _ofiliaria_adicional_comodidades_equipamiento_gimnasio,
                            '_ofiliaria_adicional_comodidades_equipamiento_heladera' : _ofiliaria_adicional_comodidades_equipamiento_heladera,
                            '_ofiliaria_adicional_comodidades_equipamiento_jacuzzi' : _ofiliaria_adicional_comodidades_equipamiento_jacuzzi,
                            '_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas' : _ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas,
                            '_ofiliaria_adicional_comodidades_equipamiento_sauna' : _ofiliaria_adicional_comodidades_equipamiento_sauna,
                            '_ofiliaria_adicional_comodidades_equipamiento_area_de_cine' : _ofiliaria_adicional_comodidades_equipamiento_area_de_cine,
                            '_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles' : _ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles,
                            '_ofiliaria_adicional_comodidades_equipamiento_cisterna' : _ofiliaria_adicional_comodidades_equipamiento_cisterna,
                            '_ofiliaria_adicional_comodidades_equipamiento_cowork' : _ofiliaria_adicional_comodidades_equipamiento_cowork,
                            '_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas' : _ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas,
                            '_ofiliaria_adicional_comodidades_equipamiento_recepcion' : _ofiliaria_adicional_comodidades_equipamiento_recepcion,
                            '_ofiliaria_adicional_comodidades_equipamiento_bebederos' : _ofiliaria_adicional_comodidades_equipamiento_bebederos,
                            '_ofiliaria_adicional_comodidades_equipamiento_casco' : _ofiliaria_adicional_comodidades_equipamiento_casco,
                            '_ofiliaria_adicional_comodidades_equipamiento_corral' : _ofiliaria_adicional_comodidades_equipamiento_corral,
                            '_ofiliaria_adicional_comodidades_equipamiento_galpon' : _ofiliaria_adicional_comodidades_equipamiento_galpon,
                            '_ofiliaria_adicional_comodidades_equipamiento_molinos' : _ofiliaria_adicional_comodidades_equipamiento_molinos,
                            '_ofiliaria_adicional_comodidades_equipamiento_silos' : _ofiliaria_adicional_comodidades_equipamiento_silos,
                            '_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua' : _ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua,
                            '_ofiliaria_adicional_comodidades_equipamiento_lavarropa' : _ofiliaria_adicional_comodidades_equipamiento_lavarropa,
                            '_ofiliaria_adicional_comodidades_equipamiento_microondas' : _ofiliaria_adicional_comodidades_equipamiento_microondas,
                            '_ofiliaria_adicional_comodidades_equipamiento_tv' : _ofiliaria_adicional_comodidades_equipamiento_tv,
                            '_ofiliaria_adicional_comodidades_equipamiento_vajilla' : _ofiliaria_adicional_comodidades_equipamiento_vajilla,
                            '_ofiliaria_adicional_seguridad_alarma' : _ofiliaria_adicional_seguridad_alarma,
                            '_ofiliaria_adicional_seguridad_porton_automatico' : _ofiliaria_adicional_seguridad_porton_automatico,
                            '_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad' : _ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad,
                            '_ofiliaria_adicional_seguridad_tipo_de_seguridad' : _ofiliaria_adicional_seguridad_tipo_de_seguridad,
                            '_ofiliaria_adicional_seguridad_acceso_controlado' : _ofiliaria_adicional_seguridad_acceso_controlado,
                            '_ofiliaria_adicional_seguridad_con_barrio_cerrado' : _ofiliaria_adicional_seguridad_con_barrio_cerrado,
                            '_ofiliaria_adicional_ambientes_altillo' : _ofiliaria_adicional_ambientes_altillo,
                            '_ofiliaria_adicional_ambientes_balcon' : _ofiliaria_adicional_ambientes_balcon,
                            '_ofiliaria_adicional_ambientes_cocina' : _ofiliaria_adicional_ambientes_cocina,
                            '_ofiliaria_adicional_ambientes_comedor' : _ofiliaria_adicional_ambientes_comedor,
                            '_ofiliaria_adicional_ambientes_dormitorio_en_suite' : _ofiliaria_adicional_ambientes_dormitorio_en_suite,
                            '_ofiliaria_adicional_ambientes_estudio' : _ofiliaria_adicional_ambientes_estudio,
                            '_ofiliaria_adicional_ambientes_living' : _ofiliaria_adicional_ambientes_living,
                            '_ofiliaria_adicional_ambientes_patio' : _ofiliaria_adicional_ambientes_patio,
                            '_ofiliaria_adicional_ambientes_placards' : _ofiliaria_adicional_ambientes_placards,
                            '_ofiliaria_adicional_ambientes_cuarto_de_juegos' : _ofiliaria_adicional_ambientes_cuarto_de_juegos,
                            '_ofiliaria_adicional_ambientes_con_lavadero' : _ofiliaria_adicional_ambientes_con_lavadero,
                            '_ofiliaria_adicional_ambientes_vestidor' : _ofiliaria_adicional_ambientes_vestidor,
                            '_ofiliaria_adicional_ambientes_desayunador' : _ofiliaria_adicional_ambientes_desayunador,
                            '_ofiliaria_adicional_ambientes_jardin' : _ofiliaria_adicional_ambientes_jardin,
                            '_ofiliaria_sobre' : $('#_ofiliaria_sobre').val(),
                            '_ofiliaria_vivienda_social' : _ofiliaria_vivienda_social,
                            '_ofiliaria_estado' : $('#_ofiliaria_estado').val(),
                            '_ofiliaria_m2_terraza_propiedad' : $('#_ofiliaria_m2_terraza_propiedad').val(),
                            '_ofiliaria_acepta_permuta' : _ofiliaria_acepta_permuta,
                            '_ofiliaria_cantidad_plantas_propiedad' : $('#_ofiliaria_cantidad_plantas_propiedad').val(),
                            '_ofiliaria_gastos_comunes_propiedad' : $('#_ofiliaria_gastos_comunes_propiedad').val(),
                            '_ofiliaria_moneda_gastos_comunes' : $('#_ofiliaria_moneda_gastos_comunes').val(),
                            '_ofiliaria_horario_check_in' : $('#_ofiliaria_horario_check_in').val(),
                            '_ofiliaria_horario_check_out' : $('#_ofiliaria_horario_check_out').val(), 
                            '_ofiliaria_servicio_de_desayuno' : _ofiliaria_servicio_de_desayuno, 
                            '_ofiliaria_servicio_de_limpieza' : _ofiliaria_servicio_de_limpieza,
                            '_ofiliaria_estadia_minima_noches' : $('#_ofiliaria_estadia_minima_noches').val(),
                            '_ofiliaria_adicional_comodidades_equipamiento_numero_de_torre' : $('#_ofiliaria_adicional_comodidades_equipamiento_numero_de_torre').val(), 
                            '_ofiliaria_apto_para_oficina' : _ofiliaria_apto_para_oficina
                        },
                        beforeSend: function() 
                        {
                            // 
                        },
                        success: function(data) 
                        {
                            $('#identificador').val(data.identificador); 
                            resolve(data);
                        },
                        error: function (x, xs, xt) 
                        {
                            console.log('error', JSON.stringify(x));
                        }
                    });
                });
            }
                
            $(function() {
                console.log('Se cargó indexAniadirNuevaPropiedad.js');
                if ($("#mensaje_no_conectado_meli").length) {
                    $("#mensaje_no_conectado_meli").hide();
                } 

                obtenerTokenMeliAP();
                mostrarOcultarCampos($('#prop_category_submit').val(), $('#prop_action_category_submit').val());
                
                $('#prop_category_submit').on('change', function(event) 
                {
                    if ($('#prop_category_submit').val() != -1 && $('#prop_action_category_submit').val() != -1)
                    {
                        mostrarOcultarCampos($('#prop_category_submit').val(), $('#prop_action_category_submit').val());
                    }
                });

                $('#prop_action_category_submit').on('change', function(event) 
                {
                    if ($('#prop_action_category_submit').val() != -1 && $('#prop_category_submit').val() != -1)
                    {
                        mostrarOcultarCampos($('#prop_category_submit').val(), $('#prop_action_category_submit').val());
                    }
                });

                $('#ofiliaria_publicar_meli').on('click', function(event) 
                {
                    if ($('#ofiliaria_publicar_meli').is(':checked'))
                    {
                        if (token_meli == "" || token_meli == "El usuario no tiene token" || token_meli == "Debe refrescar el token" || token_meli == "Error en el servidor")
                        {
                            $("#mensaje_no_conectado_meli").show();
                        }
                    }
                });
        
                $('#boton_configurar_conexion_meli').on( 'click', function(event) 
                {
                    event.preventDefault();
                    location.href ="https://"+url_base+"/mercadolibre";
                });

                $("#new_post").submit(async function(event) 
                {
                    $("#ofiliaria_gif_espere").html(
                        `<img src='https://dev-backend.ofiliaria.com/public/imagenes/loading.gif' 
                            alt='Por favor espere' style="width: 90px; height: 90px" />`);
                    event.preventDefault();
                    const respuestaValidacionPublicacion = await validacionPublicacion();
                    if (respuestaValidacionPublicacion.codigo_retorno == 0)
                    {
                        $(this).off('submit').submit();
                    }
                    else
                    {
                        $("#ofiliaria_gif_espere").html('');
                        $("#ofiliaria_mensaje_validacion").html(respuestaValidacionPublicacion.lista_de_errores);
                    }
                });                              
            });
        }    
    })(jQuery);
}
indexAniadirNuevaPropiedad();