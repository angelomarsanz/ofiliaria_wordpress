<?php
/* Notas para mejorar el vector:
    - El sub-indice clasificacion está vacío en todo el vector, así que puede usarse para clasificar los elementos
    - Eliminar el índice bd_comparacion
*/
$wp_meli =
    [
        // Clasificación: Campos generales requeridos
        [
            'descripcion' => 'Autor original',
            'wp' => 'original_author',
            'html_comparacion' => '',
            'meli' => '',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'ID de la publicación de MELI',
            'wp' => '_ofiliaria_id_meli_publicacion',
            'html_comparacion' => '',
            'meli' => 'id',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Título',
            'wp' => 'post_title',
            'html_comparacion' => '',
            'meli' => 'title',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'etiquetasXmlInfocasas' => 'titulo',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Descripción',
            'wp' => 'post_content',
            'html_comparacion' => '',
            'meli' => 'description',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'etiquetasXmlInfocasas' => 'descripcion',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'ID del vendedor MELI',
            'wp' => '_ofiliaria_id_usuario_meli',
            'html_comparacion' => '',
            'meli' => 'seller_id',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'ID de la categoría',
            'wp' => '_ofiliaria_id_categoria_meli',
            'html_comparacion' => '',
            'meli' => 'category_id',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Nombre de la categoría MELI',
            'wp' => '_ofiliaria_nombre_categoria_meli',
            'html_comparacion' => '_ofiliaria_nombre_categoria_meli',
            'meli' => 'PROPERTY_TYPE',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'generales_requeridos',
            'etiquetasXmlInfocasas' => 'tipoPropiedad',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Operación',
            'wp' => '_ofiliaria_tipo_operacion',
            'html_comparacion' => '_ofiliaria_tipo_operacion',
            'meli' => 'OPERATION',
            'meli_comparacion' => 'OPERATION',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'generales_requeridos',
            'etiquetasXmlInfocasas' => 'tipoOperacion',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Precio',
            'wp' => 'property_price',
            'html_comparacion' => 'property_price',
            'meli' => 'price',
            'meli_comparacion' => 'price',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'etiquetasXmlInfocasas' => 
                [    
                    'precioVenta',
                    'precioAlquiler',
                    'precioAlquilerDiciembre',
                    'precioAlquilerPrimeraQuincenaDiciembre',
                    'precioAlquilerSegundaQuincenaDiciembre',
                    'precioAlquilerEnero',
                    'precioAlquilerPrimeraQuincenaEnero',
                    'precioAlquilerSegundaQuincenaEnero',
                    'precioAlquilerFebrero',
                    'precioAlquilerPrimeraQuincenaFebrero',
                    'precioAlquilerSegundaQuincenaFebrero',
                    'precioAlquilerReveillon',
                    'precioAlquilerSemanaSanta',
                    'precioAlquilerVacacionesJulio', 
                    'precioAlquilerDiario',
                    'precioAlquilerMensual'
                ],
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'posicion' => '350',
            'descripcion' => 'Id de la moneda',
            'wp' => 'divisa',
            'html_comparacion' => 'divisa',
            'meli' => 'currency_id',
            'meli_comparacion' => 'currency_id',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'etiquetasXmlInfocasas' => 
                [
                    'monedaVenta',
                    'monedaAlquiler',
                    'monedaAlquilerDiciembre',
                    'monedaAlquilerPrimeraQuincenaDiciembre',
                    'monedaAlquilerSegundaQuincenaDiciembre',
                    'monedaAlquilerEnero',
                    'monedaAlquilerPrimeraQuincenaEnero',
                    'monedaAlquilerSegundaQuincenaEnero',
                    'monedaAlquilerFebrero',
                    'monedaAlquilerPrimeraQuincenaFebrero',
                    'monedaAlquilerSegundaQuincenaFebrero',
                    'monedaAlquilerReveillon',
                    'monedaAlquilerSemanaSanta',
                    'monedaAlquilerVacacionesJulio',
                    'monedaAlquilerDiario',
                    'monedaAlquilerMensual'
                ],
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Cantidad disponible',
            'wp' => '',
            'html_comparacion' => '',
            'meli' => 'stock',
            'meli_comparacion' => 'stock',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Cantidad disponible',
            'wp' => '_ofiliaria_cantidad_disponible_propiedad',
            'html_comparacion' => '',
            'meli' => 'available_quantity',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Modo de compra',
            'wp' => '_ofiliaria_modo_compra_propiedad',
            'html_comparacion' => '',
            'meli' => 'buying_mode',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'ID del paquete de publicación MELI',
            'wp' => '_ofiliaria_id_paquete_publicacion_meli',
            'html_comparacion' => '',
            'meli' => 'listing_type_id',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Contacto vendedor',
            'wp' => 'display_name',
            'html_comparacion' => '',
            'meli' => 'seller_contact->contact',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'etiquetasXmlInfocasas' => 'nombre',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Código de área teléfono contacto',
            'wp' => '',
            'html_comparacion' => '',
            'meli' => 'seller_contact->area_code',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Teléfono contacto',
            'wp' => 'mobile',
            'html_comparacion' => '',
            'meli' => 'seller_contact->phone',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'etiquetasXmlInfocasas' => 'telefono',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Email contacto',
            'wp' => 'user_email',
            'html_comparacion' => '',
            'meli' => 'seller_contact->email',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'etiquetasXmlInfocasas' => 'email',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Dirección',
            'wp' => 'property_address',
            'html_comparacion' => '',
            'meli' => 'location->address_line',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'etiquetasXmlInfocasas' => 'direccion',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Barrio',
            'wp' => 'hidden_address',
            'html_comparacion' => '',
            'meli' => 'location->neighborhood',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Ciudad',
            'wp' => 'hidden_address',
            'html_comparacion' => '',
            'meli' => 'location->city',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'etiquetasXmlInfocasas' => 'zona',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Estado',
            'wp' => 'hidden_address',
            'html_comparacion' => '',
            'meli' => 'location->state',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'etiquetasXmlInfocasas' => 'departamento',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'País',
            'wp' => 'property_country',
            'html_comparacion' => '',
            'meli' => 'location->country',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Código postal',
            'wp' => 'property_zip',
            'html_comparacion' => '',
            'meli' => 'location->zip_code',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Latitud',
            'wp' => 'property_latitude',
            'html_comparacion' => '',
            'meli' => 'location->latitude',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'etiquetasXmlInfocasas' => 'latitud',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Longitud',
            'wp' => 'property_longitude',
            'html_comparacion' => '',
            'meli' => 'location->longitude',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'etiquetasXmlInfocasas' => 'longitud',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Miniatura',
            'wp' => '_thumbnail_id',
            'html_comparacion' => '',
            'meli' => 'thumbnail',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Imágenes',
            'wp' => '_ofiliaria_media',
            'html_comparacion' => '',
            'meli' => 'pictures',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Tipo de video',
            'wp' => 'embed_video_type',
            'html_comparacion' => '',
            'meli' => 'video_id[1]',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Video del inmueble',
            'wp' => 'embed_video_id',
            'html_comparacion' => '',
            'meli' => 'video_id[0]',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'etiquetasXmlInfocasas' => 'youtube',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Tour virtual',
            'wp' => 'embed_virtual_tour',
            'html_comparacion' => '',
            'meli' => 'video_id[0]',
            'meli_comparacion' => '',
            'tipo' => 'General',
            'requerido' => true,
            'tipo_datos' => '',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'generales_requeridos',
            'etiquetasXmlInfocasas' => 'tour3d',
            'lote' => '2025-07-01',
            'informacion_adicional' => []
        ],
        // Clasificación: Generales adicionales
        [
            'descripcion' => 'Condición del ítem',
            'wp' => '_ofiliaria_condicion_deL_item',
            'html_comparacion' => '_ofiliaria_condicion_deL_item',
            'meli' => 'ITEM_CONDITION',
            'meli_comparacion' => 'ITEM_CONDITION',
            'tipo' => 'General',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'generales_adicionales',
            'lote' => '2026-02-11',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Subtipo de operación',
            'wp' => '_ofiliaria_subtipo_de_operacion',
            'html_comparacion' => '_ofiliaria_subtipo de operacion',
            'meli' => 'OPERATION_SUBTYPE',
            'meli_comparacion' => 'OPERATION_SUBTYPE',
            'tipo' => 'General',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'generales_adicionales',
            'lote' => '2026-02-11',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Con tour virtual',
            'wp' => '_ofiliaria_con_tour_virtual',
            'html_comparacion' => '_ofiliaria_con_tour_virtual',
            'meli' => 'WITH_VIRTUAL_TOUR',
            'meli_comparacion' => 'WITH_VIRTUAL_TOUR',
            'tipo' => 'General',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'generales_adicionales',
            'lote' => '2026-02-11',
                    'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        // Clasificación: Campos especificos requeridos
        [
            'descripcion' => 'Superficie total',
            'wp' => 'property_lot_size',
            'html_comparacion' => 'property_lot_size',
            'meli' => 'TOTAL_AREA',
            'meli_comparacion' => 'TOTAL_AREA',
            'tipo' => 'Específico',
            'requerido' => true,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 1,
            'clasificacion' => 'especificos_requeridos',
            'etiquetasXmlInfocasas' => 
                [   
                    'm2', 
                    'm2terreno'
                ],
            'lote' => '2025-07-02',
            'informacion_adicional' =>
                [
                    'unidades_permitidas' => 'm²'
                ]
        ],
        [
            'descripcion' => 'Área cubierta',
            'wp' => 'property_size',
            'html_comparacion' => 'property_size',
            'meli' => 'COVERED_AREA',
            'meli_comparacion' => 'COVERED_AREA',
            'tipo' => 'Específico',
            'requerido' => true,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 1,
            'clasificacion' => 'especificos_requeridos',
            'etiquetasXmlInfocasas' => 
                [
                    'm2edificados',
                    'm2apto'
                ],
            'lote' => '2025-07-02',
            'informacion_adicional' =>
                [
                    'unidades_permitidas' => 'm²'
                ]
        ],
        [
            'descripcion' => 'Dormitorios',
            'wp' => 'property_bedrooms',
            'html_comparacion' => 'property_bedrooms',
            'meli' => 'BEDROOMS',
            'meli_comparacion' => 'BEDROOMS',
            'tipo' => 'Específico',
            'requerido' => true,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 0,
            'clasificacion' => 'especificos_requeridos',
            'etiquetasXmlInfocasas' => 'idDormitorios',
            'lote' => '2025-07-02',
            'informacion_adicional' => []
        ],
        [
            'posicion' => '100',
            'descripcion' => 'Cocheras',
            'wp' => 'estacionamiento',
            'html_comparacion' => 'estacionamiento',
            'meli' => 'PARKING_LOTS',
            'meli_comparacion' => 'PARKING_LOTS',
            'tipo' => 'Específico',
            'requerido' => true,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 0,
            'clasificacion' => 'especificos_requeridos',
            'etiquetasXmlInfocasas' => 
                [
                    'garage',
                    'Cochera',
                    'Garaje'
                ],
            'lote' => '2025-07-02',
            'informacion_adicional' => []
        ],
        [
            'posicion' => '130',
            'descripcion' => 'Huéspedes',
            'wp' => '_ofiliaria_huespedes',
            'html_comparacion' => '_ofiliaria_huespedes',
            'meli' => 'GUESTS',
            'meli_comparacion' => 'GUESTS',
            'tipo' => 'Específico',
            'requerido' => true,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 1,
            'clasificacion' => 'especificos_requeridos',
            'lote' => '2025-07-02',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Baños',
            'wp' => 'property_bathrooms',
            'html_comparacion' => 'property_bathrooms',
            'meli' => 'FULL_BATHROOMS',
            'meli_comparacion' => 'FULL_BATHROOMS',
            'tipo' => 'Específico',
            'requerido' => true,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 1,
            'clasificacion' => 'especificos_requeridos',
            'etiquetasXmlInfocasas' => 'idBanios',
            'lote' => '2025-07-02',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Nombre del modelo',
            'wp' => '_ofiliaria_nombre_modelo_emprendimientos',
            'html_comparacion' => '_ofiliaria_nombre_modelo_emprendimientos',
            'meli' => 'MODEL_NAME',
            'meli_comparacion' => 'MODEL_NAME',
            'tipo' => 'Específico',
            'requerido' => true,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'especificos_requeridos',
            'lote' => '2025-07-02',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Nombre de la unidad',
            'wp' => '_ofiliaria_nombre_unidad_emprendimientos',
            'html_comparacion' => '_ofiliaria_nombre_unidad_emprendimientos',
            'meli' => 'UNIT_NAME',
            'meli_comparacion' => 'UNIT_NAME',
            'tipo' => 'Específico',
            'requerido' => true,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'especificos_requeridos',
            'lote' => '2025-07-02',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Nombre del emprendimiento',
            'wp' => '_ofiliaria_nombre_emprendimiento',
            'html_comparacion' => '_ofiliaria_nombre_emprendimiento',
            'meli' => 'DEVELOPMENT_NAME',
            'meli_comparacion' => 'DEVELOPMENT_NAME',
            'tipo' => 'Específico',
            'requerido' => true,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'especificos_requeridos',
            'lote' => '2025-07-02',
            'informacion_adicional' => []
        ],
        [
            'descripcion' => 'Estado del proyecto',
            'wp' => '_ofiliaria_estatus_proyecto_emprendimiento',
            'html_comparacion' => '_ofiliaria_estatus_proyecto_emprendimiento',
            'meli' => 'POSSESSION_STATUS',
            'meli_comparacion' => 'POSSESSION_STATUS',
            'tipo' => 'Específico',
            'requerido' => true,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'especificos_requeridos',
            'lote' => '2025-07-02',
            'informacion_adicional' => []
        ],
        [
            'posicion' => '270',
            'descripcion' => 'Acceso',
            'wp' => '_ofiliaria_acceso_lote_terreno',
            'html_comparacion' => '_ofiliaria_acceso_lote_terreno',
            'meli' => 'LAND_ACCESS',
            'meli_comparacion' => 'LAND_ACCESS',
            'tipo' => 'Específico',
            'requerido' => true,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'especificos_requeridos',
            'lote' => '2025-07-02',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Tierra' => '245049',
                            'Arena' => '245045',
                            'Asfalto' => '245046',
                            'Otro' => '245047',
                            'Ripio' => '245048'
                        ]
                ]
        ],
        // Clasificación: Campos calidad publicación
        [
            'posicion' => '40',
            'descripcion' => 'Superficie de balcón',
            'wp' => '_ofiliaria_superficie_de_balcon',
            'html_comparacion' => '_ofiliaria_superficie_de_balcon',
            'meli' => 'BALCONY_AREA',
            'meli_comparacion' => 'BALCONY_AREA',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 0,
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'unidades_permitidas' => 'm²'
                ]
        ],
        [
            'posicion' => '330',
            'descripcion' => 'Horario de contacto',
            'wp' => '_ofiliaria_horario_de_contacto',
            'html_comparacion' => '_ofiliaria_horario_de_contacto',
            'meli' => 'CONTACT_SCHEDULE',
            'meli_comparacion' => 'CONTACT_SCHEDULE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' => []
        ],
        [
            'posicion' => '90',
            'descripcion' => 'Bodegas',
            'wp' => '_ofiliaria_bodegas',
            'html_comparacion' => '_ofiliaria_bodegas',
            'meli' => 'WAREHOUSES',
            'meli_comparacion' => 'WAREHOUSES',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 0,
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'Depósito',
            'lote' => '2025-07-03',
            'informacion_adicional' => []
        ],
        [
            'posicion' => '190',
            'descripcion' => 'Cantidad de pisos',
            'wp' => '_ofiliaria_cantidad_de_pisos',
            'html_comparacion' => '_ofiliaria_cantidad_de_pisos',
            'meli' => 'FLOORS',
            'meli_comparacion' => 'FLOORS',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 1,
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'cantidadPisos',
            'lote' => '2025-07-03',
            'informacion_adicional' => []
        ],
        [
            'posicion' => '300',
            'descripcion' => 'Número del apartamento',
            'wp' => '_ofiliaria_numero_del_apartamento',
            'html_comparacion' => '_ofiliaria_numero_del_apartamento',
            'meli' => 'APARTMENT_NUMBER',
            'meli_comparacion' => 'APARTMENT_NUMBER',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' => []
        ],
        [
            'posicion' => '210',
            'descripcion' => 'Apartamentos por piso',
            'wp' => '_ofiliaria_apartamentos_por_piso',
            'html_comparacion' => '_ofiliaria_apartamentos_por_piso',
            'meli' => 'APARTMENTS_PER_FLOOR',
            'meli_comparacion' => 'APARTMENTS_PER_FLOOR',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 1,
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'aptosPorPiso',
            'lote' => '2025-07-03',
            'informacion_adicional' => []
        ],
        [
            'posicion' => '200',
            'descripcion' => 'Número de piso de la unidad',
            'wp' => '_ofiliaria_numero_de_piso_de_la_unidad',
            'html_comparacion' => '_ofiliaria_numero_de_piso_de_la_unidad',
            'meli' => 'UNIT_FLOOR',
            'meli_comparacion' => 'UNIT_FLOOR',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 0,
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'piso',
            'lote' => '2025-07-03',
            'informacion_adicional' => []
        ],
        [
            'posicion' => '160',
            'descripcion' => 'Tipo de departamento',
            'wp' => '_ofiliaria_tipo_de_departamento',
            'html_comparacion' => '_ofiliaria_tipo_de_departamento',
            'meli' => 'APARTMENT_PROPERTY_SUBTYPE',
            'meli_comparacion' => 'APARTMENT_PROPERTY_SUBTYPE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            "Semi piso" => "266324",
                            "Tríplex" => "266325",
                            "Loft" => "280798",
                            "Penthhouse" => "280799",
                            "Departamento" => "266319",
                            "Dúplex" => "266320",
                            "Monoambiente" => "266321",
                            "Ph" => "266322",
                            "Piso" => "266323",
                        ]
                ]
        ],
        [
            'posicion' => '220',
            'descripcion' => 'Disposición',
            'wp' => '_ofiliaria_disposicion',
            'html_comparacion' => '_ofiliaria_disposicion',
            'meli' => 'DISPOSITION',
            'meli_comparacion' => 'DISPOSITION',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'disposicion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            "Contrafrente" => "242076",
                            "Frente" => "242077",
                            "Interno" => "242078",
                            "Lateral" => "242079",
                        ]
                ]
        ],
        [
            'posicion' => '230',
            'descripcion' => 'Orientación',
            'wp' => '_ofiliaria_orientacion',
            'html_comparacion' => '_ofiliaria_orientacion',
            'meli' => 'FACING',
            'meli_comparacion' => 'FACING',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'orientacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            "Sur" => "242328",
                            "Oeste" => "242330",
                            "Norte" => "242327",
                            "Este" => "242329",
                        ]
                ]
        ],
        [
            'posicion' => '290',
            'descripcion' => 'Antigüedad',
            'wp' => '_ofiliaria_antiguedad',
            'html_comparacion' => '_ofiliaria_antiguedad',
            'meli' => 'PROPERTY_AGE',
            'meli_comparacion' => 'PROPERTY_AGE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 0,
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'unidades_permitidas' => 'años'
                ]
        ],
        [
            'posicion' => '320',
            'descripcion' => 'Código de la propiedad',
            'wp' => '_ofiliaria_codigo_de_la_propiedad',
            'html_comparacion' => '_ofiliaria_codigo_de_la_propiedad',
            'meli' => 'PROPERTY_CODE',
            'meli_comparacion' => 'PROPERTY_CODE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [

                ]
        ],
        [
            'posicion' => '110',
            'descripcion' => 'Camas',
            'wp' => '_ofiliaria_camas',
            'html_comparacion' => '_ofiliaria_camas',
            'meli' => 'BEDS',
            'meli_comparacion' => 'BEDS',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 0,
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'colchon',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [

                ]
        ],
        [
            'posicion' => '140',
            'descripcion' => 'Admite mascotas',
            'wp' => '_ofiliaria_admite_mascotas',
            'html_comparacion' => '_ofiliaria_admite_mascotas',
            'meli' => 'IS_SUITABLE_FOR_PETS',
            'meli_comparacion' => 'IS_SUITABLE_FOR_PETS',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'posicion' => '120',
            'descripcion' => 'Amoblado',
            'wp' => '_ofiliaria_amoblado',
            'html_comparacion' => '_ofiliaria_amoblado',
            'meli' => 'FURNISHED',
            'meli_comparacion' => 'FURNISHED',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'Equipada con muebles',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'posicion' => '50',
            'descripcion' => 'Ambientes',
            'wp' => '_ofiliaria_ambientes',
            'html_comparacion' => '_ofiliaria_ambientes',
            'meli' => 'ROOMS',
            'meli_comparacion' => 'ROOMS',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 0,
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [

                ]
        ],
        [
            'posicion' => '310',
            'descripcion' => 'Número de la casa',
            'wp' => '_ofiliaria_numero_de_la_casa',
            'html_comparacion' => '_ofiliaria_numero_de_la_casa',
            'meli' => 'HOUSE_NUMBER',
            'meli_comparacion' => 'HOUSE_NUMBER',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [

                ]
        ],
        [
            'posicion' => '170',
            'descripcion' => 'Tipo de casa',
            'wp' => '_ofiliaria_tipo_de_casa',
            'html_comparacion' => '_ofiliaria_tipo_de_casa',
            'meli' => 'HOUSE_PROPERTY_SUBTYPE',
            'meli_comparacion' => 'HOUSE_PROPERTY_SUBTYPE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            "Dúplex" => "266259",
                            "Ph" => "266260",
                            "Tríplex" => "266261",
                            "Cabaña" => "266256",
                            "Casa" => "266257",
                            "Chalet" => "266258"
                        ]
                ]
        ],
        [
            'posicion' => '250',
            'descripcion' => 'Superficie de terreno',
            'wp' => '_ofiliaria_superficie_de_terreno',
            'html_comparacion' => '_ofiliaria_superficie_de_terreno',
            'meli' => 'LAND_AREA',
            'meli_comparacion' => 'LAND_AREA',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 1,
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
            [
                'unidades_permitidas' => 'm²'
            ]
        ],
        [
            'posicion' => '60',
            'descripcion' => 'Parrillero',
            'wp' => '_ofiliaria_parrillero',
            'html_comparacion' => '_ofiliaria_parrillero',
            'meli' => 'HAS_GRILL',
            'meli_comparacion' => 'HAS_GRILL',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'Parrillero',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'Sí' => '242085',
                    'No' => '242084'
                ]
        ],
        [
            'posicion' => '150',
            'descripcion' => 'Uso comercial',
            'wp' => '_ofiliaria_uso_comercial',
            'html_comparacion' => '_ofiliaria_uso_comercial',
            'meli' => 'PROFESSIONAL_USE_ALLOWED',
            'meli_comparacion' => 'PROFESSIONAL_USE_ALLOWED',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'Sí' => '242085',
                    'No' => '242084'
                ]
        ],
        [
            'posicion' => '180',
            'descripcion' => 'Tipo de campo',
            'wp' => '_ofiliaria_tipo_de_campo',
            'html_comparacion' => '_ofiliaria_tipo_de_campo',
            'meli' => 'FARM_TYPE',
            'meli_comparacion' => 'FARM_TYPE',
            'tipo' => 'Específico',
            'requerido' => true,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            "Otro" => "245107",
                            "Frutícola" => "267215",
                            "Agrícola" => "245098",
                            "Chacra" => "245099",
                            "Criadero" => "245100",
                            "Tambero" => "245101",
                            "Floricultura" => "245102",
                            "Forestal" => "245103",
                            "Ganadero" => "245105",
                            "Haras" => "245106"
                        ]
                ]
        ],
        [
            'posicion' => '280',
            'descripcion' => 'Distancia al asfalto',
            'wp' => '_ofiliaria_distancia_al_asfalto',
            'html_comparacion' => '_ofiliaria_distancia_al_asfalto',
            'meli' => 'PAVED_ROAD_DISTANCE',
            'meli_comparacion' => 'PAVED_ROAD_DISTANCE',
            'tipo' => 'Específico',
            'requerido' => true,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 0,
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'unidades_permitidas' => 'km'
                ]
        ],
        [
            'posicion' => '260',
            'descripcion' => 'Forma del terreno',
            'wp' => '_ofiliaria_forma_del_terreno',
            'html_comparacion' => '_ofiliaria_forma_del_terreno',
            'meli' => 'LOT_SHAPE',
            'meli_comparacion' => 'LOT_SHAPE',
            'tipo' => 'Específico',
            'requerido' => true,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => '',
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            "Regular" => "245110",
                            "Irregular" => "245108",
                            "Plano" => "245109"
                        ]
                ]
        ],
        [
            'posicion' => '240',
            'descripcion' => 'Superficie cubierta del casco',
            'wp' => '_ofiliaria_superficie_cubierta_del_casco',
            'html_comparacion' => '_ofiliaria_superficie_cubierta_del_casco',
            'meli' => 'FARM_HOUSE_AREA',
            'meli_comparacion' => 'FARM_HOUSE_AREA',
            'tipo' => 'Específico',
            'requerido' => true,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 0,
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'unidades_permitidas' => 'm²'
                ]
        ],
        [
            'posicion' => '20',
            'descripcion' => 'Habitaciones',
            'wp' => 'property_rooms',
            'html_comparacion' => 'property_rooms',
            'meli' => 'FARM_HOUSE_ROOMS_NUMBER',
            'meli_comparacion' => 'FARM_HOUSE_ROOMS_NUMBER',
            'tipo' => 'Específico',
            'requerido' => true,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 0,
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [

                ]
        ],
        [
            'posicion' => '10',
            'descripcion' => 'Baño social',
            'wp' => '_ofiliaria_banio_social',
            'html_comparacion' => '_ofiliaria_banio_social',
            'meli' => 'HAS_HALF_BATH',
            'meli_comparacion' => 'HAS_HALF_BATH',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'posicion' => '30',
            'descripcion' => 'Dormitorio de servicio',
            'wp' => '_ofiliaria_dormitorio_de_servicio',
            'html_comparacion' => '_ofiliaria_dormitorio_de_servicio',
            'meli' => 'HAS_MAID_ROOM',
            'meli_comparacion' => 'HAS_MAID_ROOM',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'Dormitorio de servicio',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'posicion' => '70',
            'descripcion' => 'Piscina',
            'wp' => '_ofiliaria_piscina',
            'html_comparacion' => '_ofiliaria_piscina',
            'meli' => 'HAS_SWIMMING_POOL',
            'meli_comparacion' => 'HAS_SWIMMING_POOL',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'Piscina',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'posicion' => '80',
            'descripcion' => 'Terraza',
            'wp' => '_ofiliaria_terraza',
            'html_comparacion' => '_ofiliaria_terraza',
            'meli' => 'HAS_TERRACE',
            'meli_comparacion' => 'HAS_TERRACE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'Terraza',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'descripcion' => 'Horario check in',
            'wp' => '_ofiliaria_horario_check_in',
            'html_comparacion' => '_ofiliaria_horario_check_in',
            'meli' => 'CHECK_IN',
            'meli_comparacion' => 'CHECK_IN',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'opciones' => 
                        [
                            "00:00" => "242331", 
                            "01:00" => "242342", 
                            "02:00" => "242347", 
                            "03:00" => "242348", 
                            "04:00" => "242349", 
                            "05:00" => "242350", 
                            "06:00" => "242351", 
                            "07:00" => "242352", 
                            "08:00" => "242353", 
                            "09:00" => "242354", 
                            "10:00" => "242332", 
                            "11:00" => "242333", 
                            "12:00" => "242334", 
                            "13:00" => "242335", 
                            "14:00" => "242336", 
                            "15:00" => "242337", 
                            "16:00" => "242338", 
                            "17:00" => "242339", 
                            "18:00" => "242340", 
                            "19:00" => "242341", 
                            "20:00" => "242343", 
                            "21:00" => "242344", 
                            "22:00" => "242345", 
                            "23:00" => "242346"
                        ]
                ]
        ],
        [
            'descripcion' => 'Horario check out',
            'wp' => '_ofiliaria_horario_check_out',
            'html_comparacion' => '_ofiliaria_horario_check_out',
            'meli' => 'CHECK_OUT',
            'meli_comparacion' => 'CHECK_OUT',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'opciones' => 
                        [
                            "00:00" => "242355",
                            "01:00" => "242366",
                            "02:00" => "242371",
                            "03:00" => "242372",
                            "04:00" => "242373",
                            "05:00" => "242374",
                            "06:00" => "242375",
                            "07:00" => "242376",
                            "08:00" => "242377",
                            "09:00" => "242378",
                            "10:00" => "242356",
                            "11:00" => "242357",
                            "12:00" => "242358",
                            "13:00" => "242359",
                            "14:00" => "242360",
                            "15:00" => "242361",
                            "16:00" => "242362",
                            "17:00" => "242363",
                            "18:00" => "242364",
                            "19:00" => "242365",
                            "20:00" => "242367",
                            "21:00" => "242368",
                            "22:00" => "242369",
                            "23:00" => "242370"
                        ]
                ]
        ],
        [
            'descripcion' => 'Servicio de desayuno',
            'wp' => '_ofiliaria_servicio_de_desayuno',
            'html_comparacion' => '_ofiliaria_servicio_de_desayuno',
            'meli' => 'BREAKFAST_SERVICE',
            'meli_comparacion' => 'BREAKFAST_SERVICE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'descripcion' => 'Servicio de limpieza',
            'wp' => '_ofiliaria_servicio_de_limpieza',
            'html_comparacion' => '_ofiliaria_servicio_de_limpieza',
            'meli' => 'HOUSEKEEPING_SERVICE',
            'meli_comparacion' => 'HOUSEKEEPING_SERVICE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'descripcion' => 'Estadía mínima (noches)',
            'wp' => '_ofiliaria_estadia_minima_noches',
            'html_comparacion' => '_ofiliaria_estadia_minima_noches',
            'meli' => 'MINIMUM_STAY',
            'meli_comparacion' => 'MINIMUM_STAY',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 0,
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'estadiaMinima',
            'lote' => '2025-07-03',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                        ]
                ]
        ],
        [
            'descripcion' => 'Año de construcción de la propiedad',
            'wp' => '_ofiliaria_anio_construccion_de_la_propiedad',
            'html_comparacion' => '_ofiliaria_anio_construccion_de_la_propiedad',
            'meli' => '',
            'meli_comparacion' => '',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 0,
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'anioConstruccion',
            'lote' => '2025-08-18',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [

                        ]
                ]
        ],
        [
            'descripcion' => 'Sobre (disposición de la propiedad)',
            'wp' => '_ofiliaria_sobre',
            'html_comparacion' => '_ofiliaria_sobre',
            'meli' => '',
            'meli_comparacion' => '',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => "A",
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'sobre',
            'lote' => '2025-08-18',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sobre rambla' => 2,
                            'Sobre avenida' => 3
                        ]
                ]
        ],
        [
            'descripcion' => 'Vivienda social',
            'wp' => '_ofiliaria_vivienda_social',
            'html_comparacion' => '_ofiliaria_vivienda_social',
            'meli' => '',
            'meli_comparacion' => '',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => "A",
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'vivienda',
            'lote' => '2025-08-18',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => 1,
                            'No' => 0
                        ]
                ]
        ],
        [
            'descripcion' => 'Estado de la propiedad',
            'wp' => '_ofiliaria_estado',
            'html_comparacion' => '_ofiliaria_estado',
            'meli' => '',
            'meli_comparacion' => '',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => "A",
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'estado',
            'lote' => '2025-08-18',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'A estrenar' => 1,
                            'Reciclada' => 2,
                            'Excelente estado' => 3,
                            'Buen estado' => 4,
                            'Requiere mantenimiento' => 5,
                            'A reciclar' => 6,
                            'A definir' => 7,
                            'En construcción' => 8,
                            'En pozo' => 9
                        ]
                ]
        ],
        [
            'descripcion' => 'Metros cuadrados de la terraza de la propiedad',
            'wp' => '_ofiliaria_m2_terraza_propiedad',
            'html_comparacion' => '_ofiliaria_m2_terraza_propiedad',
            'meli' => '',
            'meli_comparacion' => '',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 0,
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'm2terrazas',
            'lote' => '2025-08-18',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [

                        ]
                ]
        ],
        [
            'descripcion' => 'Acepta permuta',
            'wp' => '_ofiliaria_acepta_permuta',
            'html_comparacion' => '_ofiliaria_acepta_permuta',
            'meli' => '',
            'meli_comparacion' => '',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => "A",
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'permuta',
            'lote' => '2025-08-20',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => 1,
                            'No' => 2
                        ]
                ]
        ],
        [
            'descripcion' => 'Cantidad de plantas de la propiedad',
            'wp' => '_ofiliaria_cantidad_plantas_propiedad',
            'html_comparacion' => '_ofiliaria_cantidad_plantas_propiedad',
            'meli' => '',
            'meli_comparacion' => '',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 0,
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'plantas',
            'lote' => '2025-08-21',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                        ]
                ]
        ],
        [
            'descripcion' => 'Gastos comunes de la propiedad',
            'wp' => '_ofiliaria_gastos_comunes_propiedad',
            'html_comparacion' => '_ofiliaria_gastos_comunes_propiedad',
            'meli' => 'MAINTENANCE_FEE',
            'meli_comparacion' => 'MAINTENANCE_FEE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 0,
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'gc',
            'lote' => '2025-08-22',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'unidades_permitidas' => 'UYU'
                        ]
                ]
        ],
        [
            'descripcion' => 'Moneda de los gastos comunes',
            'wp' => '_ofiliaria_moneda_gastos_comunes',
            'html_comparacion' => '_ofiliaria_moneda_gastos_comunes',
            'meli' => '',
            'meli_comparacion' => '',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'IDmonedagc',
            'lote' => '2025-08-22',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'USD' => 1,
                            'UYU' => 2
                        ]
                ]
        ],
        [
            'descripcion' => 'Apto para oficina',
            'wp' => '_ofiliaria_apto_para_oficina',
            'html_comparacion' => '_ofiliaria_apto_para_oficina',
            'meli' => '',
            'meli_comparacion' => '',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'numérico',
            'valor_minimo_permitido' => 0,
            'clasificacion' => 'calidad_publicacion',
            'etiquetasXmlInfocasas' => 'oficina',
            'lote' => '2025-10-06',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            '0' => 0,
                            '1' => 1
                        ]
                ]
        ],
        // Clasificación: Adicional Servicios
        [
            'creado_html' => 'Sí',
            'descripcion' => 'Acceso a internet',
            'wp' => '_ofiliaria_adicional_servicios_acceso_a_internet',
            'html_comparacion' => '_ofiliaria_adicional_servicios_acceso_a_internet',
            'meli' => 'HAS_INTERNET_ACCESS',
            'meli_comparacion' => 'HAS_INTERNET_ACCESS',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_servicios',
            'lote' => '2025-07-04',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Gas natural',
            'wp' => '_ofiliaria_adicional_servicios_gas_natural',
            'html_comparacion' => '_ofiliaria_adicional_servicios_gas_natural',
            'meli' => 'HAS_NATURAL_GAS',
            'meli_comparacion' => 'HAS_NATURAL_GAS',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_servicios',
            'etiquetasXmlInfocasas' => 'Gas por cañería',
            'lote' => '2025-07-04',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Línea telefónica',
            'wp' => '_ofiliaria_adicional_servicios_linea_telefonica',
            'html_comparacion' => '_ofiliaria_adicional_servicios_linea_telefonica',
            'meli' => 'HAS_TELEPHONE_LINE',
            'meli_comparacion' => 'HAS_TELEPHONE_LINE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_servicios',
            'lote' => '2025-07-04',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'TV por cable',
            'wp' => '_ofiliaria_adicional_servicios_tv_por_cable',
            'html_comparacion' => '_ofiliaria_adicional_servicios_tv_por_cable',
            'meli' => 'HAS_CABLE_TV',
            'meli_comparacion' => 'HAS_CABLE_TV',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_servicios',
            'etiquetasXmlInfocasas' => 'Instalación de TV por cable',
            'lote' => '2025-07-04',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Aire acondicionado',
            'wp' => '_ofiliaria_adicional_servicios_aire_acondicionado',
            'html_comparacion' => '_ofiliaria_adicional_servicios_aire_acondicionado',
            'meli' => 'HAS_AIR_CONDITIONING',
            'meli_comparacion' => 'HAS_AIR_CONDITIONING',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_servicios',
            'etiquetasXmlInfocasas' => 'Aire acondicionado',
            'lote' => '2025-07-04',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Calefacción',
            'wp' => '_ofiliaria_adicional_servicios_calefaccion',
            'html_comparacion' => '_ofiliaria_adicional_servicios_calefaccion',
            'meli' => 'HAS_HEATING',
            'meli_comparacion' => 'HAS_HEATING',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_servicios',
            'etiquetasXmlInfocasas' => 
                [
                    'Calefacción',
                    'Calefacción individual',
                    'Calefacción central'
                ],
            'lote' => '2025-07-04',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Agua corriente',
            'wp' => '_ofiliaria_adicional_servicios_agua_corriente',
            'html_comparacion' => '_ofiliaria_adicional_servicios_agua_corriente',
            'meli' => 'HAS_TAP_WATER',
            'meli_comparacion' => 'HAS_TAP_WATER',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_servicios',
            'lote' => '2025-07-04',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Caldera a gas/ eléctrica',
            'wp' => '_ofiliaria_adicional_servicios_caldera_a_gas_electrica',
            'html_comparacion' => '_ofiliaria_adicional_servicios_caldera_a_gas_electrica',
            'meli' => 'HAS_BOILER',
            'meli_comparacion' => 'HAS_BOILER',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_servicios',
            'lote' => '2025-07-04',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Con energia solar',
            'wp' => '_ofiliaria_adicional_servicios_con_energia_solar',
            'html_comparacion' => '_ofiliaria_adicional_servicios_con_energia_solar',
            'meli' => 'WITH_SOLAR_ENERGY',
            'meli_comparacion' => 'WITH_SOLAR_ENERGY',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_servicios',
            'lote' => '2025-07-04',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Con conexión para lavarropas',
            'wp' => '_ofiliaria_adicional_servicios_con_conexion_para_lavarropas',
            'html_comparacion' => '_ofiliaria_adicional_servicios_con_conexion_para_lavarropas',
            'meli' => 'WITH_LAUNDRY_CONNECTION',
            'meli_comparacion' => 'WITH_LAUNDRY_CONNECTION',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_servicios',
            'lote' => '2025-07-04',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Grupo electrógeno',
            'wp' => '_ofiliaria_adicional_servicios_grupo_electrogeno',
            'html_comparacion' => '_ofiliaria_adicional_servicios_grupo_electrogeno',
            'meli' => 'HAS_ELECTRIC_GENERATOR',
            'meli_comparacion' => 'HAS_ELECTRIC_GENERATOR',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_servicios',
            'lote' => '2025-07-04',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Grupo electrógeno',
            'wp' => '_ofiliaria_adicional_servicios_grupo_electrogeno',
            'html_comparacion' => '_ofiliaria_adicional_servicios_grupo_electrogeno',
            'meli' => 'WITH_ELECTRIC_GENERATOR',
            'meli_comparacion' => 'WITH_ELECTRIC_GENERATOR',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_servicios',
            'lote' => '2025-07-04',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Con TV satelital',
            'wp' => '_ofiliaria_adicional_servicios_con_tv_satelital',
            'html_comparacion' => '_ofiliaria_adicional_servicios_con_tv_satelital',
            'meli' => 'WITH_SATELITE_TV',
            'meli_comparacion' => 'WITH_SATELITE_TV',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_servicios',
            'lote' => '2025-07-04',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Jardinero',
            'wp' => '_ofiliaria_adicional_servicios_jardinero',
            'html_comparacion' => '_ofiliaria_adicional_servicios_jardinero',
            'meli' => 'WITH_GARDENER',
            'meli_comparacion' => 'WITH_GARDENER',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_servicios',
            'lote' => '2025-07-04',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Luz eléctrica',
            'wp' => '_ofiliaria_adicional_servicios_luz_electrica',
            'html_comparacion' => '_ofiliaria_adicional_servicios_luz_electrica',
            'meli' => 'HAS_ELECTRIC_LIGHT',
            'meli_comparacion' => 'HAS_ELECTRIC_LIGHT',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_servicios',
            'lote' => '2025-07-04',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Saneamiento',
            'wp' => '_ofiliaria_adicional_servicios_saneamiento',
            'html_comparacion' => '_ofiliaria_adicional_servicios_saneamiento',
            'meli' => 'HAS_DRAINAGE',
            'meli_comparacion' => 'HAS_DRAINAGE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_servicios',
            'lote' => '2025-07-04',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Tiene sistema contra incendio',
            'wp' => '_ofiliaria_adicional_servicios_saneamiento_sistema_contra_incendio',
            'html_comparacion' => '_ofiliaria_adicional_servicios_saneamiento_sistema_contra_incendio',
            'meli' => 'HAS_FIRE_SYSTEM',
            'meli_comparacion' => 'HAS_FIRE_SYSTEM',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_servicios',
            'lote' => '2026-01-13',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        // Clasificación: Adicional Comodidades y Equipamiento
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Ascensor',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_ascensor',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_ascensor',
            'meli' => 'HAS_LIFT',
            'meli_comparacion' => 'HAS_LIFT',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'etiquetasXmlInfocasas' => 'Ascensor',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Cancha de básquetbol',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol',
            'meli' => 'HAS_BASKETBALL_COURT',
            'meli_comparacion' => 'HAS_BASKETBALL_COURT',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Cancha de paddle',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle',
            'meli' => 'HAS_PADDLE_COURT',
            'meli_comparacion' => 'HAS_PADDLE_COURT',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Cancha de tenis',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis',
            'meli' => 'HAS_TENNIS_COURT',
            'meli_comparacion' => 'HAS_TENNIS_COURT',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Con cancha de fútbol',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol',
            'meli' => 'WITH_SOCCER_FIELD',
            'meli_comparacion' => 'WITH_SOCCER_FIELD',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Con cancha polideportiva',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva',
            'meli' => 'WITH_MULTIPURPOSE_SPORT_COURT',
            'meli_comparacion' => 'WITH_MULTIPURPOSE_SPORT_COURT',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Canchas de usos múltiples',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples',
            'meli' => 'HAS_MULTIPLE_USE_COURT',
            'meli_comparacion' => 'HAS_MULTIPLE_USE_COURT',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'etiquetasXmlInfocasas' => 'Salón de uso común',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Chimenea',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_chimenea',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_chimenea',
            'meli' => 'HAS_INDOOR_FIREPLACE',
            'meli_comparacion' => 'HAS_INDOOR_FIREPLACE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Con área verde',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_con_area_verde',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_con_area_verde',
            'meli' => 'WITH_GREEN_AREA',
            'meli_comparacion' => 'WITH_GREEN_AREA',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Estacionamiento para visitas',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas',
            'meli' => 'HAS_GUEST_PARKING',
            'meli_comparacion' => 'HAS_GUEST_PARKING',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Gimnasio',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_gimnasio',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_gimnasio',
            'meli' => 'HAS_GYM',
            'meli_comparacion' => 'HAS_GYM',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'etiquetasXmlInfocasas' => 'GYM',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Heladera',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_heladera',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_heladera',
            'meli' => 'HAS_FRIDGE',
            'meli_comparacion' => 'HAS_FRIDGE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Heladera',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_heladera',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_heladera',
            'meli' => 'HAS_REFRIGERATOR',
            'meli_comparacion' => 'HAS_REFRIGERATOR',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Jacuzzi',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_jacuzzi',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_jacuzzi',
            'meli' => 'HAS_JACUZZI',
            'meli_comparacion' => 'HAS_JACUZZI',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'etiquetasXmlInfocasas' => 'Jacuzzi',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Salón de fiestas',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas',
            'meli' => 'HAS_PARTY_ROOM',
            'meli_comparacion' => 'HAS_PARTY_ROOM',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Sauna',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_sauna',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_sauna',
            'meli' => 'HAS_SAUNA',
            'meli_comparacion' => 'HAS_SAUNA',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'etiquetasXmlInfocasas' => 'Sauna',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Área de cine',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_area_de_cine',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_area_de_cine',
            'meli' => 'HAS_CINEMA_HALL',
            'meli_comparacion' => 'HAS_CINEMA_HALL',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Área de juegos infantiles',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles',
            'meli' => 'HAS_PLAYGROUND',
            'meli_comparacion' => 'HAS_PLAYGROUND',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Cisterna',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_cisterna',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_cisterna',
            'meli' => 'HAS_CISTERN',
            'meli_comparacion' => 'HAS_CISTERN',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'descripcion' => 'Número de torre',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_numero_de_torre',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_numero_de_torre',
            'meli' => 'TOWER_NUMBER',
            'meli_comparacion' => 'TOWER_NUMBER',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [

                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Cowork',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_cowork',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_cowork',
            'meli' => 'HAS_BUSINESS_CENTER',
            'meli_comparacion' => 'HAS_BUSINESS_CENTER',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Rampa para silla de ruedas',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas',
            'meli' => 'WHEELCHAIR_RAMP',
            'meli_comparacion' => 'WHEELCHAIR_RAMP',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Recepción',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_recepcion',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_recepcion',
            'meli' => 'HAS_FRONT_DESK',
            'meli_comparacion' => 'HAS_FRONT_DESK',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Bebederos',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_bebederos',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_bebederos',
            'meli' => 'HAS_WATERERS',
            'meli_comparacion' => 'HAS_WATERERS',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Casco',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_casco',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_casco',
            'meli' => 'FARM_HOUSE',
            'meli_comparacion' => 'FARM_HOUSE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Corral',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_corral',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_corral',
            'meli' => 'HAS_FARMYARD',
            'meli_comparacion' => 'HAS_FARMYARD',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Galpón',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_galpon',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_galpon',
            'meli' => 'HAS_FARM_SHED',
            'meli_comparacion' => 'HAS_FARM_SHED',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Molinos',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_molinos',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_molinos',
            'meli' => 'HAS_MILLS',
            'meli_comparacion' => 'HAS_MILLS',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Silos',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_silos',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_silos',
            'meli' => 'HAS_SILO',
            'meli_comparacion' => 'HAS_SILO',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Tanque de agua',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua',
            'meli' => 'HAS_WATER_TANK',
            'meli_comparacion' => 'HAS_WATER_TANK',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Lavarropa',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_lavarropa',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_lavarropa',
            'meli' => 'HAS_WASHING_MACHINE',
            'meli_comparacion' => 'HAS_WASHING_MACHINE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Microondas',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_microondas',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_microondas',
            'meli' => 'HAS_MICROWAVE',
            'meli_comparacion' => 'HAS_MICROWAVE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'TV',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_tv',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_tv',
            'meli' => 'HAS_TV',
            'meli_comparacion' => 'HAS_TV',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'html_creado' => 'Sí',
            'descripcion' => 'Vajilla',
            'wp' => '_ofiliaria_adicional_comodidades_equipamiento_vajilla',
            'html_comparacion' => '_ofiliaria_adicional_comodidades_equipamiento_vajilla',
            'meli' => 'HAS_CUTLERY',
            'meli_comparacion' => 'HAS_CUTLERY',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_comodidades_equipamiento',
            'lote' => '2025-07-05',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        // Clasificación: Adicional Seguridad
        [
            'descripcion' => 'Alarma',
            'wp' => '_ofiliaria_adicional_seguridad_alarma',
            'html_comparacion' => '_ofiliaria_adicional_seguridad_alarma',
            'meli' => 'HAS_ALARM',
            'meli_comparacion' => 'HAS_ALARM',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_seguridad',
            'etiquetasXmlInfocasas' => 'alarma',
            'lote' => '2025-07-06',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'descripcion' => 'Portón automático',
            'wp' => '_ofiliaria_adicional_seguridad_porton_automatico',
            'html_comparacion' => '_ofiliaria_adicional_seguridad_porton_automatico',
            'meli' => 'HAS_ELECTRIC_GATE_OPENER',
            'meli_comparacion' => 'HAS_ELECTRIC_GATE_OPENER',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_seguridad',
            'etiquetasXmlInfocasas' => 'portón eléctrico',
            'lote' => '2025-07-06',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'descripcion' => 'Circuito de cámaras de seguridad',
            'wp' => '_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad',
            'html_comparacion' => '_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad',
            'meli' => 'HAS_SECURITY',
            'meli_comparacion' => 'HAS_SECURITY',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_seguridad',
            'etiquetasXmlInfocasas' => 'cámaras CCTV',
            'lote' => '2025-07-06',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'descripcion' => 'Tipo de seguridad',
            'wp' => '_ofiliaria_adicional_seguridad_tipo_de_seguridad',
            'html_comparacion' => '_ofiliaria_adicional_seguridad_tipo_de_seguridad',
            'meli' => 'SECURITY_TYPE',
            'meli_comparacion' => 'SECURITY_TYPE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_seguridad',
            'lote' => '2025-07-06',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            "24 hs" => "14263186",
                            "Diurno" => "13836688", 
                            "Nocturno" => "13836689", 
                            "Virtual" => "13836690" 
                        ]
                ]
        ],
        [
            'descripcion' => 'Acceso controlado',
            'wp' => '_ofiliaria_adicional_seguridad_acceso_controlado',
            'html_comparacion' => '_ofiliaria_adicional_seguridad_acceso_controlado',
            'meli' => 'HAS_CONTROLLED_ACCESS',
            'meli_comparacion' => 'HAS_CONTROLLED_ACCESS',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_seguridad',
            'etiquetasXmlInfocasas' => 
                [
                    'portería 24hrs',
                    'guardia de seguridad'
                ],
            'lote' => '2025-07-06',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'descripcion' => 'Con barrio cerrado',
            'wp' => '_ofiliaria_adicional_seguridad_con_barrio_cerrado',
            'html_comparacion' => '_ofiliaria_adicional_seguridad_con_barrio_cerrado',
            'meli' => 'WITH_GATED_COMMUNITY',
            'meli_comparacion' => 'WITH_GATED_COMMUNITY',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_seguridad',
            'etiquetasXmlInfocasas' => 
                [
                    'cerca perimetral',
                    'rejas'
                ],
            'lote' => '2025-07-06',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        // Clasificación: Adicional Ambientes
        [
            'descripcion' => 'Altillo',
            'wp' => '_ofiliaria_adicional_ambientes_altillo',
            'html_comparacion' => '_ofiliaria_adicional_ambientes_altillo',
            'meli' => 'HAS_ATTIC',
            'meli_comparacion' => 'HAS_ATTIC',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_ambientes',
            'etiquetasXmlInfocasas' => 'Altillo',
            'lote' => '2025-07-07',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],        
        [
            'descripcion' => 'Balcón',
            'wp' => '_ofiliaria_adicional_ambientes_balcon',
            'html_comparacion' => '_ofiliaria_adicional_ambientes_balcon',
            'meli' => 'HAS_BALCONY',
            'meli_comparacion' => 'HAS_BALCONY',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_ambientes',
            'etiquetasXmlInfocasas' => 'Balcón',
            'lote' => '2025-07-07',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],    
        [
            'descripcion' => 'Cocina',
            'wp' => '_ofiliaria_adicional_ambientes_cocina',
            'html_comparacion' => '_ofiliaria_adicional_ambientes_cocina',
            'meli' => 'HAS_KITCHEN',
            'meli_comparacion' => 'HAS_KITCHEN',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_ambientes',
            'lote' => '2025-07-07',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],    
        [
            'descripcion' => 'Comedor',
            'wp' => '_ofiliaria_adicional_ambientes_comedor',
            'html_comparacion' => '_ofiliaria_adicional_ambientes_comedor',
            'meli' => 'HAS_DINNING_ROOM',
            'meli_comparacion' => 'HAS_DINNING_ROOM',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_ambientes',
            'lote' => '2025-07-07',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],    
        [
            'descripcion' => 'Dormitorio en suite',
            'wp' => '_ofiliaria_adicional_ambientes_dormitorio_en_suite',
            'html_comparacion' => '_ofiliaria_adicional_ambientes_dormitorio_en_suite',
            'meli' => 'HAS_BEDROOM_SUITE',
            'meli_comparacion' => 'HAS_BEDROOM_SUITE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_ambientes',
            'lote' => '2025-07-07',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],    
        [
            'descripcion' => 'Estudio',
            'wp' => '_ofiliaria_adicional_ambientes_estudio',
            'html_comparacion' => '_ofiliaria_adicional_ambientes_estudio',
            'meli' => 'HAS_STUDY',
            'meli_comparacion' => 'HAS_STUDY',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_ambientes',
            'lote' => '2025-07-07',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],    
        [
            'descripcion' => 'Living',
            'wp' => '_ofiliaria_adicional_ambientes_living',
            'html_comparacion' => '_ofiliaria_adicional_ambientes_living',
            'meli' => 'HAS_LIVING_ROOM',
            'meli_comparacion' => 'HAS_LIVING_ROOM',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_ambientes',
            'lote' => '2025-07-07',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],    
        [
            'descripcion' => 'Patio',
            'wp' => '_ofiliaria_adicional_ambientes_patio',
            'html_comparacion' => '_ofiliaria_adicional_ambientes_patio',
            'meli' => 'HAS_PATIO',
            'meli_comparacion' => 'HAS_PATIO',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_ambientes',
            'etiquetasXmlInfocasas' => 'Patio',
            'lote' => '2025-07-07',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],    
        [
            'descripcion' => 'Placards',
            'wp' => '_ofiliaria_adicional_ambientes_placards',
            'html_comparacion' => '_ofiliaria_adicional_ambientes_placards',
            'meli' => 'HAS_CLOSETS',
            'meli_comparacion' => 'HAS_CLOSETS',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_ambientes',
            'etiquetasXmlInfocasas' => 
                [
                    'Placard en cocina',
                    'Placard en dormitorio'
                ],
            'lote' => '2025-07-07',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],    
        [
            'descripcion' => 'Cuarto de juegos',
            'wp' => '_ofiliaria_adicional_ambientes_cuarto_de_juegos',
            'html_comparacion' => '_ofiliaria_adicional_ambientes_cuarto_de_juegos',
            'meli' => 'HAS_PLAYROOM',
            'meli_comparacion' => 'HAS_PLAYROOM',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_ambientes',
            'etiquetasXmlInfocasas' => 'Playroom',
            'lote' => '2025-07-07',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],    
        [
            'descripcion' => 'Con lavadero',
            'wp' => '_ofiliaria_adicional_ambientes_con_lavadero',
            'html_comparacion' => '_ofiliaria_adicional_ambientes_con_lavadero',
            'meli' => 'HAS_LAUNDRY',
            'meli_comparacion' => 'HAS_LAUNDRY',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_ambientes',
            'etiquetasXmlInfocasas' => 'Lavadero',
            'lote' => '2025-07-07',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],    
        [
            'descripcion' => 'Vestidor',
            'wp' => '_ofiliaria_adicional_ambientes_vestidor',
            'html_comparacion' => '_ofiliaria_adicional_ambientes_vestidor',
            'meli' => 'HAS_DRESSING_ROOM',
            'meli_comparacion' => 'HAS_DRESSING_ROOM',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_ambientes',
            'etiquetasXmlInfocasas' => 'Vestidor',
            'lote' => '2025-07-07',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],    
        [
            'descripcion' => 'Desayunador',
            'wp' => '_ofiliaria_adicional_ambientes_desayunador',
            'html_comparacion' => '_ofiliaria_adicional_ambientes_desayunador',
            'meli' => 'HAS_BREAKFAST_BAR',
            'meli_comparacion' => 'HAS_BREAKFAST_BAR',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_ambientes',
            'lote' => '2025-07-07',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],    
        [
            'descripcion' => 'Desayunador',
            'wp' => '_ofiliaria_adicional_ambientes_desayunador',
            'html_comparacion' => '_ofiliaria_adicional_ambientes_desayunador',
            'meli' => 'WITH_BREAKFAST_BAR',
            'meli_comparacion' => 'WITH_BREAKFAST_BAR',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_ambientes',
            'lote' => '2025-07-07',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],    
        [
            'descripcion' => 'Jardín',
            'wp' => '_ofiliaria_adicional_ambientes_jardin',
            'html_comparacion' => '_ofiliaria_adicional_ambientes_jardin',
            'meli' => 'HAS_GARDEN',
            'meli_comparacion' => 'HAS_GARDEN',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_ambientes',
            'etiquetasXmlInfocasas' => 'Jardín',
            'lote' => '2025-07-07',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],   
        // Clasificación: Adicional Condiciones Especiales
        [
            'descripcion' => 'Solo familias',
            'wp' => '_ofiliaria_adicional_condiciones_especiales_solo_familias',
            'html_comparacion' => '_ofiliaria_adicional_condiciones_especiales_solo_familias',
            'meli' => 'ONLY_FAMILIES',
            'meli_comparacion' => 'ONLY_FAMILIES',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_condiciones_especiales',
            'lote' => '2025-07-08',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],  
        [
            'descripcion' => 'Disponible desde',
            'wp' => '_ofiliaria_adicional_condiciones_especiales_disponible_desde',
            'html_comparacion' => '_ofiliaria_adicional_condiciones_especiales_disponible_desde',
            'meli' => 'AVAILABLE',
            'meli_comparacion' => 'AVAILABLE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_condiciones_especiales',
            'lote' => '2025-07-08',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                        ]
                ]
        ],
        [
            'descripcion' => 'Apto para familias con niños',
            'wp' => '_ofiliaria_adicional_condiciones_especiales_apto_para_familias_con_ninios',
            'html_comparacion' => '_ofiliaria_adicional_condiciones_especiales_apto_para_familias_con_ninios',
            'meli' => 'CHILDREN_WELCOME',
            'meli_comparacion' => 'CHILDREN_WELCOME',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_condiciones_especiales',
            'lote' => '2025-07-08',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],        
        [
            'descripcion' => 'Se admiten mascotas',
            'wp' => '_ofiliaria_adicional_condiciones_especiales_se_admiten_mascotas',
            'html_comparacion' => '_ofiliaria_adicional_condiciones_especiales_se_admiten_mascotas',
            'meli' => 'PETS_ALLOWED',
            'meli_comparacion' => 'PETS_ALLOWED',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_condiciones_especiales',
            'lote' => '2025-07-08',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],                
        // Clasificación: Adicional Otros
        [
            'descripcion' => 'Solo familias',
            'wp' => '_ofiliaria_adicional_otros_solo_familias',
            'html_comparacion' => '_ofiliaria_adicional_otros_solo_familias',
            'meli' => 'ONLY_FAMILIES',
            'meli_comparacion' => 'ONLY_FAMILIES',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_otros',
            'lote' => '2025-07-09',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],          
        [
            'descripcion' => 'Factor multiplicador de renta',
            'wp' => '_ofiliaria_adicional_otros_factor_multiplicador_de_renta',
            'html_comparacion' => '_ofiliaria_adicional_otros_factor_multiplicador_de_renta',
            'meli' => 'MONTHLY_RENT_FACTOR',
            'meli_comparacion' => 'MONTHLY_RENT_FACTOR',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_otros',
            'lote' => '2025-07-09',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                        ]
                ]
        ],     
        [
            'descripcion' => 'Acceso controlado',
            'wp' => '_ofiliaria_adicional_otros_acceso_controlado',
            'html_comparacion' => '_ofiliaria_adicional_otros_acceso_controlado',
            'meli' => 'WITH_CONTROLLED_ACCESS',
            'meli_comparacion' => 'WITH_CONTROLLED_ACCESS',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_otros',
            'lote' => '2025-07-09',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                        ]
                ]
        ],       
        [
            'descripcion' => 'Azotea',
            'wp' => '_ofiliaria_adicional_otros_azotea',
            'html_comparacion' => '_ofiliaria_adicional_otros_azotea',
            'meli' => 'HAS_ROOF_GARDEN',
            'meli_comparacion' => 'HAS_ROOF_GARDEN',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_otros',
            'lote' => '2025-07-09',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                        ]
                ]
        ],       
        // Clasificación: Adicional Espacios comunes, lote 10
        [
            'descripcion' => 'Salón de usos múltiples',
            'wp' => '_ofiliaria_adicional_espacios_comunes_salon_de_usos_multiples',
            'html_comparacion' => '_ofiliaria_adicional_espacios_comunes_salon_de_usos_multiples',
            'meli' => 'HAS_MULTIPURPOSE_ROOM',
            'meli_comparacion' => 'HAS_MULTIPURPOSE_ROOM',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_espacios_comunes',
            'lote' => '2025-07-10',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],
        [
            'descripcion' => 'Área de lavandería',
            'wp' => '_ofiliaria_adicional_espacios_comunes_area_de_lavanderia',
            'html_comparacion' => '_ofiliaria_adicional_espacios_comunes_area_de_lavanderia',
            'meli' => 'HAS_COMMON_LAUNDRY',
            'meli_comparacion' => 'HAS_COMMON_LAUNDRY',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_espacios_comunes',
            'etiquetasXmlInfocasas' => 'Lavandería',
            'lote' => '2025-07-10',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],  
        [
            'descripcion' => 'Caballeriza',
            'wp' => '_ofiliaria_adicional_espacios_comunes_caballeriza',
            'html_comparacion' => '_ofiliaria_adicional_espacios_comunes_caballeriza',
            'meli' => 'HAS_STABLE',
            'meli_comparacion' => 'HAS_STABLE',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_espacios_comunes',
            'lote' => '2025-07-10',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],  
        [
            'descripcion' => 'Cancha de fútbol',
            'wp' => '_ofiliaria_adicional_espacios_comunes_cancha_de_futbol',
            'html_comparacion' => '_ofiliaria_adicional_espacios_comunes_cancha_de_futbol',
            'meli' => 'HAS_FOOTBALL_PITCH',
            'meli_comparacion' => 'HAS_FOOTBALL_PITCH',
            'tipo' => 'Específico',
            'requerido' => false,
            'tipo_datos' => 'texto',
            'valor_minimo_permitido' => 'A',
            'clasificacion' => 'adicional_espacios_comunes',
            'lote' => '2025-07-10',
            'informacion_adicional' =>
                [
                    'opciones' =>
                        [
                            'Sí' => '242085',
                            'No' => '242084'
                        ]
                ]
        ],                                      
    ];