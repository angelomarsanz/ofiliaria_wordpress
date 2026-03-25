<?php

// Categoría Inmuebles: MLU1459

$taxonomia = "property_category";
$slug_categoria = "mlu1459-inmuebles"

if ( get_option('_ofiliaria_taxonomia_'.$slug_categoria) !== 'yes') 
{
	/* Insertar aquí un array asociativo con los términos a insertar según el modelo
	$terminos_a_insertar = 
		[
			[
				"id" => "xxx",
				"name" => "xxx",
				Otros elementos....
			],
			[
				"id => "yyy",
				"name" => "yyy",
				Otros elementos....
			]
		]
	*/

	$terminos_a_insertar =
		[
			[
				"id" => "MLU1472",
				"name" => "Apartamentos",
				"total_items_in_this_category" => 124600
			],
			[
				"id" => "MLU1496",
				"name" => "Campos",
				"total_items_in_this_category" => 3791
			],
			[
				"id" => "MLU1466",
				"name" => "Casas",
				"total_items_in_this_category" => 59068
			],
			[
				"id" => "MLU50547",
				"name" => "Chacras",
				"total_items_in_this_category" => 3899
			],
			[
				"id" => "MLU50636",
				"name" => "Cocheras",
				"total_items_in_this_category" => 405
			],
			[
				"id" => "MLU455466",
				"name" => "Depósitos y Galpones",
				"total_items_in_this_category" => 1106
			],
			[
				"id" => "MLU211280",
				"name" => "Habitaciones",
				"total_items_in_this_category" => 197
			],
			[
				"id" => "MLU50630",
				"name" => "Llave de Negocio",
				"total_items_in_this_category" => 364
			],
			[
				"id" => "MLU1478",
				"name" => "Locales",
				"total_items_in_this_category" => 5870
			],
			[
				"id" => "MLU50633",
				"name" => "Oficinas",
				"total_items_in_this_category" => 2615
			],
			[
				"id" => "MLU1892",
				"name" => "Otros Inmuebles",
				"total_items_in_this_category" => 1861
			],
			[
				"id" => "MLU1493",
				"name" => "Terrenos y Lotes",
				"total_items_in_this_category" => 16023
			] 
		];

	$registro_padre = $wpdb->get_row( "SELECT * FROM ofil_terms WHERE slug = '$slug_categoria'" );

	$id_Padre = $registro_padre->term_id; 

	foreach ($terminos_a_insertar as $terminos)
	{
		$termino = $terminos["name"]; 	
		$descripcion = $terminos["name"];	
		$slug = strtolower($terminos["id"].'-'.$terminos["name"]);
		$vectorArgumentos = ['description' => $descripcion, 'parent' => $id_Padre, 'slug' => $slug];

		$codigoRetorno = wp_insert_term($termino, $taxonomia, $vectorArgumentos);
		if ( $codigoRetorno && is_wp_error( $codigoRetorno ) ) 
		{
			wp_die('<h1>' . __( 'Error al insertar el término ' . $termino ) . '</h1>');
		}
	}
	update_option('_ofiliaria_taxonomia_'.$slug_categoria, 'yes');
}