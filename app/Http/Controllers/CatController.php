<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Http\Request;

class CatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Solo gatos no adoptados
        $cats = Cat::where('is_adopted', false)->get();
        $are_adopted = false;
        return view('welcome', compact('cats', 'are_adopted'));
    }

    public function indexAdopted()
    {
        // Solo gatos adoptados
        $cats = Cat::where('is_adopted', true)->get();
        $are_adopted = true;
        return view('welcome', compact('cats', 'are_adopted'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('register-or-update-cat');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validación de entrada
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'date_of_birth' => 'required|date|before_or_equal:today',
        'sex' => 'required|in:male,female',
        'image_path' => 'required|image|mimes:jpg,jpeg|max:2048',
        'is_adopted' => 'nullable|boolean',
        'owner_id' => 'nullable|exists:users,id',
    ]);

    // Guardar los datos sin la imagen (el campo image_path se deja vacío de momento)
    $cat = Cat::create([
        'name' => $validated['name'],
        'date_of_birth' => $validated['date_of_birth'],
        'sex' => $validated['sex'],
        'is_adopted' => $request->has('is_adopted'),
        'owner_id' => $validated['owner_id'] ?? null,
        'image_path' => '', // se actualizará después
    ]);

    // Subir la imagen con el ID como nombre de archivo
    if ($request->hasFile('image_path')) {
        $file = $request->file('image_path');
        $extension = $file->getClientOriginalExtension();
        $filename = $cat->id . '.' . $extension;
        $path = $file->storeAs('images/cats', $filename, 'public');

        // Actualizar la ruta de la imagen en la base de datos
        $cat->update([
            'image_path' => 'images/cats/' . $filename,
        ]);
    }

    // Redireccionar o responder como prefieras
    //return redirect()->route('cats.index')->with('success', 'Cat created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(Cat $cat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cat $cat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cat $cat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cat $cat)
    {
        //
    }
}
