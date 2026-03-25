<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = 
            DB::table('categorias')->get();
        
        $datos = 
            [
                "codigoRetorno" => 0,
                "categorias" => $categorias
            ];
        return response()->json($datos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    
    public function show($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
    public function importarCategoriasMeli($token)
    {
        Categoria::truncate();
        $nivel_1 = '';
        $nivel_2 = '';
        $nivel_3 = '';
        $nivel_4 = '';
        $nivel_5 = '';
		
		$vector_categoria = $this->buscarCategoria('MLU1459', $token);
        $nivel_1 = $vector_categoria->name; // Nivel 1, Inmuebles
        $nivel_2 = '';
        $nivel_3 = '';
        $nivel_4 = '';
        $nivel_5 = '';
        $respuesta_insertar_categoria = $this->insertarCategoria($nivel_1, $nivel_2, $nivel_3, $nivel_4, $nivel_5, $vector_categoria, $token ); 
        if (empty($vector_categoria->children_categories) == false)
        {
            $categorias = $vector_categoria->children_categories;
            foreach ($categorias as $categoria)
            {
                $vector_categoria = $this->buscarCategoria($categoria->id, $token);
                $nivel_2 = $vector_categoria->name; // Nivel 2, Tipos de inmueble
                $nivel_3 = '';
                $nivel_4 = '';
                $nivel_5 = '';
                $respuesta_insertar_categoria = $this->insertarCategoria($nivel_1, $nivel_2, $nivel_3, $nivel_4, $nivel_5, $vector_categoria, $token );
                if (empty($vector_categoria->children_categories) == false)
                { 
                    $categorias = $vector_categoria->children_categories;
                    foreach ($categorias as $categoria)
                    {
                        $vector_categoria = $this->buscarCategoria($categoria->id, $token);
                        $nivel_3 = $vector_categoria->name; // Nivel 3, Alquiler, Alquiler por temporada y Venta
                        $nivel_4 = '';
                        $nivel_5 = '';
                        $respuesta_insertar_categoria = $this->insertarCategoria($nivel_1, $nivel_2, $nivel_3, $nivel_4, $nivel_5, $vector_categoria, $token ); 
                        if (empty($vector_categoria->children_categories) == false)
                        { 
                            $categorias = $vector_categoria->children_categories;
                            foreach ($categorias as $categoria)
                            {
                                $vector_categoria = $this->buscarCategoria($categoria->id, $token);
                                $nivel_4 = $vector_categoria->name; // Nivel 4, Emprendimientos y propiedades individuales
                                $nivel_5 = '';
                                $respuesta_insertar_categoria = $this->insertarCategoria($nivel_1, $nivel_2, $nivel_3, $nivel_4, $nivel_5, $vector_categoria, $token ); 
                                if (empty($vector_categoria->children_categories) == false)
                                { 
                                    $categorias = $vector_categoria->children_categories;
                                    foreach ($categorias as $categoria)
                                    {
                                        $vector_categoria = $this->buscarCategoria($categoria->id, $token);
                                        $nivel_5 = $vector_categoria->name; // Nivel 5, Otros niveles
                                        $respuesta_insertar_categoria = $this->insertarCategoria($nivel_1, $nivel_2, $nivel_3, $nivel_4, $nivel_5, $vector_categoria, $token ); 
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        exit('Proceso de carga de categorias finalizado');
	}
	
	public function buscarCategoria($id_categoria = null, $token = null)
	{
		$url = "https://api.mercadolibre.com/categories/".$id_categoria;
		$headers = 
			[
				"Authorization: Bearer ".$token
			];
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$respuesta = curl_exec($curl);
		curl_close($curl);
		$vector_respuesta = json_decode($respuesta);
		return $vector_respuesta;
	}

	public function insertarCategoria($nivel_1, $nivel_2, $nivel_3, $nivel_4, $nivel_5, $vector_categoria, $token )
	{
        $vector_atributos = $this->buscarAtributosCategoria($vector_categoria->id, $token);
        
        $atributosRequeridos = [];
        $atributosEspecificosRequeridos = [];

        foreach ($vector_categoria->settings as $indice => $valor)
        {
            if ($valor === 'required')
            {
                $atributosRequeridos[$indice] = $indice;
            }
        }

        foreach ($vector_atributos as $atributo)
        {
            if (isset($atributo->tags->required))
            {
                if ($atributo->tags->required === true)
                {
                    $atributosEspecificosRequeridos[$atributo->id] = $atributo->name;
                }
            }
        }

        $columnasCategoria = 
        [
            'nivel_1' => $nivel_1,
            'nivel_2' => $nivel_2,
            'nivel_3' => $nivel_3,
            'nivel_4' => $nivel_4,
            'nivel_5' => $nivel_5,
            'nombre_categoria' => $vector_categoria->name,
            'identificador_meli' => $vector_categoria->id,
            'atributos_requeridos' => json_encode($atributosRequeridos),
            'atributos' => json_encode($vector_categoria->settings),
            'atributos_especificos_requeridos' => json_encode($atributosEspecificosRequeridos),
            'atributos_especificos' => json_encode($vector_atributos)
        ];

        $categoria = Categoria::create($columnasCategoria);

        if (!$categoria)
        {
            $datos =
                [
                    "codigoRetorno" => 1,
                    "mensaje" => "No se pudo crear la categoria ".$vector_categoria-id." ".$vector_categoria->name
                ];
                return response()->json($datos, 200);
        }
	}

	public function buscarAtributosCategoria($id_categoria = null, $token = null)
	{
		$url = "https://api.mercadolibre.com/categories/".$id_categoria."/attributes";
		$headers = 
			[
				"Authorization: Bearer ".$token
			];
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$respuesta_atributos = curl_exec($curl);
		curl_close($curl);
		$vector_respuesta_atributos = json_decode($respuesta_atributos);
		return $vector_respuesta_atributos;
	}
    /**
     * Muestra una categoría específica por su identificador_meli.
     *
     * @param string $identificadorMeli El identificador_meli de la categoría a buscar.
     * @return \Illuminate\Http\JsonResponse
     */
    public function buscarCategoriaMeli($identificadorMeli)
    {
        // Buscar la categoría por la columna 'identificador_meli'
        $categoria = Categoria::where('identificador_meli', $identificadorMeli)->first();

        if (!$categoria)
        {
            return response()->json([
                'codigo_retorno' => 201, // Error: Categoría no encontrada por identificador_meli
                'mensaje'        => 'Categoría con identificador_meli ' . $identificadorMeli . ' no encontrada.',
                'datos'          => null
            ], 404); // Código de estado HTTP 404 Not Found
        }
        else
        {
            return response()->json([
                'codigo_retorno' => 0, // Éxito
                'mensaje'        => 'Categoría encontrada exitosamente por identificador_meli.',
                'datos'          => $categoria // Devuelve el registro completo de la categoría
            ], 200); // Código de estado HTTP 200 OK
        }
    }
}
