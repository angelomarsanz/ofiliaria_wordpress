<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estudiantes = Student::all();
        if ($estudiantes->isEmpty()) 
        {
            $datos = 
                [
                    "codigoRetorno" => 1,
                    "mensaje" => "No se encontraron estudiantes",            
                ];
        }
        else
        {
            $datos = 
            [
                "codigoRetorno" => 0,
                "estudiantes" => $estudiantes
            ];
        }
        return response()->json($datos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validador = Validator::make($request->all(), 
            [
                "nombre" => "required|string|max:255",
                "edad" => "required|integer|min:12|digits_between: 1,3"
            ]);
        if ($validador->fails())
        {
            $datos =
                [
                    "codigoRetorno" => 1,
                    "mensaje" => "Error en la validación de los datos",
                    "errores" => $validador->errors()
                ];
            return response()->json($datos, 400);
        }
        $estudiante = Student::create(
            [
                "nombre" => $request->nombre,
                "edad" => $request->edad
            ]);

        if (!$estudiante)
        {
            $datos =
                [
                    "codigoRetorno" => 2,
                    "mensaje" => "No se pudo crear el estudiante"
                ];
                return response()->json($datos, 500);
        }
        $datos = 
            [
                "codigoRetorno" => 0,
                "estudiante" => $estudiante
            ];
        return response()->json($datos, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $estudiante = Student::find($id);
        if (!$estudiante)
        {
            $datos = 
                [
                    "codigoRetorno" => 1,
                    "mensaje" => "Estudiante no encontrado"
                ];
            return response()->json($datos, 404);
        }
        $datos =
            [
                "codigoRetorno" => 0,
                "estudiante" => $estudiante
            ];
        return response()->json($datos, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $estudiante = Student::find($id);
        if (!$estudiante)
        {
            $datos =
                [
                    "codigoRetorno" => 1,
                    "mensaje" => "Estudiante no encontrado"
                ];
            return response()->json($datos, 404);
        }

        $validador = Validator::make($request->all(), 
        [
            "nombre" => "required|string|max:255",
            "edad" => "required|integer|min:12|digits_between: 1,3"
        ]);
        
        if ($validador->fails())
        {
            $datos =
                [
                    "codigoRetorno" => 2,
                    "mensaje" => "Error en la validación de los datos",
                    "errores" => $validador->errors()
                ];
            return response()->json($datos, 400);
        }

        $estudiante->nombre = $request->nombre;
        $estudiante->edad = $request->edad;

        $estudiante->save();

        $datos =
            [
                "codigoRetorno" => 0,
                "estudiante" => $estudiante 
            ];
        return response()->json($datos, 200);

    }

    public function updatePartial(Request $request, $id)
    {

        $estudiante = Student::find($id);
        if (!$estudiante)
        {
            $datos =
                [
                    "codigoRetorno" => 1,
                    "mensaje" => "Estudiante no encontrado"
                ];
            return response()->json($datos, 404);
        }
        
        $validador = Validator::make($request->all(), 
        [
            "nombre" => "string|max:255",
            "edad" => "integer|min:12|digits_between: 1,3"
        ]);
        
        if ($validador->fails())
        {
            $datos =
                [
                    "codigoRetorno" => 2,
                    "mensaje" => "Error en la validación de los datos",
                    "errores" => $validador->errors()
                ];
            return response()->json($datos, 400);
        }
         
        if ($request->has("nombre"))
        {
            $estudiante->nombre = $request->nombre;
        }

        if ($request->has("edad"))
        {
            $estudiante->edad = $request->edad;
        }
        
        $estudiante->save();

        $datos =
            [
                "codigoRetorno" => 0,
                "mensaje" => "Estudiante actualizado",
                "estudiante" => $estudiante
            ];
        
        return response()->json($datos, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $estudiante = Student::find($id);

        if (!$estudiante)
        {
            $datos =
                [
                    "codigoRetorno" => 1,
                    "mensaje" => "Estudiante no encontrado"
                ];
            return response()->json($datos, 404);
        }

        $estudiante->delete();

        $datos =
            [
                "codigoRetorno" => 0,
                "mensaje" => "Estudiante eliminado"
            ];
        return response()->json($datos, 200);
    }
}
