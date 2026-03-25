<?php

namespace App\Http\Controllers;

use App\Models\Prueba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PruebaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pruebas = Prueba::all();
        return view('Pruebas.index', compact('pruebas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Pruebas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $prueba = Prueba::create($request->all());
        if ($request->hasFile('imagen'))
        {
            $indicadorArchivos = 1;
            $nombreImagen = $prueba->id.'-imagen.'.$request->file('imagen')->getClientOriginalExtension();
            $imagen = $request->file('imagen')->storeAs('public/img', $nombreImagen);
            $prueba->imagen = '/img/'.$nombreImagen;
            $prueba->save();
        }
        return redirect()->route('pruebas.index')->with('success', 'Prueba creada');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prueba $prueba)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prueba $prueba)
    {
        return view('Pruebas.edit', compact('prueba'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prueba $prueba)
    {
        if ($request->hasFile('imagen'))
        {
            Storage::disk('public')->delete($prueba->imagen);
            $nombreImagen = $prueba->id.'.'.$request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->storeAs('public/img', $nombreImagen);
            $prueba->imagen = '/img/'.$nombreImagen;
            $prueba->save();
        }

        $prueba->update($request->input());
        return redirect()->route('pruebas.index')->with('success', 'Prueba actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prueba $prueba)
    {
        Storage::disk('public')->delete($prueba->imagen);
        $prueba->delete();
        return redirect()->route('pruebas.index')->with('success', 'Prueba eliminada');
    }
}
