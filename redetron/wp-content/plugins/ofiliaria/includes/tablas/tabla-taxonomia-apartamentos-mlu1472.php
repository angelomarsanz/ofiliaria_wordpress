<?php

// Categoría Apartamentos: MLU1472

$taxonomia = "property_category";
$slug_categoria = "apartamentos_mlu1472"

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
			"id" => "MLU1473",
			"name" => "Alquiler",
			"total_items_in_this_category" => 17095
		],
		[
			"id" => "MLU6393",
			"name" => "Alquiler Temporada",
			"total_items_in_this_category" => 21121
		],
		[
			"id" => "MLU455676",
			"name" => "Venta",
			"total_items_in_this_category" => 86384
		]
	];
	
	$registro_padre = $wpdb->get_row( "SELECT * FROM ofil_terms WHERE slug = '$slug_categoria'" );

	$id_Padre = $registro_padre->term_id; 

	foreach ($terminos_a_insertar as $terminos)
	{
		$termino = $terminos["name"]; 	
		$descripcion = $terminos["name"];	
		$slug = strtolower($terminos["name"].'-'.$terminos["id"]);
		$vectorArgumentos = ['description' => $descripcion, 'parent' => $id_Padre, 'slug' => $slug];

		$codigoRetorno = wp_insert_term($termino, $taxonomia, $vectorArgumentos);
		if ( $codigoRetorno && is_wp_error( $codigoRetorno ) ) 
		{
			wp_die('<h1>' . __( 'Error al insertar el término ' . $termino ) . '</h1>');
		}
	}
	update_option('_ofiliaria_taxonomia_'.$slug_categoria, 'yes');
}