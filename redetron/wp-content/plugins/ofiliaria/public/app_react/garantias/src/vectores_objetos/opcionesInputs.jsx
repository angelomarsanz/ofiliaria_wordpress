import { useTranslation } from 'react-i18next';

export const opcionesInputs = () => {
    const { t } = useTranslation();
    const opcionesInputs = [];

    /* Modelo
    opcionesInputs['nombre_opcion_input parametros'] = 
    [
        {
            valor: "",
            etiqueta: "",
        },
        {
            valor: t('texto_'),
            etiqueta: t('texto_')
        },
        {
            valor: t('texto_'),
            etiqueta: t('texto_')
        },
        {
            valor: t('texto_'),
            etiqueta: t('texto_')
        },
        {
            valor: t('texto_'),
            etiqueta: t('texto_')
        },
        {
            valor: t('texto_'),
            etiqueta: t('texto_')
        },
        {
            valor: t('texto_'),
            etiqueta: t('texto_')
        }            
    ];
    */

    opcionesInputs['tipo_propiedad'] = 
        [
            {
                valor: "",
                etiqueta: "",
            },
            {
                valor: t('texto_102'),
                etiqueta: t('texto_102'),
            },
            {
                valor: t('texto_103'),
                etiqueta: t('texto_103'),
            },
            {
                valor: t('texto_104'),
                etiqueta: t('texto_104'),
            },
            {
                valor: t('texto_105'),
                etiqueta: t('texto_105'),
            },
            {
                valor: t('texto_106'),
                etiqueta: t('texto_106'),
            },
        ];

    opcionesInputs['moneda'] = 
        [
            {
                valor: "",
                etiqueta: "",
            },
            {
                valor: "UYU",
                etiqueta: t('texto_97'),
            },
            {
                valor: "USD",
                etiqueta: t('texto_98'),
              },
        ];

    opcionesInputs['aseguradoras_tipos_personas Sura'] = 
        [
            {
                valor: "",
                etiqueta: "",
            },
            {
                valor: t('texto_66'),
                etiqueta: t('texto_66')
            },
            {
                valor: t('texto_69'),
                etiqueta: t('texto_69')
            },
            {
                valor: t('texto_70'),
                etiqueta: t('texto_70')
            },
            {
                valor: t('texto_71'),
                etiqueta: t('texto_71')
            },
            {
                valor: t('texto_72'),
                etiqueta: t('texto_72')
            },
        ];

    opcionesInputs['aseguradoras_tipos_personas Porto'] = 
        [
            {
                valor: "",
                etiqueta: "",
            },
            {
                valor: t('texto_66'),
                etiqueta: t('texto_66')
            },
            {
                valor: t('texto_67'),
                etiqueta: t('texto_67')
            },
            {
                valor: t('texto_68'),
                etiqueta: t('texto_68')
            },
            {
                valor: t('texto_69'),
                etiqueta: t('texto_69')
            },
            {
                valor: t('texto_70'),
                etiqueta: t('texto_70')
            },
            {
                valor: t('texto_71'),
                etiqueta: t('texto_71')
            },
            {
                valor: t('texto_72'),
                etiqueta: t('texto_72')
            }            
        ];

        opcionesInputs['aseguradoras_tipos_personas Sancor'] = 
        [
            {
                valor: "",
                etiqueta: "",
            },
            {
                valor: t('texto_66'),
                etiqueta: t('texto_66')
            },
            {
                valor: t('texto_69'),
                etiqueta: t('texto_69')
            },
            {
                valor: t('texto_70'),
                etiqueta: t('texto_70')
            },
            {
                valor: t('texto_71'),
                etiqueta: t('texto_71')
            },
            {
                valor: t('texto_73'),
                etiqueta: t('texto_73')
            }            
        ];

    opcionesInputs['aseguradoras_tipos_personas Mapfre'] = 
        [
            {
                valor: "",
                etiqueta: "",
            },
            {
                valor: t('texto_66'),
                etiqueta: t('texto_66')
            },
            {
                valor: t('texto_67'),
                etiqueta: t('texto_67')
            },
            {
                valor: t('texto_69'),
                etiqueta: t('texto_69')
            },
            {
                valor: t('texto_70'),
                etiqueta: t('texto_70')
            },
            {
                valor: t('texto_71'),
                etiqueta: t('texto_71')
            },
            {
                valor: t('texto_72'),
                etiqueta: t('texto_72')
            }            
        ];

    opcionesInputs['aseguradoras_tipos_personas Sbi'] = 
        [
            {
                valor: "",
                etiqueta: "",
            },
            {
                valor: t('texto_66'),
                etiqueta: t('texto_66')
            },
            {
                valor: t('texto_69'),
                etiqueta: t('texto_69')
            },
            {
                valor: t('texto_70'),
                etiqueta: t('texto_70')
            },
            {
                valor: t('texto_71'),
                etiqueta: t('texto_71')
            },
            {
                valor: t('texto_72'),
                etiqueta: t('texto_72')
            }            
        ];
    opcionesInputs['ingreso'] = 
        [
            {
                valor: "",
                etiqueta: "",
            },
            {
                valor: t('texto_60'),
                etiqueta: t('texto_60')
            },
            {
                valor: t('texto_61'),
                etiqueta: t('texto_61')
            },
        ];

    opcionesInputs['cargo_empresa'] = 
        [
            {
                valor: t('texto_84'),
                etiqueta: t('texto_84')
            },
            {
                valor: t('texto_85'),
                etiqueta: t('texto_85')
            },
            {
                valor: t("Propietario"),
                etiqueta: t("Propietario")
            },
            {
                valor: t('texto_87'),
                etiqueta: t('texto_87')
            },
        ];

    opcionesInputs['sueldo'] = 
        [
            {
                valor: t('texto_81'),
                etiqueta: t('texto_81')
            },
            {
                valor: t('texto_82'),
                etiqueta: t('texto_82')
            }
        ];
    
    opcionesInputs['garantia_en_revision'] = 
    [
        {
            valor: true,
            etiqueta: t('texto_164')
        },
    ];

    opcionesInputs['aprobacion_garantia'] = 
    [
        {
            valor: t('texto_113'),
            etiqueta: t('texto_113')
        },
        {
            valor: t('texto_114'),
            etiqueta: t('texto_114')
        }
    ];

    opcionesInputs['tipos_propietarios'] = 
    [
        {
            valor: "",
            etiqueta: "",
        },
        {
            valor: t('texto_223'),
            etiqueta: t('texto_223')
        },
        {
            valor: t('texto_224'),
            etiqueta: t('texto_224')
        },
    ];

    opcionesInputs['tipo_contrato'] = 
    [
        {
            valor: "",
            etiqueta: "",
        },
        {
            valor: t('texto_225'),
            etiqueta: t('texto_225')
        },
        {
            valor: t('texto_226'),
            etiqueta: t('texto_226')
        }
    ];

    opcionesInputs['plazo_alquiler'] = 
    [
        {
            valor: "",
            etiqueta: "",
        },
        {
            valor: 1,
            etiqueta: 1
        },
        {
            valor: 2,
            etiqueta: 2
        },
        {
            valor: 3,
            etiqueta: 3 
        },
        {
            valor: 4,
            etiqueta: 4 
        },
        {
            valor: 5,
            etiqueta: 5 
        },
        {
            valor: 6,
            etiqueta: 6 
        },
        {
            valor: 7,
            etiqueta: 7 
        },
        {
            valor: 8,
            etiqueta: 8 
        },
        {
            valor: 9,
            etiqueta: 9 
        },
        {
            valor: 10,
            etiqueta: 10 
        }
    ];

    opcionesInputs['tipo_plazo_alquiler'] = 
    [
        {
            valor: "",
            etiqueta: "",
        },
        {
            valor: t('texto_257'),
            etiqueta: t('texto_257')
        },
        {
            valor: t('texto_258'),
            etiqueta: t('texto_258')
        },
        {
            valor: t('texto_259'),
            etiqueta: t('texto_259') 
        },
    ];

    opcionesInputs['tipo_pago_alquiler'] = 
    [
        {
            valor: t('texto_260'),
            etiqueta: t('texto_260')
        },
        {
            valor: t('texto_261'),
            etiqueta: t('texto_261')
        }
    ];

    opcionesInputs['regimen_ajuste_alquiler'] = 
    [
        {
            valor: t('texto_262'),
            etiqueta: t('texto_262')
        },
        {
            valor: t('texto_263'),
            etiqueta: t('texto_263')
        }
    ];

    opcionesInputs['departamento_firma'] = 
    [
        {
            valor: 'Artigas',
            etiqueta: 'Artigas'
        },
        {
            valor: 'Canelones',
            etiqueta: 'Canelones'
        },
        {
            valor: 'Cerro Largo',
            etiqueta: 'Cerro Largo'
        },
        {
            valor: 'Colonia',
            etiqueta: 'Colonia'
        },
        {
            valor: 'Durazno',
            etiqueta: 'Durazno'
        },
        {
            valor: 'Flores',
            etiqueta: 'Flores'
        },
        {
            valor: 'Florida',
            etiqueta: 'Florida'
        },
        {
            valor: 'Lavalleja',
            etiqueta: 'Lavalleja'
        },
        {
            valor: 'Maldonado',
            etiqueta: 'Maldonado'
        },
        {
            valor: 'Montevideo',
            etiqueta: 'Montevideo'
        },
        {
            valor: 'Paysandu',
            etiqueta: 'Paysandu'
        },
        {
            valor: 'Río Negro',
            etiqueta: 'Río Negro'
        },
        {
            valor: 'Rivera',
            etiqueta: 'Rivera'
        },
        {
            valor: 'Rocha',
            etiqueta: 'Rocha'
        },
        {
            valor: 'Salto',
            etiqueta: 'Salto'
        },
        {
            valor: 'San José',
            etiqueta: 'San José'
        },
        {
            valor: 'Soriano',
            etiqueta: 'Soriano'
        },
        {
            valor: 'Tacuarembo',
            etiqueta: 'Tacuarembo'
        },
        {
            valor: 'Treinta y Tres',
            etiqueta: 'Treinta y Tres'
        }
    ];

    opcionesInputs['banco'] = 
    [
        {
            valor: '',
            etiqueta: '',
        },
        {
            valor: 'BANCO BANDES',
            etiqueta: 'BANCO BANDES'
        },
        {
            valor: 'BANCO BBVA',
            etiqueta: 'BANCO BBVA'
        },
        {
            valor: 'BANCO BILBAO VIZCAYA ARGENTARIA',
            etiqueta: 'BANCO BILBAO VIZCAYA ARGENTARIA'
        },
        {
            valor: 'BANCO BROU',
            etiqueta: 'BANCO BROU'
        },
        {
            valor: 'BANQUE HERITAGE',
            etiqueta: 'BANQUE HERITAGE'
        },
        {
            valor: 'BANCO ITAU',
            etiqueta: 'BANCO ITAU'
        },
        {
            valor: 'BANCO MI DINERO',
            etiqueta: 'BANCO MI DINERO'
        },
        {
            valor: 'BANCO PREX',
            etiqueta: 'BANCO PREX'
        },
        {
            valor: 'BANCO SANTANDER',
            etiqueta: 'BANCO SANTANDER'
        },
        {
            valor: 'CITIBANK N.A.',
            etiqueta: 'CITIBANK N.A.'
        }, 
        {
            valor: 'HSBC BANK',
            etiqueta: 'HSBC BANK'
        },
        {
            valor: 'SCOTIABANK',
            etiqueta: 'SCOTIABANK'
        }
    ];

    opcionesInputs['tipo_cuenta'] = 
        [
            {
                valor: "",
                etiqueta: "",
            },
            {
                valor: t('texto_264'),
                etiqueta: t('texto_264'),
            },
            {
                valor: t('texto_265'),
                etiqueta: t('texto_265'),
            },
            {
                valor: t('texto_266'),
                etiqueta: t('texto_266'),
            },
            {
                valor: t('texto_267'),
                etiqueta: t('texto_267'),
            },
        ];

        opcionesInputs['tipo_documento_identidad'] = 
        [
            {
                valor: "",
                etiqueta: "",
            },
            {
                valor: t('texto_278'),
                etiqueta: t('texto_278'),
            },
            {
                valor: t('texto_279'),
                etiqueta: t('texto_279'),
            }
        ];

        opcionesInputs['clasificacion_persona_fisica'] = 
        [
            {
                valor: t("Propietario"),
                etiqueta: t("Propietario"),
            },
            {
                valor: t('texto_85'),
                etiqueta: t('texto_85'),
            }
        ];

        opcionesInputs['tipo_inventario'] = 
        [
            {
                valor: t('texto_311'),
                etiqueta: t('texto_311'),
            },
            {
                valor: t('texto_312'),
                etiqueta: t('texto_312'),
            }
        ];

        opcionesInputs['clasificacion_persona_juridica'] = 
        [
            {
                valor: t('texto_84'),
                etiqueta: t('texto_84'),
            },
            {
                valor: t('texto_72'),
                etiqueta: t('texto_72'),
            }
        ];

    return opcionesInputs;
}