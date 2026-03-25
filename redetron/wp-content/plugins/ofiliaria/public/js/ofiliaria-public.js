(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	// Variables globales
	var posicion = 0;
	var url_base = window.location.hostname; 
	var pathname = window.location.pathname;
	var urlCompleta = window.location.href;
	var ajaxurl = variables_php_javascript.ajax_url;
	// console.log("ajaxurl", ajaxurl);
	/*
	var paginas_token_meli = 
		{
			"/dashboard-property-list/" : "/dashboard-property-list/",
			"/dashboard-propiedades/" : "/dashboard-propiedades/",
			"/dashboard-add-property/" : "/dashboard-add-property/",
			"/dashboard-agregar-propiedad/" : "/dashboard-agregar-propiedad/"
		}
	*/
	var client_id_meli = variables_php_javascript.client_id_meli;
	var client_secret_meli = variables_php_javascript.client_secret_meli;
	var token_meli = "";
	var refresh_token_meli = ""; 

	// Funciones globales

	function getParameterByName(name) {
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
		return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	function guardar_token_meli(accion)
	{
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
	}
	
	function obtener_token_meli()
	{
		$.ajax({
			url: 'https://api.mercadolibre.com/oauth/token',
			type: 'POST',
			headers : 
			{
				"Content-Type": "application/x-www-form-urlencoded",
				"accept": "application/json",
			},
			dataType: 'json',
			data: "grant_type=authorization_code&client_id="+client_id_meli+"&client_secret="+client_secret_meli+"&code="+$("#codigo_temporal").val()+"&redirect_uri=https://"+url_base+"/mercadolibre",
			success: function(data) 
			{
				$("#configurar_conexion_meli").hide();
				token_meli = data.access_token;
				refresh_token_meli = data.refresh_token;
				guardar_token_meli("obtener");
			},
			error: function (x, xs, xt) 
			{
				console.log('error', JSON.stringify(x));
			}
		});
	}
	
	/*
	function refrescar_token_meli()
	{
		$.ajax({
			url: 'https://api.mercadolibre.com/oauth/token',
			type: 'POST',
			headers : 
			{
				"Content-Type": "application/x-www-form-urlencoded",
				"accept": "application/json",
			},
			dataType: 'json',
			data: "grant_type=refresh_token&client_id="+client_id_meli+"&client_secret="+client_secret_meli+"&refresh_token="+refresh_token_meli,
			success: function(data) 
			{
				token_meli = data.access_token;
				refresh_token_meli = data.refresh_token;
				guardar_token_meli("refrescar");
			},
			error: function (x, xs, xt) 
			{
				console.log('error', JSON.stringify(x));
			}
		});
	}
	*/
	
	function validar_inmueble_meli()
	{
		let datos_meli_ajax = preparar_datos_meli_ajax();

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajaxurl,
			data: 
			{
				'action' : 'validar_inmueble_meli',
				'datos_inmueble' : datos_meli_ajax
			},
			success: function(data) 
			{
				console.log("validar_inmueble_meli");
				console.log("respuesta", data.respuesta);
				console.log("codigo_retorno", data.codigo_retorno);
			},
			error: function (x, xs, xt) 
			{
				console.log('error', JSON.stringify(x));
			}
		});
	}
	/*
	function publicar_inmueble_meli()
	{
		let datos_meli_ajax_json = preparar_datos_meli_ajax_json();  
		
		$.ajax({
			crossDomain: true,
			headers : 
				{
					"Authorization": "Bearer "+token_meli,
					"Content-Type": "application/json",
					"Access-Control-Allow-Origin":"*"
				},
			cache: false,
			contentType: false,
			data: datos_meli_ajax_json,
			dataType: 'JSON',
			processData: false,
			method: "POST",
			url: "https://api.mercadolibre.com/items",
			success: function(data) 
			{
				console.log('data', data)
			},
			error: function (x, xs, xt) 
			{
				console.log('error', JSON.stringify(x));
			}
		});		
	}
	*/
	function preparar_datos_meli_ajax()
	{
		let datos_meli_ajax = 
			{
				"title": "Property title",
				"category_id": "MLU1474",
				"price": 100000,
				"currency_id": "UYU",
				"available_quantity": 1,
				"buying_mode": "classified",
				"listing_type_id": "silver",
				"condition": "not_specified",
				"channels": 
					[
					"marketplace" 
					], 
				"pictures": 
					[
					{
					"source":"http://mla-d2-p.mlstatic.com/item-de-test-no-ofertar-543605-MLA25041518406_092016-O.jpg?square=false"
					}
					],
				"seller_contact": 
					{
					"contact": "Contact name",
					"other_info": "Additional contact info",
					"area_code": "011",
					"phone": "4444-5555",
					"area_code2": "",
					"phone2": "",
					"email": "contact-email@somedomain.com",
					"webmail": ""
					},
				"location": 
					{
					"address_line": "My property address 1234",
					"zip_code": "01234567",
					"neighborhood": {
					"id": "TUxBQlBBUzgyNjBa"
					},
					"latitude": -34.48755,
					"longitude": -58.56987
					},
				"attributes": 
					[
						{
						"id": "ROOMS",
						"value_name": "2"
						},
						{
						"id": "FULL_BATHROOMS",
						"value_name": "1"
						},
						{
						"id": "PARKING_LOTS",
						"value_name": "1"
						},
						{
						"id": "BEDROOMS",
						"value_name": "4"
						},
						{
						"id": "COVERED_AREA",
						"value_name": "30 m²"
						},
						{
						"id": "TOTAL_AREA",
						"value_name": "40 m²"
						}
					],
				"video_id": "gqkEN9poKM;matterport",
				"description": 
					{
						plain_text: "This is the real estate property description. \n"
					}
			};
		return datos_meli_ajax;
	}
	/*
	function preparar_datos_meli_ajax_json()
	{
		let datos_meli_ajax = 
			{
				"title": "Property title",
				"category_id": "MLU1474",
				"price": 100000,
				"currency_id": "UYU",
				"available_quantity": 1,
				"buying_mode": "classified",
				"listing_type_id": "silver",
				"condition": "not_specified",
				"channels": 
					[
					"marketplace" 
					], 
				"pictures": 
					[
					{
					"source":"http://mla-d2-p.mlstatic.com/item-de-test-no-ofertar-543605-MLA25041518406_092016-O.jpg?square=false"
					}
					],
				"seller_contact": 
					{
					"contact": "Contact name",
					"other_info": "Additional contact info",
					"area_code": "011",
					"phone": "4444-5555",
					"area_code2": "",
					"phone2": "",
					"email": "contact-email@somedomain.com",
					"webmail": ""
					},
				"location": 
					{
					"address_line": "My property address 1234",
					"zip_code": "01234567",
					"neighborhood": {
					"id": "TUxBQlBBUzgyNjBa"
					},
					"latitude": -34.48755,
					"longitude": -58.56987
					},
				"attributes": 
					[
						{
						"id": "ROOMS",
						"value_name": "2"
						},
						{
						"id": "FULL_BATHROOMS",
						"value_name": "1"
						},
						{
						"id": "PARKING_LOTS",
						"value_name": "1"
						},
						{
						"id": "BEDROOMS",
						"value_name": "4"
						},
						{
						"id": "COVERED_AREA",
						"value_name": "30 m²"
						},
						{
						"id": "TOTAL_AREA",
						"value_name": "40 m²"
						}
					],
				"video_id": "gqkEN9poKM;matterport",
				"description": 
					{
						plain_text: "This is the real estate property description. \n"
					}
			};
		let datos_meli_ajax_json = JSON.stringify(datos_meli_ajax);
		return datos_meli_ajax_json;
	}
	*/

	function modificar_inmueble_meli()
	{
		let datos_meli_ajax = 
			{
				"seller_contact": 
				{
				"contact": "Ángel Omar Sanz Lattuf Gracia Sardi Junior Santos de la Mancha",
				"other_info": "Additional contact info",
				"area_code": "414",
				"phone": "4937-9300",
				"area_code2": "",
				"phone2": "",
				"email": "angelomarsanz@gmail.com",
				"webmail": ""
				}
			};

		let datos_meli_ajax_json = JSON.stringify(datos_meli_ajax);
		
		$.ajax({
			headers : 
				{
					"Authorization": "Bearer "+token_meli,
					"Content-Type": "application/json"
				},
			data: datos_meli_ajax_json,
			dataType: 'JSON',
			method: "put",
			url: "https://api.mercadolibre.com/items/MLU640137035",
			success: function(data) 
			{
				console.log('data', data)
			},
			error: function (x, xs, xt) 
			{
				console.log('error', JSON.stringify(x));
			}
		});		
	}

	function preguntas_meli()
	{
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajaxurl,
			data: 
			{
				'action' : 'preguntas_meli'
			},
			success: function(data) 
			{
				console.log("mensaje", data.mensaje);
			},
			error: function (x, xs, xt) 
			{
				console.log('error', JSON.stringify(x));
			}
		});
	}
	function insertar_html()
	{
		let html = document.getElementById("requisitos_sura").innerHTML;
		document.getElementById("mostrar_post").innerHTML = html;
		console.log("insertar_html", html);
	}
	function contenido_post()
	{
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajaxurl,
			data: 
			{
				'action' : 'contenido_post'
			},
			success: function(data) 
			{
				document.getElementById("mostrar_post").innerHTML = data.contenido_post;
				console.log("contenido_post usando innerHTML", data.contenido_post);
			},
			error: function (x, xs, xt) 
			{
				console.log('error', JSON.stringify(x));
			}
		});
	}	

	$(document).ready(function () 
	{
		// console.log('url_base', url_base);
		// console.log("pathname", pathname);
		// console.log('urlCompleta', urlCompleta);

		var loginCrm = getParameterByName('loginCrm');
		if (loginCrm != '')
		{
			if (!Modernizr.mq('only all and (max-width: 768px)')) 
			{
				$('#modal_login_wrapper').show();
			}
			else
			{
				$('.mobile-trigger-user').trigger('click');
			}
			$('#modal_login_wrapper').find('[autofocus]').focus();
		}
		/*
		if (paginas_token_meli[pathname])
		{
			validar_inmueble_meli();			
			
			if ($("#mensaje_no_conectado_meli").length) {
				$("#mensaje_no_conectado_meli").hide();
			} 

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
					if ( data.codigo_retorno_token_meli == 0) 
					{
						token_meli = data.token_meli_bd;
						console.log("token_meli", token_meli);
					} 
					else if ( data.codigo_retorno_token_meli == 1)  
					{
						token_meli = 'El usuario no tiene token';
					}
					else
					{
						refresh_token_meli = data.refresh_token_meli_bd;
						refrescar_token_meli();						
					}
				},
				error: function (x, xs, xt) 
				{
					console.log('error', JSON.stringify(x));
				}
			});

			$('#ofiliaria_publicar_meli').on('click', function(event) 
			{
				if ($('#ofiliaria_publicar_meli').is(':checked'))
				{
					if (token_meli == "" || token_meli == "El usuario no tiene token")
					{
						$("#mensaje_no_conectado_meli").show();
					}
					else
					{
						publicar_inmueble_meli();
					}	
				}
			});
	
			$('#boton_configurar_conexion_meli').on( 'click', function(event) 
			{
				event.preventDefault();
				location.href ="https://"+url_base+"/configurar-conexion-con-mercadolibre";
			});
		}
		*/

		if (pathname == "/configurar-conexion-con-mercadolibre/")
		{
			$('#acceder_a_meli').on( 'click', function(event) 
			{
				window.open("https://www.mercadolibre.com.uy");
			});
			
			$('#continuar_configuracion').on( 'click', function(event) 
			{
				location.href ="https://auth.mercadolibre.com.uy/authorization?response_type=code&client_id="+client_id_meli+"&redirect_uri=https://"+url_base+"/mercadolibre";
			});	
		}
		/*
		if (pathname == "/mercadolibre/")
		{
			if ($("#codigo_temporal").val() != "error")
			{
				obtener_token_meli();
			}
			else
			{
				$("#configuracion_conexion_meli").text("Estimado usuario, la configuración de la conexión con Mercado Libre no fue exitosa, por favor intente nuevamente");
			}

			$('#opcion_configurar_conexion_meli').on( 'click', function(event) 
			{
				event.preventDefault();
				location.href ="https://auth.mercadolibre.com.uy/authorization?response_type=code&client_id="+client_id_meli+"&redirect_uri=https://"+url_base+"/mercadolibre";
			});
	
		}
		*/	
		if (pathname == "/nueva-garantia/")
		{
			// $(".requisitos_aseguradora").hide();
			// insertar_html();
			// contenido_post();			
		}
	});

})( jQuery );