<?php

// Categoría Inmuebles: MLU1459

$taxonomia = "property_category";
$slug_categoria = "mlu1459-inmuebles";
$slug_categoria_guion_bajo = "mlu1459_inmuebles";

$excepciones =
	[
		// "MLU1472" => "MLU1472",
		"MLU1496" => "MLU1496",
		"MLU1466" => "MLU1466",
		"MLU50547" => "MLU50547",
		"MLU50636" => "MLU50636",
		"MLU455466" => "MLU455466",
		"MLU211280" => "MLU211280",
		"MLU50630" => "MLU50630",
		"MLU1478" => "MLU1478",
		"MLU50633" => "MLU50633",
		"MLU1892" => "MLU1892",
		"MLU1493" => "MLU1493",
	];

if ( get_option('_ofiliaria_taxonomia_'.$slug_categoria_guion_bajo) !== 'yes') 
{
	$registro_padre = $wpdb->get_row( "SELECT * FROM ofil_terms WHERE slug = '$slug_categoria'" );

	$id_Padre = $registro_padre->term_id; 

	$vector_respuesta_meli = buscar_categoria_meli('MLU1459');

	if (empty($vector_respuesta_meli->children_categories))
	{
		update_option('_ofiliaria_children_categories', 'vector vacío', null);
		guardar_atributos('MLU1459');
	}
	else
	{
		update_option('_ofiliaria_children_categories', $vector_respuesta_meli->children_categories, null);
		$terminos_insertar = $vector_respuesta_meli->children_categories;
		foreach ($terminos_insertar as $termino_insertar)
		{
			$respuesta_insertar_categoria = insertar_categoria ($id_padre, $termino_insertar->id, $termino_insertar->name); 
		}
	}
	update_option('_ofiliaria_taxonomia_'.$slug_categoria_guion_bajo, 'yes', null);
}	