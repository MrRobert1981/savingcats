<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\Sex;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sexName = $request->query('sex');

        $query = Cat::where('is_adopted', false);

        if ($sexName === 'male' || $sexName === 'female') {
            $sexId = Sex::where('name', $sexName)->value('id');

            if ($sexId) {
                $query->where('sex_id', $sexId);
            }
        }

        $cats = $query->get();

        $are_adopted = false;
        $applied_sex_filter = $sexName ?? null;

        return view('welcome', compact('cats', 'are_adopted', 'applied_sex_filter'));
    }


    public function indexAdopted()
    {
        // Solo gatos adoptados
        $cats = Cat::with('sex')
            ->where('is_adopted', true)
            ->get();

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
            'image_path' => 'required|image|mimes:jpg,jpeg|max:2048'
        ]);

        // Guardar los datos sin la imagen (el campo image_path se deja vacío de momento)
        $sexId = Sex::where('name', $validated['sex'])->first();

        $cat = Cat::create([
            'name' => $validated['name'],
            'date_of_birth' => $validated['date_of_birth'],
            'sex_id' => $sexId ? $sexId->id : null,
            'is_adopted' => false,
            'owner_id' => $validated['owner_id'] ?? null,
            'image_path' => '',
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

        return redirect()->route('cats.not_adopted')->with('success', '🐈 registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $cat = Cat::with('sex')->findOrFail($request->input('id'));

        $birthDate = Carbon::parse($cat->date_of_birth);
        $now = Carbon::now();

        if ($birthDate->isToday()) {
            $ageString = 'Recién nacido';
        } else {
            $years = (int) $birthDate->diffInYears($now);
            $birthDate = $birthDate->addYears($years);

            $months = (int) $birthDate->diffInMonths($now);
            $birthDate = $birthDate->addMonths($months);

            $weeks = (int) $birthDate->diffInWeeks($now);
            $birthDate = $birthDate->addWeeks($weeks);

            $days = (int) $birthDate->diffInDays($now);

            if ($years > 0) {
                $ageString = $years . ' año' . ($years > 1 ? 's' : '');
                if ($months > 0) {
                    $ageString .= ' y ' . $months . ' mes' . ($months > 1 ? 'es' : '');
                }
            } elseif ($months > 0) {
                $ageString = $months . ' mes' . ($months > 1 ? 'es' : '');
                if ($weeks > 0) {
                    $ageString .= ' y ' . $weeks . ' semana' . ($weeks > 1 ? 's' : '');
                }
            } elseif ($weeks > 0) {
                $ageString = $weeks . ' semana' . ($weeks > 1 ? 's' : '');
                if ($days > 0) {
                    $ageString .= ' y ' . $days . ' día' . ($days > 1 ? 's' : '');
                }
            } else {
                $ageString = $days . ' día' . ($days > 1 ? 's' : '');
            }
        }

        $windowTitle = "Solicitud de adopción";
        $submitButtonText = "Enviar";
        return view('cat-adoption', compact('cat', 'ageString', 'windowTitle', 'submitButtonText'));
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
            $sexId = Sex::where('name', $validated['sex'])->firstOrFail()->id;
            $dataToUpdate = collect($validated)->except(['sex', 'image_path'])->toArray();
            $dataToUpdate['sex_id'] = $sexId;
            $cat->update($dataToUpdate);
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

        return redirect()->route('cats.not_adopted')->with('success', '🐈 actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $cat = Cat::find($id);

        if ($cat) {
            $cat->delete();
            Storage::disk('public')->delete($cat->image_path);
            return redirect()->route('cats.not_adopted')->with('success', '🐈 eliminado correctamente.');
        } else {
            return redirect()->route('cats.not_adopted')->with('error', '🐈 no encontrado.');
        }
    }
    public function guestAdoption()
    {


        return redirect()->route('cats.not_adopted')->with('info', 'Para adoptar un gato debes registrarte o iniciar sesión');
    }

}
