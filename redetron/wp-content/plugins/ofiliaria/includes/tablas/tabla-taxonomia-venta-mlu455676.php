<?php

// Categoría Ventas Apartamentos: MLU455676

$taxonomia = "property_category";
$slug_categoria = "venta_mlu455676"

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
            "id" => "MLU455673",
            "name" => "Emprendimientos",
        ],
        [
            "id" => "MLU1474",
            "name" => "Propiedades Individuales",
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