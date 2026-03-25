<?php
$infocasas_campos =
    [
    'casa' =>
        [
            'general' =>
                [
                    'id' => 'id', 
                    'tipoPropiedad' => 'tipoPropiedad', 
                    'tipoOperacion' => 'tipoOperacion', 
                    'departamento' => 'departamento', 
                    'zona' => 'zona', 
                    'idDormitorios' => 'idDormitorios', 
                    'idBanios' => 'idBanios', 
                    'estado' => 'estado', 

                    'comodidades' =>
                        [
                            'Agua caliente central' => 38,
                            'Aire acondicionado' => 39,
                            'Altillo' => 40,
                            'Balcón' => 41,
                            'Barbacoa' => 42,
                            'Box' => 43,
                            'Bungalow' => 44,
                            'Calefacción' => 45,
                            'Calefón' => 46,
                            'Cochera' => 47,
                            'Depósito' => 48,
                            'Dormitorio de servicio' => 49,
                            'Estufa a Leña' => 50,
                            'Garaje' => 51,
                            'Gas por cañería' => 52,
                            'GYM' => 53,
                            'Instalación de TV por cable' => 54,
                            'Jacuzzi' => 55,
                            'Lavandería' => 56,
                            'Línea blanca' => 57,
                            'Losa radiante' => 58,
                            'Parrillero' => 59,
                            'Piscina' => 60,
                            'Placard en cocina' => 61,
                            'Placard en dormitorio' => 62,
                            'Playroom' => 63,
                            'Previsión A.A.' => 64,
                            'Sótano' => 65,
                            'Terraza' => 66,
                            'Terraza lavadero' => 67,
                            'Vestidor' => 68,
                            'Equipada con muebles' => 69,
                            'Jardín' => 70,
                            'Patio' => 72,
                            'Lavadero' => 74,
                            'Sauna' => 76,
                        ], 

                    'seguridad' => 
                        [
                            'alarma' => 1,
                            'cámaras CCTV' => 2,
                            'cerca perimetral' => 3,
                            'portería 24hrs' => 4,
                            'portón eléctrico' => 5,
                            'rejas' => 6,
                            'guardia de seguridad' => 7,
                            'seguridad para niños' => 8
                        ], 

                    'm2' => 'm2', 
                    'm2terreno' => 'm2terreno', 
                    'm2edificados' => 'm2edificados', 
                    'm2terrazas' => 'm2terrazas', 
                    'plantas' => 'plantas', 
                    'orientacion' => 'orientacion', 
                    'disposicion' => 'disposicion', 
                    'sobre' => 'sobre', 
                    'descripcion' => 'descripcion',     
                    'titulo' => 'titulo', 
                    'latitud' => 'latitud', 
                    'longitud' => 'longitud', 
                    'direccion' => 'direccion', 
                    'mostrarDireccion' => 'mostrarDireccion', 
                    'youtube' => 'youtube', 
                    'tour3d' => 'tour3d', 
                    'vivienda' => 'vivienda', 
                    'oficina' => 'oficina', 
                    'garage' => 'garage', 
                    'anioConstruccion' => 'anioConstruccion', 
                    'vistaMar' => 'vistaMar', 
                    'distanciaMar' => 'distanciaMar', 
                    'financia' => 'financia', 
                    'ubicacionAproximada' => 'ubicacionAproximada', 
                    'imagenes' => 'imagenes', 
                    'vendedor' => 
                        [
                            'vendedor' =>
                                [
                                    'email' => 'email', 
                                    'nombre' => 'nombre', 
                                    'telefono' => 'telefono', 
                                ],
                        ]
                ],
            'venta' =>
                [
                    'precioVenta' => 'precioVenta', 
                    'ocultarPrecioV' => 'ocultarPrecioV', 
                    'monedaVenta' => 'monedaVenta', 
                    'permuta' => 'permuta',
                ],
            'alquiler' =>
                [
                    'monedaAlquiler' => 'monedaAlquiler', 
                    'precioAlquiler' => 'precioAlquiler', 
                    'ocultarPrecioA' => 'ocultarPrecioA', 
                    'IDmonedagc' => 'IDmonedagc', 
                    'gc' => 'gc', 
                ],
            'alquiler temporal' =>
                [
                    'monedaAlquilerDiciembre' => 'monedaAlquilerDiciembre', 
                    'precioAlquilerDiciembre' => 'precioAlquilerDiciembre', 
                    'ocupadaAlquilerDiciembre' => 'ocupadaAlquilerDiciembre', 
                    'monedaAlquilerPrimeraQuincenaDiciembre' => 'monedaAlquilerPrimeraQuincenaDiciembre', 
                    'precioAlquilerPrimeraQuincenaDiciembre' => 'precioAlquilerPrimeraQuincenaDiciembre', 
                    'ocupadaAlquilerPrimeraQuincenaDiciembre' => 'ocupadaAlquilerPrimeraQuincenaDiciembre', 
                    'monedaAlquilerSegundaQuincenaDiciembre' => 'monedaAlquilerSegundaQuincenaDiciembre', 
                    'precioAlquilerSegundaQuincenaDiciembre' => 'precioAlquilerSegundaQuincenaDiciembre', 
                    'ocupadaAlquilerSegundaQuincenaDiciembre' => 'ocupadaAlquilerSegundaQuincenaDiciembre', 
                    'monedaAlquilerEnero' => 'monedaAlquilerEnero', 
                    'precioAlquilerEnero' => 'precioAlquilerEnero', 
                    'ocupadaAlquilerEnero' => 'ocupadaAlquilerEnero', 
                    'monedaAlquilerPrimeraQuincenaEnero' => 'monedaAlquilerPrimeraQuincenaEnero', 
                    'precioAlquilerPrimeraQuincenaEnero' => 'precioAlquilerPrimeraQuincenaEnero', 
                    'ocupadaAlquilerPrimeraQuincenaEnero' => 'ocupadaAlquilerPrimeraQuincenaEnero', 
                    'monedaAlquilerSegundaQuincenaEnero' => 'monedaAlquilerSegundaQuincenaEnero', 
                    'precioAlquilerSegundaQuincenaEnero' => 'precioAlquilerSegundaQuincenaEnero', 
                    'ocupadaAlquilerSegundaQuincenaEnero' => 'ocupadaAlquilerSegundaQuincenaEnero',
                    'monedaAlquilerFebrero' => 'monedaAlquilerFebrero', 
                    'precioAlquilerFebrero' => 'precioAlquilerFebrero', 
                    'ocupadaAlquilerFebrero' => 'ocupadaAlquilerFebrero',
                    'monedaAlquilerPrimeraQuincenaFebrero' => 'monedaAlquilerPrimeraQuincenaFebrero', 
                    'precioAlquilerPrimeraQuincenaFebrero' => 'precioAlquilerPrimeraQuincenaFebrero', 
                    'ocupadaAlquilerPrimeraQuincenaFebrero' => 'ocupadaAlquilerPrimeraQuincenaFebrero',
                    'monedaAlquilerSegundaQuincenaFebrero' => 'monedaAlquilerSegundaQuincenaFebrero', 
                    'precioAlquilerSegundaQuincenaFebrero' => 'precioAlquilerSegundaQuincenaFebrero', 
                    'ocupadaAlquilerSegundaQuincenaFebrero' => 'ocupadaAlquilerSegundaQuincenaFebrero', 
                    'monedaAlquilerReveillon' => 'monedaAlquilerReveillon', 
                    'precioAlquilerReveillon' => 'precioAlquilerReveillon', 
                    'ocupadaAlquilerReveillon' => 'ocupadaAlquilerReveillon', 
                    'monedaAlquilerSemanaSanta' => 'monedaAlquilerSemanaSanta', 
                    'precioAlquilerSemanaSanta' => 'precioAlquilerSemanaSanta', 
                    'ocupadaAlquilerSemanaSanta' => 'ocupadaAlquilerSemanaSanta', 
                    'monedaAlquilerVacacionesJulio' => 'monedaAlquilerVacacionesJulio', 
                    'precioAlquilerVacacionesJulio' => 'precioAlquilerVacacionesJulio', 
                    'ocupadaAlquilerVacacionesJulio' => 'ocupadaAlquilerVacacionesJulio', 
                    'precioAlquilerDiario' => 'precioAlquilerDiario', 
                    'monedaAlquilerDiario' => 'monedaAlquilerDiario', 
                    'precioAlquilerMensual' => 'precioAlquilerMensual', 
                    'monedaAlquilerMensual' => 'monedaAlquilerMensual', 
                    'dosPlazas' => 'dosPlazas', 
                    'unaPlaza' => 'unaPlaza', 
                    'sofaCama' => 'sofaCama', 
                    'colchon' => 'colchon', 
                    'cucheta' => 'cucheta', 
                    'estadiaMinima' => 'estadiaMinima', 
                ],
            'venta y alquiler' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc',
                ]
        ],
    'apartamento' =>
        [
            'general' =>
                [
                    'id' => 'id',
                    'tipoPropiedad' => 'tipoPropiedad',
                    'tipoOperacion' => 'tipoOperacion',
                    'departamento' => 'departamento',
                    'zona' => 'zona',
                    'idDormitorios' => 'idDormitorios',
                    'idBanios' => 'idBanios',
                    'estado' => 'estado',

                    'comodidades' => 
                        [
                            'Balcón' => 1,
                            'Box' => 2,
                            'Calefacción individual' => 3,
                            'Calefón' => 4,
                            'Cochera' => 5,
                            'Depósito' => 6,
                            'Dormitorio de servicio' => 7,
                            'Estufa a Leña' => 8,
                            'Garaje' => 9,
                            'Jacuzzi' => 10,
                            'Línea blanca' => 11,
                            'Losa radiante' => 12,
                            'Parrillero' => 13,
                            'Placard en cocina' => 14,
                            'Placard en dormitorio' => 15,
                            'Terraza' => 16,
                            'Terraza lavadero' => 17,
                            'Vestidor' => 18,
                            'Equipada con muebles' => 19,
                            'Jardín' => 71,
                            'Patio' => 73,
                            'Lavadero' => 75,
                            'Sauna' => 77,
                            'Agua caliente central' => 32,
                            'Calefacción central' => 33,
                            'Instalación de TV por cable' => 34,
                            'Previsión A.A.' => 35,
                            'Aire acondicionado' => 36,
                            'Gas por cañería' => 37                            
                        ],

                    'seguridad' => 
                        [
                            'alarma' => 1,
                            'cámaras CCTV' => 2,
                            'cerca perimetral' => 3,
                            'portería 24hrs' => 4,
                            'portón eléctrico' => 5,
                            'rejas' => 6,
                            'guardia de seguridad' => 7,
                            'seguridad para niños' => 8
                        ],

                    'm2' => 'm2',
                    'm2terreno' => 'm2terreno',
                    'm2apto' => 'm2apto', 
                    'm2edificados' => 'm2edificados',
                    'm2terrazas' => 'm2terrazas', 
                    'plantas' => 'plantas',

                    'piso' => 'piso', 
                    'cantidadPisos' => 'cantidadPisos',
                    'aptosPorPiso' => 'aptosPorPiso', 
                    'orientacion' => 'orientacion',
                    'disposicion' => 'disposicion',
                    'sobre' => 'sobre',
                    'descripcion' => 'descripcion',

                    'titulo' => 'titulo',
                    'latitud' => 'latitud',
                    'longitud' => 'longitud',
                    'direccion' => 'direccion',
                    'mostrarDireccion' => 'mostrarDireccion',
                    'youtube' => 'youtube',
                    'tour3d' => 'tour3d',
                    'vivienda' => 'vivienda',
                    'oficina' => 'oficina',

                    'garage' => 'garage',
                    'anioConstruccion' => 'anioConstruccion',
                    'vistaMar' => 'vistaMar',
                    'distanciaMar' => 'distanciaMar',
                    'financia' => 'financia',
                    'ubicacionAproximada' => 'ubicacionAproximada',
                    'gc' => 'gc',
                    'IDmonedagc' => 'IDmonedagc',
                    'imagenes' => 'imagenes',
                    'vendedor' =>
                    [
                        'vendedor' =>
                            [
                                'email' => 'email',
                                'nombre' => 'nombre',
                                'telefono' => 'telefono',
                            ],
                    ]    
                ],
            'venta' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'permuta' => 'permuta'
                ],
            'alquiler' =>
                [
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                ],
            'alquiler temporal' =>
                [
                    'monedaAlquilerDiciembre' => 'monedaAlquilerDiciembre',
                    'precioAlquilerDiciembre' => 'precioAlquilerDiciembre',
                    'ocupadaAlquilerDiciembre' => 'ocupadaAlquilerDiciembre',
                    'monedaAlquilerPrimeraQuincenaDiciembre' => 'monedaAlquilerPrimeraQuincenaDiciembre',
                    'precioAlquilerPrimeraQuincenaDiciembre' => 'precioAlquilerPrimeraQuincenaDiciembre',
                    'ocupadaAlquilerPrimeraQuincenaDiciembre' => 'ocupadaAlquilerPrimeraQuincenaDiciembre',
                    'monedaAlquilerSegundaQuincenaDiciembre' => 'monedaAlquilerSegundaQuincenaDiciembre',
                    'precioAlquilerSegundaQuincenaDiciembre' => 'precioAlquilerSegundaQuincenaDiciembre',
                    'ocupadaAlquilerSegundaQuincenaDiciembre' => 'ocupadaAlquilerSegundaQuincenaDiciembre',
                    'monedaAlquilerEnero' => 'monedaAlquilerEnero',
                    'precioAlquilerEnero' => 'precioAlquilerEnero',
                    'ocupadaAlquilerEnero' => 'ocupadaAlquilerEnero',
                    'monedaAlquilerPrimeraQuincenaEnero' => 'monedaAlquilerPrimeraQuincenaEnero',
                    'precioAlquilerPrimeraQuincenaEnero' => 'precioAlquilerPrimeraQuincenaEnero',
                    'ocupadaAlquilerPrimeraQuincenaEnero' => 'ocupadaAlquilerPrimeraQuincenaEnero',
                    'monedaAlquilerSegundaQuincenaEnero' => 'monedaAlquilerSegundaQuincenaEnero',
                    'precioAlquilerSegundaQuincenaEnero' => 'precioAlquilerSegundaQuincenaEnero',
                    'ocupadaAlquilerSegundaQuincenaEnero' => 'ocupadaAlquilerSegundaQuincenaEnero',
                    'monedaAlquilerFebrero' => 'monedaAlquilerFebrero',
                    'precioAlquilerFebrero' => 'precioAlquilerFebrero',
                    'ocupadaAlquilerFebrero' => 'ocupadaAlquilerFebrero',
                    'monedaAlquilerPrimeraQuincenaFebrero' => 'monedaAlquilerPrimeraQuincenaFebrero',
                    'precioAlquilerPrimeraQuincenaFebrero' => 'precioAlquilerPrimeraQuincenaFebrero',
                    'ocupadaAlquilerPrimeraQuincenaFebrero' => 'ocupadaAlquilerPrimeraQuincenaFebrero',
                    'monedaAlquilerSegundaQuincenaFebrero' => 'monedaAlquilerSegundaQuincenaFebrero',
                    'precioAlquilerSegundaQuincenaFebrero' => 'precioAlquilerSegundaQuincenaFebrero',
                    'ocupadaAlquilerSegundaQuincenaFebrero' => 'ocupadaAlquilerSegundaQuincenaFebrero',
                    'monedaAlquilerReveillon' => 'monedaAlquilerReveillon',
                    'precioAlquilerReveillon' => 'precioAlquilerReveillon',
                    'ocupadaAlquilerReveillon' => 'ocupadaAlquilerReveillon',
                    'monedaAlquilerSemanaSanta' => 'monedaAlquilerSemanaSanta',
                    'precioAlquilerSemanaSanta' => 'precioAlquilerSemanaSanta',
                    'ocupadaAlquilerSemanaSanta' => 'ocupadaAlquilerSemanaSanta',
                    'monedaAlquilerVacacionesJulio' => 'monedaAlquilerVacacionesJulio',
                    'precioAlquilerVacacionesJulio' => 'precioAlquilerVacacionesJulio',
                    'ocupadaAlquilerVacacionesJulio' => 'ocupadaAlquilerVacacionesJulio', 
                    'precioAlquilerDiario' => 'precioAlquilerDiario',
                    'monedaAlquilerDiario' => 'monedaAlquilerDiario',
                    'precioAlquilerMensual' => 'precioAlquilerMensual',
                    'monedaAlquilerMensual' => 'monedaAlquilerMensual',
                    'dosPlazas' => 'dosPlazas',
                    'unaPlaza' => 'unaPlaza',
                    'sofaCama' => 'sofaCama',
                    'colchon' => 'colchon',
                    'cucheta' => 'cucheta',
                    'estadiaMinima' => 'estadiaMinima',
                ],
            'venta y alquiler' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc',
                ]
        ],
    'terreno' =>
        [
            'general' =>
                [
                    'id' => 'id',
                    'tipoPropiedad' => 'tipoPropiedad',
                    'tipoOperacion' => 'tipoOperacion',
                    'departamento' => 'departamento',
                    'zona' => 'zona',
                    'estado' => 'estado',
                    
                    'comodidades' => 'comodidades',

                    'seguridad' => 
                        [
                            'alarma' => 1,
                            'cámaras CCTV' => 2,
                            'cerca perimetral' => 3,
                            'portería 24hrs' => 4,
                            'portón eléctrico' => 5,
                            'rejas' => 6,
                            'guardia de seguridad' => 7,
                            'seguridad para niños' => 8
                        ],

                    'm2' => 'm2',
                    'm2terreno' => 'm2terreno',
                    'hectareas' => 'hectareas',
                    
                    'descripcion' => 'descripcion',

                    'titulo' => 'titulo',
                    'latitud' => 'latitud',
                    'longitud' => 'longitud',
                    'direccion' => 'direccion',
                    'mostrarDireccion' => 'mostrarDireccion',
                    'youtube' => 'youtube',
                    'tour3d' => 'tour3d',

                    'vistaMar' => 'vistaMar',
                    'distanciaMar' => 'distanciaMar',
                    'financia' => 'financia',
                    'ubicacionAproximada' => 'ubicacionAproximada',
                    'imagenes' => 'imagenes',
                    'vendedor' =>
                        [
                            'vendedor' =>
                                [
                                    'email' => 'email',
                                    'nombre' => 'nombre',
                                    'telefono' => 'telefono',
                                ],
                        ],    
                ],
            'venta' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'permuta' => 'permuta',
                ],
            'alquiler' =>
                [
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc',
                ],
            'alquiler temporal' =>
                [
                    'monedaAlquilerDiciembre' => 'monedaAlquilerDiciembre',
                    'precioAlquilerDiciembre' => 'precioAlquilerDiciembre',
                    'ocupadaAlquilerDiciembre' => 'ocupadaAlquilerDiciembre',
                    'monedaAlquilerPrimeraQuincenaDiciembre' => 'monedaAlquilerPrimeraQuincenaDiciembre',
                    'precioAlquilerPrimeraQuincenaDiciembre' => 'precioAlquilerPrimeraQuincenaDiciembre',
                    'ocupadaAlquilerPrimeraQuincenaDiciembre' => 'ocupadaAlquilerPrimeraQuincenaDiciembre',
                    'monedaAlquilerSegundaQuincenaDiciembre' => 'monedaAlquilerSegundaQuincenaDiciembre',
                    'precioAlquilerSegundaQuincenaDiciembre' => 'precioAlquilerSegundaQuincenaDiciembre',
                    'ocupadaAlquilerSegundaQuincenaDiciembre' => 'ocupadaAlquilerSegundaQuincenaDiciembre',
                    'monedaAlquilerEnero' => 'monedaAlquilerEnero',
                    'precioAlquilerEnero' => 'precioAlquilerEnero',
                    'ocupadaAlquilerEnero' => 'ocupadaAlquilerEnero',
                    'monedaAlquilerPrimeraQuincenaEnero' => 'monedaAlquilerPrimeraQuincenaEnero',
                    'precioAlquilerPrimeraQuincenaEnero' => 'precioAlquilerPrimeraQuincenaEnero',
                    'ocupadaAlquilerPrimeraQuincenaEnero' => 'ocupadaAlquilerPrimeraQuincenaEnero',
                    'monedaAlquilerSegundaQuincenaEnero' => 'monedaAlquilerSegundaQuincenaEnero',
                    'precioAlquilerSegundaQuincenaEnero' => 'precioAlquilerSegundaQuincenaEnero',
                    'ocupadaAlquilerSegundaQuincenaEnero' => 'ocupadaAlquilerSegundaQuincenaEnero',
                    'monedaAlquilerFebrero' => 'monedaAlquilerFebrero',
                    'precioAlquilerFebrero' => 'precioAlquilerFebrero',
                    'ocupadaAlquilerFebrero' => 'ocupadaAlquilerFebrero',
                    'monedaAlquilerPrimeraQuincenaFebrero' => 'monedaAlquilerPrimeraQuincenaFebrero',
                    'precioAlquilerPrimeraQuincenaFebrero' => 'precioAlquilerPrimeraQuincenaFebrero',
                    'ocupadaAlquilerPrimeraQuincenaFebrero' => 'ocupadaAlquilerPrimeraQuincenaFebrero',
                    'monedaAlquilerSegundaQuincenaFebrero' => 'monedaAlquilerSegundaQuincenaFebrero',
                    'precioAlquilerSegundaQuincenaFebrero' => 'precioAlquilerSegundaQuincenaFebrero',
                    'ocupadaAlquilerSegundaQuincenaFebrero' => 'ocupadaAlquilerSegundaQuincenaFebrero',
                    'monedaAlquilerReveillon' => 'monedaAlquilerReveillon',
                    'precioAlquilerReveillon' => 'precioAlquilerReveillon',
                    'ocupadaAlquilerReveillon' => 'ocupadaAlquilerReveillon',
                    'monedaAlquilerSemanaSanta' => 'monedaAlquilerSemanaSanta',
                    'precioAlquilerSemanaSanta' => 'precioAlquilerSemanaSanta',
                    'ocupadaAlquilerSemanaSanta' => 'ocupadaAlquilerSemanaSanta',
                    'monedaAlquilerVacacionesJulio' => 'monedaAlquilerVacacionesJulio',
                    'precioAlquilerVacacionesJulio' => 'precioAlquilerVacacionesJulio',
                    'precioAlquilerDiario' => 'precioAlquilerDiario',
                    'monedaAlquilerDiario' => 'monedaAlquilerDiario',
                    'precioAlquilerMensual' => 'precioAlquilerMensual',
                    'monedaAlquilerMensual' => 'monedaAlquilerMensual',
                    'dosPlazas' => 'dosPlazas',
                    'unaPlaza' => 'unaPlaza',
                    'sofaCama' => 'sofaCama',
                    'colchon' => 'colchon',
                    'cucheta' => 'cucheta',
                    'estadiaMinima' => 'estadiaMinima',
                ],
            'venta y alquiler' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc',
                ]
        ],
    'local comercial' =>
        [
            'general' =>
                [
                    'id' => 'id',
                    'tipoPropiedad' => 'tipoPropiedad',
                    'tipoOperacion' => 'tipoOperacion',
                    'departamento' => 'departamento',
                    'zona' => 'zona',
                    'idDormitorios' => 'idDormitorios', 
                    'idBanios' => 'idBanios',
                    'estado' => 'estado',

                    'comodidades' => 
                        [
                            'Balcón' => 79,
                            'Box' => 80,
                            'Calefacción individual' => 81,
                            'Calefón' => 82,
                            'Cochera' => 83,
                            'Depósito' => 84,
                            'Dormitorio de servicio' => 85,
                            'Estufa a Leña' => 86,
                            'Garaje' => 87,
                            'Jacuzzi' => 88,
                            'Línea blanca' => 89,
                            'Losa radiante' => 90,
                            'Parrillero' => 91,
                            'Placard en cocina' => 92,
                            'Placard en dormitorio' => 93,
                            'Terraza' => 94,
                            'Terraza lavadero' => 95,
                            'Vestidor' => 96,
                            'Equipada con muebles' => 97,
                            'Jardín' => 98,
                            'Patio' => 99,
                            'Lavadero' => 100,
                            'Sauna' => 101,
                        ],

                    'seguridad' => 
                        [
                            'alarma' => 1,
                            'cámaras CCTV' => 2,
                            'cerca perimetral' => 3,
                            'portería 24hrs' => 4,
                            'portón eléctrico' => 5,
                            'rejas' => 6,
                            'guardia de seguridad' => 7,
                            'seguridad para niños' => 8
                        ],

                    'm2' => 'm2',
                    'm2terreno' => 'm2terreno',
                    'm2edificados' => 'm2edificados',
                    'm2terrazas' => 'm2terrazas', 
                    'plantas' => 'plantas',
                    'piso' => 'piso',
                    'orientacion' => 'orientacion',
                    'disposicion' => 'disposicion',
                    'sobre' => 'sobre',
                    'descripcion' => 'descripcion',
                    'cantidadPisos' => 'cantidadPisos',
                    'aptosPorPiso' => 'aptosPorPiso',

                    'titulo' => 'titulo',
                    'latitud' => 'latitud',
                    'longitud' => 'longitud',
                    'direccion' => 'direccion',
                    'mostrarDireccion' => 'mostrarDireccion',
                    'youtube' => 'youtube',
                    'tour3d' => 'tour3d',

                    'garage' => 'garage',
                    'anioConstruccion' => 'anioConstruccion',
                    'vivienda' => 'vivienda',
                    'oficina' => 'oficina',
                    'vistaMar' => 'vistaMar',
                    'distanciaMar' => 'distanciaMar',
                    'financia' => 'financia',
                    'ubicacionAproximada' => 'ubicacionAproximada',
                    'imagenes' => 'imagenes',
                    'vendedor' =>
                        [
                            'vendedor' =>
                                [
                                    'email' => 'email',
                                    'nombre' => 'nombre',
                                    'telefono' => 'telefono',
                                ],
                        ],    
                ],
            'venta' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'permuta' => 'permuta',
                ],
            'alquiler' =>
                [
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc',
                ],
            'alquiler temporal' =>
                [
                    'precioAlquilerDiario' => 'precioAlquilerDiario',
                    'monedaAlquilerDiario' => 'monedaAlquilerDiario',
                    'precioAlquilerMensual' => 'precioAlquilerMensual',
                    'monedaAlquilerMensual' => 'monedaAlquilerMensual',
                    'estadiaMinima' => 'estadiaMinima',
                ],
            'venta y alquiler' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc'
                ],
        ],
    'oficina' =>
        [
            'general' =>
                [
                    'id' => 'id',
                    'tipoPropiedad' => 'tipoPropiedad',
                    'tipoOperacion' => 'tipoOperacion',
                    'departamento' => 'departamento',
                    'zona' => 'zona',
                    'idBanios' => 'idBanios',
                    'estado' => 'estado',
                    
                    'comodidades' => 
                        [
                            'Agua caliente central' => 102,
                            'Aire acondicionado' => 103,
                            'Altillo' => 104,
                            'Balcón' => 105,
                            'Barbacoa' => 106,
                            'Box' => 107,
                            'Bungalow' => 108,
                            'Calefacción' => 109,
                            'Calefón' => 110,
                            'Cochera' => 111,
                            'Depósito' => 112,
                            'Dormitorio de servicio' => 113,
                            'Estufa a Leña' => 114,
                            'Garaje' => 115,
                            'Gas por cañería' => 116,
                            'GYM' => 117,
                            'Instalación de TV por cable' => 118,
                            'Jacuzzi' => 119,
                            'Lavandería' => 120,
                            'Línea blanca' => 121,
                            'Losa radiante' => 122,
                            'Parrillero' => 123,
                            'Piscina' => 124,
                            'Placard en cocina' => 125,
                            'Placard en dormitorio' => 126,
                            'Playroom' => 127,
                            'Previsión A.A.' => 128,
                            'Sótano' => 129,
                            'Terraza' => 130,
                            'Terraza lavadero' => 131,
                            'Vestidor' => 132,
                            'Equipada con muebles' => 133,
                            'Jardín' => 134,
                            'Patio' => 135,
                            'Lavadero' => 136,
                            'Sauna' => 137,
                        ],

                    'seguridad' => 
                        [
                            'alarma' => 1,
                            'cámaras CCTV' => 2,
                            'cerca perimetral' => 3,
                            'portería 24hrs' => 4,
                            'portón eléctrico' => 5,
                            'rejas' => 6,
                            'guardia de seguridad' => 7,
                            'seguridad para niños' => 8
                        ],

                    'm2' => 'm2',
                    'm2edificados' => 'm2edificados',
                    'piso' => 'piso',
                    'aptosPorPiso' => 'aptosPorPiso',
                    'orientacion' => 'orientacion',
                    'disposicion' => 'disposicion',
                    'sobre' => 'sobre',
                    'descripcion' => 'descripcion',

                    'titulo' => 'titulo',
                    'latitud' => 'latitud',
                    'longitud' => 'longitud',
                    'direccion' => 'direccion',
                    'mostrarDireccion' => 'mostrarDireccion',
                    'youtube' => 'youtube',
                    'tour3d' => 'tour3d',
                    
                    'garage' => 'garage',
                    'anioConstruccion' => 'anioConstruccion',
                    'financia' => 'financia',
                    'ubicacionAproximada' => 'ubicacionAproximada',
                    'imagenes' => 'imagenes',
                    'vendedor' =>
                        [
                            'vendedor' =>
                                [
                                    'email' => 'email',
                                    'nombre' => 'nombre',
                                    'telefono' => 'telefono',
                                ],
                        ],    
                ],
            'venta' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'permuta' => 'permuta'
                ],
            'alquiler' =>
                [
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc',
                ],
            'alquiler temporal' =>
                [
                    'precioAlquilerDiario' => 'precioAlquilerDiario',
                    'monedaAlquilerDiario' => 'monedaAlquilerDiario',
                    'precioAlquilerMensual' => 'precioAlquilerMensual',
                    'monedaAlquilerMensual' => 'monedaAlquilerMensual',
                    'estadiaMinima' => 'estadiaMinima',
                ],
            'venta y alquiler' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc'
                ]
        ],
    'chacra / campo' =>
        [
            'general' =>
                [
                    'id' => 'id',
                    'tipoPropiedad' => 'tipoPropiedad',
                    'tipoOperacion' => 'tipoOperacion',
                    'departamento' => 'departamento',
                    'zona' => 'zona',
                    'estado' => 'estado',
                    
                    'comodidades' => 
                        [
                            'Agua caliente central' => 138,
                            'Aire acondicionado' => 139,
                            'Altillo' => 140,
                            'Balcón' => 141,
                            'Barbacoa' => 142,
                            'Box' => 143,
                            'Bungalow' => 144,
                            'Calefacción' => 145,
                            'Calefón' => 146,
                            'Cochera' => 147,
                            'Depósito' => 148,
                            'Dormitorio de servicio' => 149,
                            'Estufa a Leña' => 150,
                            'Garaje' => 151,
                            'Gas por cañería' => 152,
                            'GYM' => 153,
                            'Instalación de TV por cable' => 154,
                            'Jacuzzi' => 155,
                            'Lavandería' => 156,
                            'Línea blanca' => 157,
                            'Losa radiante' => 158,
                            'Parrillero' => 159,
                            'Piscina' => 160,
                            'Placard en cocina' => 161,
                            'Placard en dormitorio' => 162,
                            'Playroom' => 163,
                            'Previsión A.A.' => 164,
                            'Sótano' => 165,
                            'Terraza' => 166,
                            'Terraza lavadero' => 167,
                            'Vestidor' => 168,
                            'Equipada con muebles' => 169,
                            'Jardín' => 170,
                            'Patio' => 171,
                            'Lavadero' => 172,
                            'Sauna' => 173,
                        ],       

                    'seguridad' => 
                        [
                            'alarma' => 1,
                            'cámaras CCTV' => 2,
                            'cerca perimetral' => 3,
                            'portería 24hrs' => 4,
                            'portón eléctrico' => 5,
                            'rejas' => 6,
                            'guardia de seguridad' => 7,
                            'seguridad para niños' => 8
                        ],
                    
                    'm2terreno' => 'm2terreno',
                    'hectareas' => 'hectareas',
                    'descripcion' => 'descripcion',
                    
                    'titulo' => 'titulo',
                    'latitud' => 'latitud',
                    'longitud' => 'longitud',
                    'direccion' => 'direccion',
                    'mostrarDireccion' => 'mostrarDireccion',
                    'youtube' => 'youtube',
                    'tour3d' => 'tour3d',

                    'anioConstruccion' => 'anioConstruccion',
                    'financia' => 'financia',
                    'ubicacionAproximada' => 'ubicacionAproximada',
                    'vendedor' =>
                        [
                            'vendedor' =>
                                [
                                    'email' => 'email',
                                    'nombre' => 'nombre',
                                    'telefono' => 'telefono',
                                ],
                        ],    
                ],
            'venta' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'permuta' => 'permuta'
                ],
            'alquiler' =>
                [
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc',
                ],
            'alquiler temporal' =>
                [
                    'precioAlquilerDiario' => 'precioAlquilerDiario',
                    'monedaAlquilerDiario' => 'monedaAlquilerDiario',
                    'precioAlquilerMensual' => 'precioAlquilerMensual',
                    'monedaAlquilerMensual' => 'monedaAlquilerMensual',
                    'estadiaMinima' => 'estadiaMinima',
                ],
            'venta y alquiler' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc'
                ],
        ],
    'garaje / cochera' =>
        [
            'general' =>
                [
                    'id' => 'id',
                    'tipoPropiedad' => 'tipoPropiedad',
                    'tipoOperacion' => 'tipoOperacion',
                    'departamento' => 'departamento',
                    'zona' => 'zona',
                    'estado' => 'estado',
                    
                    'comodidades' => 'comodidades',

                    'seguridad' => 
                        [
                            'alarma' => 1,
                            'cámaras CCTV' => 2,
                            'cerca perimetral' => 3,
                            'portería 24hrs' => 4,
                            'portón eléctrico' => 5,
                            'rejas' => 6,
                            'guardia de seguridad' => 7,
                            'seguridad para niños' => 8
                        ],
                    
                    'descripcion' => 'descripcion',

                    'titulo' => 'titulo',
                    'latitud' => 'latitud',
                    'longitud' => 'longitud',
                    'direccion' => 'direccion',
                    'mostrarDireccion' => 'mostrarDireccion',
                    'youtube' => 'youtube',
                    'tour3d' => 'tour3d',
                    'financia' => 'financia',
                    'ubicacionAproximada' => 'ubicacionAproximada',
                    'vendedor' =>
                    [
                        'vendedor' =>
                            [
                                'email' => 'email',
                                'nombre' => 'nombre',
                                'telefono' => 'telefono',
                            ],
                    ]    
                ],
            'venta' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'permuta' => 'permuta'
                ],
            'alquiler' =>
                [
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc',
                ],
            'alquiler temporal' =>
                [
                    'precioAlquilerDiario' => 'precioAlquilerDiario',
                    'monedaAlquilerDiario' => 'monedaAlquilerDiario',
                    'precioAlquilerMensual' => 'precioAlquilerMensual',
                    'monedaAlquilerMensual' => 'monedaAlquilerMensual',
                    'estadiaMinima' => 'estadiaMinima',
                ],
            'venta y alquiler' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc'
                ]
        ],
    'negocio especial' =>
        [
            'general' =>
                [
                    'id' => 'id',
                    'tipoPropiedad' => 'tipoPropiedad',
                    'tipoOperacion' => 'tipoOperacion',
                    'departamento' => 'departamento',
                    'zona' => 'zona',
                    'idDormitorios' => 'idDormitorios',
                    'idBanios' => 'idBanios',
                    'estado' => 'estado',
                    
                    'comodidades' => 'comodidades',

                    'seguridad' => 
                        [
                            'alarma' => 1,
                            'cámaras CCTV' => 2,
                            'cerca perimetral' => 3,
                            'portería 24hrs' => 4,
                            'portón eléctrico' => 5,
                            'rejas' => 6,
                            'guardia de seguridad' => 7,
                            'seguridad para niños' => 8
                        ],
                    
                    'm2' => 'm2',
                    'm2edificados' => 'm2edificados',
                    'plantas' => 'plantas',
                    'piso' => 'piso',
                    'orientacion' => 'orientacion',
                    'disposicion' => 'disposicion',
                    'sobre' => 'sobre',
                    'descripcion' => 'descripcion',

                    'titulo' => 'titulo',
                    'latitud' => 'latitud',
                    'longitud' => 'longitud',
                    'direccion' => 'direccion',
                    'mostrarDireccion' => 'mostrarDireccion',
                    'youtube' => 'youtube',
                    'tour3d' => 'tour3d',

                    'garage' => 'garage',
                    'anioConstruccion' => 'anioConstruccion',
                    'vistaMar' => 'vistaMar',
                    'distanciaMar' => 'distanciaMar',
                    'financia' => 'financia',
                    'ubicacionAproximada' => 'ubicacionAproximada',
                    'vendedor' =>
                        [
                            'vendedor' =>
                                [
                                    'email' => 'email',
                                    'nombre' => 'nombre',
                                    'telefono' => 'telefono',
                                ],
                        ]    
                ],
            'venta' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'permuta' => 'permuta'
                ],
            'alquiler' =>
                [
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc',
                ],
            'alquiler temporal' =>
                [
                    'precioAlquilerDiario' => 'precioAlquilerDiario',
                    'monedaAlquilerDiario' => 'monedaAlquilerDiario',
                    'precioAlquilerMensual' => 'precioAlquilerMensual',
                    'monedaAlquilerMensual' => 'monedaAlquilerMensual',
                    'estadiaMinima' => 'estadiaMinima',
                ],
            'venta y alquiler' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc',
                ]
        ],
    'edificio' =>
        [
            'general' =>
                [
                    'id' => 'id',
                    'tipoPropiedad' => 'tipoPropiedad',
                    'tipoOperacion' => 'tipoOperacion',
                    'departamento' => 'departamento',
                    'zona' => 'zona',
                    'estado' => 'estado',
                    
                    'comodidades'=> 
                        [
                            'Ascensor' => 20,
                            'Barbacoa' => 21,
                            'Bungalow' => 22,
                            'GYM' => 23,
                            'Jacuzzi' => 24,
                            'Lavandería' => 25,
                            'Parrillero' => 26,
                            'Piscina' => 27,
                            'Playroom' => 28,
                            'Salón de uso común' => 29,
                            'Spa' => 30,
                            'Wifi' => 31,
                            'Solarium' => 78,
                        ], 

                    'seguridad' => 
                        [
                            'alarma' => 1,
                            'cámaras CCTV' => 2,
                            'cerca perimetral' => 3,
                            'portería 24hrs' => 4,
                            'portón eléctrico' => 5,
                            'rejas' => 6,
                            'guardia de seguridad' => 7,
                            'seguridad para niños' => 8
                        ],
                          
                    'm2' => 'm2',
                    'm2edificados' => 'm2edificados',
                    'plantas' => 'plantas',
                    'orientacion' => 'orientacion',
                    'disposicion' => 'disposicion',
                    'sobre' => 'sobre',
                    'descripcion' => 'descripcion',

                    'titulo' => 'titulo',
                    'latitud' => 'latitud',
                    'longitud' => 'longitud',
                    'direccion' => 'direccion',
                    'mostrarDireccion' => 'mostrarDireccion',
                    'youtube' => 'youtube',
                    'tour3d' => 'tour3d',

                    'anioConstruccion' => 'anioConstruccion',
                    'vistaMar' => 'vistaMar',
                    'distanciaMar' => 'distanciaMar',
                    'financia' => 'financia',
                    'ubicacionAproximada' => 'ubicacionAproximada',
                    'vendedor' =>
                        [
                            'vendedor' =>
                                [
                                    'email' => 'email',
                                    'nombre' => 'nombre',
                                    'telefono' => 'telefono',
                                ],
                        ]    
                ],
            'venta' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'permuta' => 'permuta'
                ],
            'alquiler' =>
                [
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc',
                ],
            'alquiler temporal' =>
                [
                    'precioAlquilerDiario' => 'precioAlquilerDiario',
                    'monedaAlquilerDiario' => 'monedaAlquilerDiario',
                    'precioAlquilerMensual' => 'precioAlquilerMensual',
                    'monedaAlquilerMensual' => 'monedaAlquilerMensual',
                    'estadiaMinima' => 'estadiaMinima',
                ],
            'venta y alquiler' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc'
                ],
        ],
    'hotel' =>
        [
            'general' =>
                [
                    'id' => 'id',
                    'tipoPropiedad' => 'tipoPropiedad',
                    'tipoOperacion' => 'tipoOperacion',
                    'departamento' => 'departamento',
                    'zona' => 'zona',
                    'estado' => 'estado',

                    'comodidades' => 'comodidades',

                    'seguridad' => 
                        [
                            'alarma' => 1,
                            'cámaras CCTV' => 2,
                            'cerca perimetral' => 3,
                            'portería 24hrs' => 4,
                            'portón eléctrico' => 5,
                            'rejas' => 6,
                            'guardia de seguridad' => 7,
                            'seguridad para niños' => 8
                        ],

                    'm2' => 'm2',
                    'm2edificados' => 'm2edificados',
                    'plantas' => 'plantas',
                    'piso' => 'piso',
                    'orientacion' => 'orientacion',
                    'disposicion' => 'disposicion',
                    'sobre' => 'sobre',
                    'descripcion' => 'descripcion',
                    
                    'titulo' => 'titulo',
                    'latitud' => 'latitud',
                    'longitud' => 'longitud',
                    'direccion' => 'direccion',
                    'mostrarDireccion' => 'mostrarDireccion',
                    'youtube' => 'youtube',
                    'tour3d' => 'tour3d',

                    'garage' => 'garage',
                    'anioConstruccion' => 'anioConstruccion',
                    'vistaMar' => 'vistaMar',
                    'distanciaMar' => 'distanciaMar',
                    'financia' => 'financia',
                    'ubicacionAproximada' => 'ubicacionAproximada',
                    'vendedor' =>
                        [
                            'vendedor' =>
                                [
                                    'email' => 'email',
                                    'nombre' => 'nombre',
                                    'telefono' => 'telefono',
                                ],
                        ]    
                ],
            'venta' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'permuta' => 'permuta'
                ],
            'alquiler' =>
                [
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc',
                ],
            'alquiler temporal' =>
                [
                    'precioAlquilerDiario' => 'precioAlquilerDiario',
                    'monedaAlquilerDiario' => 'monedaAlquilerDiario',
                    'precioAlquilerMensual' => 'precioAlquilerMensual',
                    'monedaAlquilerMensual' => 'monedaAlquilerMensual',
                    'estadiaMinima' => 'estadiaMinima',
                ],
            'venta y alquiler' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc'
                ],
        ],
    'local industrial / galpón' =>
        [
            'general' =>
                [
                    'id' => 'id',
                    'tipoPropiedad' => 'tipoPropiedad',
                    'tipoOperacion' => 'tipoOperacion',
                    'departamento' => 'departamento',
                    'zona' => 'zona',
                    'idBanios' => 'idBanios',
                    'estado' => 'estado',
                    
                    'comodidades' => 'comodidades',

                    'seguridad' => 
                        [
                            'alarma' => 1,
                            'cámaras CCTV' => 2,
                            'cerca perimetral' => 3,
                            'portería 24hrs' => 4,
                            'portón eléctrico' => 5,
                            'rejas' => 6,
                            'guardia de seguridad' => 7,
                            'seguridad para niños' => 8
                        ],
                    
                    'm2' => 'm2',
                    'm2edificados' => 'm2edificados',
                    'plantas' => 'plantas',
                    'piso' => 'piso',
                    'orientacion' => 'orientacion',
                    'disposicion' => 'disposicion',
                    'sobre' => 'sobre',
                    'descripcion' => 'descripcion',

                    'titulo' => 'titulo',
                    'latitud' => 'latitud',
                    'longitud' => 'longitud',
                    'direccion' => 'direccion',
                    'mostrarDireccion' => 'mostrarDireccion',
                    'youtube' => 'youtube',
                    'tour3d' => 'tour3d',

                    'garage' => 'garage',
                    'anioConstruccion' => 'anioConstruccion',
                    'financia' => 'financia',
                    'ubicacionAproximada' => 'ubicacionAproximada',
                    'imagenes' => 'imagenes',
                    'vendedor' =>
                        [
                            'vendedor' =>
                                [
                                    'email' => 'email',
                                    'nombre' => 'nombre',
                                    'telefono' => 'telefono',
                                ],
                        ]
                ],
            'venta' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'permuta' => 'permuta'
                ],
            'alquiler' =>
                [
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc',
                ],
            'alquiler temporal' =>
                [
                    'precioAlquilerDiario' => 'precioAlquilerDiario',
                    'monedaAlquilerDiario' => 'monedaAlquilerDiario',
                    'precioAlquilerMensual' => 'precioAlquilerMensual',
                    'monedaAlquilerMensual' => 'monedaAlquilerMensual',
                    'estadiaMinima' => 'estadiaMinima',
                ],
            'venta y alquiler' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc',
                ]
        ],
    'otros' =>
        [
            'general' =>
                [
                    'id' => 'id',
                    'tipoPropiedad' => 'tipoPropiedad',
                    'tipoOperacion' => 'tipoOperacion',
                    'departamento' => 'departamento',
                    'zona' => 'zona',
                    'idDormitorios' => 'idDormitorios',
                    'idBanios' => 'idBanios',
                    'estado' => 'estado',
                    
                    'comodidades' => 'comodidades',

                    'seguridad' => 
                        [
                            'alarma' => 1,
                            'cámaras CCTV' => 2,
                            'cerca perimetral' => 3,
                            'portería 24hrs' => 4,
                            'portón eléctrico' => 5,
                            'rejas' => 6,
                            'guardia de seguridad' => 7,
                            'seguridad para niños' => 8
                        ],
                    
                    'm2' => 'm2',
                    'm2terreno' => 'm2terreno',
                    'm2edificados' => 'm2edificados',
                    'plantas' => 'plantas',
                    'piso' => 'piso',
                    'aptosPorPiso' => 'aptosPorPiso',
                    'orientacion' => 'orientacion',
                    'disposicion' => 'disposicion',
                    'sobre' => 'sobre',
                    'descripcion' => 'descripcion',

                    'titulo' => 'titulo',
                    'latitud' => 'latitud',
                    'longitud' => 'longitud',
                    'direccion' => 'direccion',
                    'mostrarDireccion' => 'mostrarDireccion',
                    'youtube' => 'youtube',
                    'tour3d' => 'tour3d',

                    'garage' => 'garage',
                    'anioConstruccion' => 'anioConstruccion',
                    'vistaMar' => 'vistaMar',
                    'distanciaMar' => 'distanciaMar',
                    'vivienda' => 'vivienda',
                    'oficina' => 'oficina',
                    'financia' => 'financia',
                    'ubicacionAproximada' => 'ubicacionAproximada',
                    'imagenes' => 'imagenes',
                    'vendedor' =>
                        [
                            'vendedor' =>
                                [
                                    'email' => 'email',
                                    'nombre' => 'nombre',
                                    'telefono' => 'telefono',
                                ],
                        ]
                ],
            'venta' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'permuta' => 'permuta'
                ],
            'alquiler' =>
                [
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc',
                ],
            'alquiler temporal' =>
                [
                    'monedaAlquilerDiciembre' => 'monedaAlquilerDiciembre',
                    'precioAlquilerDiciembre' => 'precioAlquilerDiciembre',
                    'ocupadaAlquilerDiciembre' => 'ocupadaAlquilerDiciembre',
                    'monedaAlquilerPrimeraQuincenaDiciembre' => 'monedaAlquilerPrimeraQuincenaDiciembre',
                    'precioAlquilerPrimeraQuincenaDiciembre' => 'precioAlquilerPrimeraQuincenaDiciembre',
                    'ocupadaAlquilerPrimeraQuincenaDiciembre' => 'ocupadaAlquilerPrimeraQuincenaDiciembre',
                    'monedaAlquilerSegundaQuincenaDiciembre' => 'monedaAlquilerSegundaQuincenaDiciembre',
                    'precioAlquilerSegundaQuincenaDiciembre' => 'precioAlquilerSegundaQuincenaDiciembre',
                    'ocupadaAlquilerSegundaQuincenaDiciembre' => 'ocupadaAlquilerSegundaQuincenaDiciembre',
                    'monedaAlquilerEnero' => 'monedaAlquilerEnero',
                    'precioAlquilerEnero' => 'precioAlquilerEnero',
                    'ocupadaAlquilerEnero' => 'ocupadaAlquilerEnero',
                    'monedaAlquilerPrimeraQuincenaEnero' => 'monedaAlquilerPrimeraQuincenaEnero',
                    'precioAlquilerPrimeraQuincenaEnero' => 'precioAlquilerPrimeraQuincenaEnero',
                    'ocupadaAlquilerPrimeraQuincenaEnero' => 'ocupadaAlquilerPrimeraQuincenaEnero',
                    'monedaAlquilerSegundaQuincenaEnero' => 'monedaAlquilerSegundaQuincenaEnero',
                    'precioAlquilerSegundaQuincenaEnero' => 'precioAlquilerSegundaQuincenaEnero',
                    'ocupadaAlquilerSegundaQuincenaEnero' => 'ocupadaAlquilerSegundaQuincenaEnero',
                    'monedaAlquilerFebrero' => 'monedaAlquilerFebrero',
                    'precioAlquilerFebrero' => 'precioAlquilerFebrero',
                    'ocupadaAlquilerFebrero' => 'ocupadaAlquilerFebrero',
                    'monedaAlquilerPrimeraQuincenaFebrero' => 'monedaAlquilerPrimeraQuincenaFebrero',
                    'precioAlquilerPrimeraQuincenaFebrero' => 'precioAlquilerPrimeraQuincenaFebrero',
                    'ocupadaAlquilerPrimeraQuincenaFebrero' => 'ocupadaAlquilerPrimeraQuincenaFebrero',
                    'monedaAlquilerSegundaQuincenaFebrero' => 'monedaAlquilerSegundaQuincenaFebrero',
                    'precioAlquilerSegundaQuincenaFebrero' => 'precioAlquilerSegundaQuincenaFebrero',
                    'ocupadaAlquilerSegundaQuincenaFebrero' => 'ocupadaAlquilerSegundaQuincenaFebrero',
                    'monedaAlquilerReveillon' => 'monedaAlquilerReveillon',
                    'precioAlquilerReveillon' => 'precioAlquilerReveillon',
                    'ocupadaAlquilerReveillon' => 'ocupadaAlquilerReveillon',
                    'monedaAlquilerSemanaSanta' => 'monedaAlquilerSemanaSanta',
                    'precioAlquilerSemanaSanta' => 'precioAlquilerSemanaSanta',
                    'ocupadaAlquilerSemanaSanta' => 'ocupadaAlquilerSemanaSanta',
                    'monedaAlquilerVacacionesJulio' => 'monedaAlquilerVacacionesJulio',
                    'precioAlquilerVacacionesJulio' => 'precioAlquilerVacacionesJulio',
                    'precioAlquilerDiario' => 'precioAlquilerDiario',
                    'monedaAlquilerDiario' => 'monedaAlquilerDiario',
                    'precioAlquilerMensual' => 'precioAlquilerMensual',
                    'monedaAlquilerMensual' => 'monedaAlquilerMensual',
                    'dosPlazas' => 'dosPlazas',
                    'unaPlaza' => 'unaPlaza',
                    'sofaCama' => 'sofaCama',
                    'colchon' => 'colchon',
                    'cucheta' => 'cucheta',
                    'estadiaMinima' => 'estadiaMinima',
                ],
            'venta y alquiler' =>
                [
                    'precioVenta' => 'precioVenta',
                    'ocultarPrecioV' => 'ocultarPrecioV',
                    'monedaVenta' => 'monedaVenta',
                    'monedaAlquiler' => 'monedaAlquiler',
                    'precioAlquiler' => 'precioAlquiler',
                    'ocultarPrecioA' => 'ocultarPrecioA',
                    'IDmonedagc' => 'IDmonedagc',
                    'gc' => 'gc',
                ]
        ]
];