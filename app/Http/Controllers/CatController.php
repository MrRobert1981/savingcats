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
        $windowTitle = "Registrar un nuevo gato";
        $submitButtonText = "Registrar";
        $isNew = true;
        return view('register-or-update-cat', compact('windowTitle', 'submitButtonText', 'isNew'));
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

    return redirect()->route('cats.not_adopted')->with('success', 'Gato registrado correctamente.');
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
    public function edit(Request $request)
    {
        $windowTitle = "Editar un gato";
        $submitButtonText = "Actualizar";
        $isNew = false;
        $cat = Cat::findOrFail($request->input('id'));
        return view('register-or-update-cat', compact('windowTitle', 'submitButtonText', 'isNew', 'cat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
    $validated = $request->validate([
    'name' => 'required|string|max:255',
    'date_of_birth' => 'required|date|before_or_equal:today',
    'sex' => 'required|in:male,female',
    'image_path' => 'nullable|image|mimes:jpg,jpeg|max:2048'
    ]);

    $cat = Cat::findOrFail($request->input('id'));

    $changes = false;
    foreach ($validated as $key => $value) {
        if ($key === 'image_path') {
            continue;
        }

        if ($cat->$key != $value) {
            $changes = true;
            break;
        }
    }

    if ($changes) {
    $cat->update(collect($validated)->except('image_path')->toArray());
    }

    if ($request->hasFile('image_path')) {
        $file = $request->file('image_path');
        $extension = $file->getClientOriginalExtension();
        $filename = $cat->id . '.' . $extension;
        $path = $file->storeAs('images/cats', $filename, 'public');

        $cat->update([
            'image_path' => 'images/cats/' . $filename,
        ]);
    }
        
    return redirect()->route('cats.not_adopted')->with('success', 'Gato actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cat $cat)
    {
        //
    }
    public function guestAdoption()
    {
    return redirect()->route('cats.not_adopted')->with('info', 'Para adoptar un gato debes registrarte o iniciar sesión');
    }
}
