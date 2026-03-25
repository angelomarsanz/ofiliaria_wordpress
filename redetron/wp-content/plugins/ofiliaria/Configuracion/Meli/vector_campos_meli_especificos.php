Chacras, Alquiler
[
	{
		"id": "CONTACT_SCHEDULE",
		"name": "Horario de contacto",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "string",
		"value_max_length": 255,
		"attribute_group_id": "FIND",
		"attribute_group_name": "Ficha técnica"
	},
	{
		"id": "PROPERTY_TYPE",
		"name": "Inmueble",
		"tags": {
			"fixed": true,
			"hidden": true
		},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "list",
		"values": [
			{
				"id": "242070",
				"name": "Quinta"
			}
		],
		"attribute_group_id": "FIND",
		"attribute_group_name": "Ficha técnica"
	},
	{
		"id": "OPERATION",
		"name": "Operación",
		"tags": {
			"fixed": true,
			"hidden": true
		},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "list",
		"values": [
			{
				"id": "242073",
				"name": "Alquiler"
			}
		],
		"attribute_group_id": "FIND",
		"attribute_group_name": "Ficha técnica"
	},
	{
		"id": "TOTAL_AREA",
		"name": "Superficie total",
		"tags": {
			"required": true,
			"catalog_listing_required": true
		},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "number_unit",
		"value_max_length": 255,
		"allowed_units": [
			{
				"id": "ha",
				"name": "ha"
			},
			{
				"id": "m²",
				"name": "m²"
			}
		],
		"default_unit": "m²",
		"attribute_group_id": "FIND",
		"attribute_group_name": "Ficha técnica"
	},
	{
		"id": "COVERED_AREA",
		"name": "Área privada",
		"tags": {
			"required": true,
			"catalog_listing_required": true
		},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "number_unit",
		"value_max_length": 255,
		"allowed_units": [
			{
				"id": "m²",
				"name": "m²"
			}
		],
		"default_unit": "m²",
		"attribute_group_id": "FIND",
		"attribute_group_name": "Ficha técnica"
	},
	{
		"id": "LAND_ACCESS",
		"name": "Acceso",
		"tags": {
			"required": true,
			"catalog_listing_required": true
		},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "list",
		"values": [
			{
				"id": "245049",
				"name": "Tierra"
			},
			{
				"id": "245045",
				"name": "Arena"
			},
			{
				"id": "245046",
				"name": "Asfalto"
			},
			{
				"id": "245047",
				"name": "Otro"
			},
			{
				"id": "245048",
				"name": "Ripio"
			}
		],
		"attribute_group_id": "FIND",
		"attribute_group_name": "Ficha técnica"
	},
	{
		"id": "ROOMS",
		"name": "Ambientes",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "number",
		"value_max_length": 18,
		"attribute_group_id": "FIND",
		"attribute_group_name": "Ficha técnica"
	},
	{
		"id": "BEDROOMS",
		"name": "Dormitorios",
		"tags": {
			"required": true,
			"catalog_listing_required": true
		},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "number",
		"value_max_length": 18,
		"attribute_group_id": "FIND",
		"attribute_group_name": "Ficha técnica"
	},
	{
		"id": "FULL_BATHROOMS",
		"name": "Baños",
		"tags": {
			"required": true,
			"catalog_listing_required": true
		},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "number",
		"value_max_length": 18,
		"attribute_group_id": "FIND",
		"attribute_group_name": "Ficha técnica"
	},
	{
		"id": "PARKING_LOTS",
		"name": "Cocheras",
		"tags": {
			"required": true,
			"catalog_listing_required": true
		},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "number",
		"value_max_length": 18,
		"attribute_group_id": "FIND",
		"attribute_group_name": "Ficha técnica",
		"hint": "Si no tiene estacionamientos, indica 0."
	},
	{
		"id": "WAREHOUSES",
		"name": "Bodegas",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "number",
		"value_max_length": 18,
		"attribute_group_id": "FIND",
		"attribute_group_name": "Ficha técnica"
	},
	{
		"id": "PROPERTY_AGE",
		"name": "Antigüedad",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "number_unit",
		"value_max_length": 255,
		"allowed_units": [
			{
				"id": "años",
				"name": "años"
			}
		],
		"default_unit": "años",
		"attribute_group_id": "FIND",
		"attribute_group_name": "Ficha técnica"
	},
	{
		"id": "PAVED_ROAD_DISTANCE",
		"name": "Distancia al asfalto",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "number_unit",
		"value_max_length": 255,
		"allowed_units": [
			{
				"id": "km",
				"name": "km"
			}
		],
		"default_unit": "km",
		"attribute_group_id": "FIND",
		"attribute_group_name": "Ficha técnica"
	},
	{
		"id": "LOT_SHAPE",
		"name": "Forma del terreno",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "list",
		"values": [
			{
				"id": "245110",
				"name": "Regular"
			},
			{
				"id": "245108",
				"name": "Irregular"
			},
			{
				"id": "245109",
				"name": "Plano"
			}
		],
		"attribute_group_id": "FIND",
		"attribute_group_name": "Ficha técnica"
	},
	{
		"id": "MAINTENANCE_FEE",
		"name": "Gastos comunes",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "number_unit",
		"value_max_length": 255,
		"allowed_units": [
			{
				"id": "USD",
				"name": "USD"
			},
			{
				"id": "UYU",
				"name": "UYU"
			}
		],
		"default_unit": "UYU",
		"attribute_group_id": "FIND",
		"attribute_group_name": "Ficha técnica"
	},
	{
		"id": "CONDO_VALUE",
		"name": "Valor del condominio",
		"tags": {
			"hidden": true
		},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "number",
		"value_max_length": 18,
		"attribute_group_id": "OTHERS",
		"attribute_group_name": "Otros"
	},
	{
		"id": "HAS_INTERNET_ACCESS",
		"name": "Acceso a internet",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "COMOYAMEN",
		"attribute_group_name": "Comodidades y amenities"
	},
	{
		"id": "HAS_TAP_WATER",
		"name": "Agua corriente",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			},
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			}
		],
		"attribute_group_id": "CARACTERISTICAS",
		"attribute_group_name": "Características adicionales"
	},
	{
		"id": "HAS_AIR_CONDITIONING",
		"name": "Aire acondicionado",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "COMOYAMEN",
		"attribute_group_name": "Comodidades y amenities"
	},
	{
		"id": "HAS_PLAYGROUND",
		"name": "Área de juegos infantiles",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "COMOYAMEN",
		"attribute_group_name": "Comodidades y amenities"
	},
	{
		"id": "HAS_STABLE",
		"name": "Caballeriza",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "CARACTERISTICAS",
		"attribute_group_name": "Características adicionales"
	},
	{
		"id": "HAS_HEATING",
		"name": "Calefacción",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "COMOYAMEN",
		"attribute_group_name": "Comodidades y amenities"
	},
	{
		"id": "HAS_BASKETBALL_COURT",
		"name": "Cancha de básquetbol",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			},
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			}
		],
		"attribute_group_id": "COMOYAMEN",
		"attribute_group_name": "Comodidades y amenities"
	},
	{
		"id": "HAS_FOOTBALL_PITCH",
		"name": "Cancha de fútbol",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "COMOYAMEN",
		"attribute_group_name": "Comodidades y amenities"
	},
	{
		"id": "HAS_PADDLE_COURT",
		"name": "Cancha de paddle",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "COMOYAMEN",
		"attribute_group_name": "Comodidades y amenities"
	},
	{
		"id": "HAS_TENNIS_COURT",
		"name": "Cancha de tenis",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "COMOYAMEN",
		"attribute_group_name": "Comodidades y amenities"
	},
	{
		"id": "HAS_INDOOR_FIREPLACE",
		"name": "Chimenea",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "COMOYAMEN",
		"attribute_group_name": "Comodidades y amenities"
	},
	{
		"id": "HAS_DRAINAGE",
		"name": "Saneamiento",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "CARACTERISTICAS",
		"attribute_group_name": "Características adicionales"
	},
	{
		"id": "HAS_KITCHEN",
		"name": "Cocina",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "AMBIENTES",
		"attribute_group_name": "Ambientes"
	},
	{
		"id": "HAS_DINNING_ROOM",
		"name": "Comedor",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "AMBIENTES",
		"attribute_group_name": "Ambientes"
	},
	{
		"id": "HAS_MAID_ROOM",
		"name": "Dormitorio de servicio",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "AMBIENTES",
		"attribute_group_name": "Ambientes"
	},
	{
		"id": "HAS_BEDROOM_SUITE",
		"name": "Dormitorio en suite",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "AMBIENTES",
		"attribute_group_name": "Ambientes"
	},
	{
		"id": "HAS_STUDY",
		"name": "Estudio",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "AMBIENTES",
		"attribute_group_name": "Ambientes"
	},
	{
		"id": "HAS_NATURAL_GAS",
		"name": "Gas natural",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "CARACTERISTICAS",
		"attribute_group_name": "Características adicionales"
	},
	{
		"id": "HAS_JACUZZI",
		"name": "Jacuzzi",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "COMOYAMEN",
		"attribute_group_name": "Comodidades y amenities"
	},
	{
		"id": "HAS_TELEPHONE_LINE",
		"name": "Línea telefónica",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "CARACTERISTICAS",
		"attribute_group_name": "Características adicionales"
	},
	{
		"id": "HAS_LIVING_ROOM",
		"name": "Living",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "AMBIENTES",
		"attribute_group_name": "Ambientes"
	},
	{
		"id": "HAS_ELECTRIC_LIGHT",
		"name": "Luz eléctrica",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "CARACTERISTICAS",
		"attribute_group_name": "Características adicionales"
	},
	{
		"id": "HAS_GRILL",
		"name": "Parrillero",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "AMBIENTES",
		"attribute_group_name": "Ambientes"
	},
	{
		"id": "HAS_PATIO",
		"name": "Patio",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "AMBIENTES",
		"attribute_group_name": "Ambientes"
	},
	{
		"id": "HAS_SWIMMING_POOL",
		"name": "Piscina",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			},
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			}
		],
		"attribute_group_id": "COMOYAMEN",
		"attribute_group_name": "Comodidades y amenities"
	},
	{
		"id": "HAS_PLAYROOM",
		"name": "Cuarto de juegos",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "AMBIENTES",
		"attribute_group_name": "Ambientes"
	},
	{
		"id": "HAS_SECURITY",
		"name": "Circuito de cámaras de seguridad",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "COMOYAMEN",
		"attribute_group_name": "Comodidades y amenities"
	},
	{
		"id": "HAS_TERRACE",
		"name": "Terraza",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "AMBIENTES",
		"attribute_group_name": "Ambientes"
	},
	{
		"id": "HAS_HALF_BATH",
		"name": "Baño social",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "AMBIENTES",
		"attribute_group_name": "Ambientes"
	},
	{
		"id": "HAS_DRESSING_ROOM",
		"name": "Vestidor",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "AMBIENTES",
		"attribute_group_name": "Ambientes"
	},
	{
		"id": "WITH_VIRTUAL_TOUR",
		"name": "Con tour virtual",
		"tags": {
			"hidden": true
		},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "OTHERS",
		"attribute_group_name": "Otros"
	},
	{
		"id": "CMG_SITE",
		"name": "Sitio de origen",
		"tags": {
			"hidden": true
		},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "string",
		"value_max_length": 255,
		"attribute_group_id": "FIND",
		"attribute_group_name": "Ficha técnica"
	},
	{
		"id": "CANONICAL_URL",
		"name": "Url canónica",
		"tags": {
			"hidden": true
		},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "string",
		"value_max_length": 255,
		"attribute_group_id": "FIND",
		"attribute_group_name": "Ficha técnica"
	},
	{
		"id": "HAS_LAUNDRY",
		"name": "Con lavadero",
		"tags": {
			"hidden": true
		},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "OTHERS",
		"attribute_group_name": "Otros"
	},
	{
		"id": "HAS_CABLE_TV",
		"name": "TV por cable",
		"tags": {
			"hidden": true
		},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "boolean",
		"values": [
			{
				"id": "242084",
				"name": "No",
				"metadata": {
					"value": false
				}
			},
			{
				"id": "242085",
				"name": "Sí",
				"metadata": {
					"value": true
				}
			}
		],
		"attribute_group_id": "OTHERS",
		"attribute_group_name": "Otros"
	},
	{
		"id": "PRICE_PER_AREA_UNIT",
		"name": "Precio por unidad de área",
		"tags": {
			"hidden": true
		},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "number_unit",
		"value_max_length": 255,
		"allowed_units": [
			{
				"id": "$/ha",
				"name": "$/ha"
			},
			{
				"id": "$/m2",
				"name": "$/m2"
			}
		],
		"default_unit": "$/m2",
		"attribute_group_id": "OTHERS",
		"attribute_group_name": "Otros"
	},
	{
		"id": "PROPERTY_CODE",
		"name": "Código de la propiedad",
		"tags": {},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "string",
		"value_max_length": 255,
		"attribute_group_id": "OTHERS",
		"attribute_group_name": "Otros"
	},
	{
		"id": "SOCIAL_STRATUM",
		"name": "Estrato social",
		"tags": {
			"hidden": true
		},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "number",
		"value_max_length": 18,
		"attribute_group_id": "OTHERS",
		"attribute_group_name": "Otros"
	},
	{
		"id": "PHONE_ID",
		"name": "Identificador de teléfono",
		"tags": {
			"hidden": true
		},
		"hierarchy": "ITEM",
		"relevance": 1,
		"value_type": "string",
		"value_max_length": 255,
		"attribute_group_id": "OTHERS",
		"attribute_group_name": "Otros"
	},
	{
		"id": "ITEM_CONDITION",
		"name": "Condición del ítem",
		"tags": {
			"hidden": true
		},
		"hierarchy": "ITEM",
		"relevance": 2,
		"value_type": "list",
		"values": [
			{
				"id": "2230581",
				"name": "Usado"
			},
			{
				"id": "2230284",
				"name": "Nuevo"
			}
		],
		"attribute_group_id": "DFLT",
		"attribute_group_name": "Otros"
	}
]