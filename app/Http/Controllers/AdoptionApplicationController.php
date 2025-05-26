<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\NoticeApplicationAdoption;
use App\Models\AdoptionStatus;



class AdoptionApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = auth()->user();
        if ($user->isAdmin()) {
            $pendingStatus = AdoptionStatus::where('name', 'pending')->first();
            $applications = $pendingStatus->adoptionApplications()
                ->with(['cat', 'user'])
                ->get();

        } else {
            $applications = $user->adoptionApplications;

        }

        $applicationStatuses = [
            'pending' => 'Pendiente',
            'accepted' => 'Aceptada',
            'rejected' => 'Rechazada',
        ];
        return view('adoption-application', compact('applications', 'applicationStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'cat_id' => 'required|exists:cats,id',
            'contact_phone' => 'required|string|max:20',
        ]);

        //Comprobación de que el usuario no tenga una solicitud pendiente del gato que quiere adoptar para evitar duplicidades en las solicitudes
        $pendingApplications = AdoptionApplication::where('user_id', $validated['user_id'])
            ->whereHas('adoptionStatus', function ($query) {
                $query->where('name', 'pending');
            })
            ->with('adoptionStatus')
            ->get();

        foreach ($pendingApplications as $application) {
            if ($application->cat_id == $validated['cat_id']) {
                return redirect()->route('cats.not_adopted')
                    ->with('warning', 'No es posible solicitar dos veces la adopción del mismo 🐈‍');
            }
        }


        // Crear solicitud de adopción
        $application = AdoptionApplication::create([
            'user_id' => $validated['user_id'],
            'cat_id' => $validated['cat_id'],
            'contact_phone' => $validated['contact_phone'],
            'date_application' => now(),
            'status_id' => AdoptionStatus::where('name', 'pending')->firstOrFail()->id,
        ]);

        return redirect('/adoption-application/index')->with('success', 'Solicitud de adopción enviada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AdoptionApplication $adoptionApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdoptionApplication $adoptionApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'adoptionStatus' => 'required|in:accepted,rejected',
        ]);

        $adoptionApplication = AdoptionApplication::with(['user', 'cat'])->findOrFail($id);
        $status = AdoptionStatus::where('name', $request->adoptionStatus)->firstOrFail();
        $adoptionApplication->status_id = $status->id;
        $adoptionApplication->save();
        $applicationStatuses = [
            'accepted' => 'Aceptada 🙂',
            'rejected' => 'Rechazada ☹️',
        ];
        $translatedStatus = $applicationStatuses[$request->adoptionStatus];

        $user = $adoptionApplication->user;
        $cat = $adoptionApplication->cat;
        $recipient_name = $user->name;
        $subjectText = "Tu solicitud #$adoptionApplication->id ha sido revisada";
        $title = 'Notificación de Adopción';
        $body_message = "Tu solicitud de adopción #$adoptionApplication->id para $cat->name ha sido $translatedStatus.";

        // Informa al usuario del la aceptación o rechazo de su solicitud
        Mail::to($user->email)->send(new NoticeApplicationAdoption
        (
            $recipient_name,
            $subjectText,
            $title,
            $body_message
        ));

        if ($request->adoptionStatus === 'accepted') {
            $cat->is_adopted = true;
            $cat->adoption_date = Carbon::today();
            $cat->owner_id = $adoptionApplication->user_id;
            $cat->save();


            $otherApplications = AdoptionApplication::where('cat_id', $adoptionApplication->cat_id)
                ->whereHas('adoptionStatus', function ($query) {
                    $query->where('name', 'pending');
                })
                ->with(['user', 'cat'])
                ->get();

            $rejectedId = AdoptionStatus::where('name', 'rejected')->value('id');
            foreach ($otherApplications as $application) {
                $application->status_id = $rejectedId;
                $application->save();
                $user = $application->user;
                $recipient_name = $user->name;
                $subjectText = "Tu solicitud #$application->id ha sido revisada";
                $body_message = "Tu solicitud de adopción #$application->id para $cat->name ha sido Rechazada ☹️.";
                // Informar al usuario del rechazo de su solicitud
                Mail::to($user->email)->send(new NoticeApplicationAdoption
                (
                    $recipient_name,
                    $subjectText,
                    $title,
                    $body_message
                ));
            }
        }

        return redirect('/adoption-application/index')->with
        (
            'info',
            "La solicitud #{$id} fue {$translatedStatus}."
        );

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdoptionApplication $adoptionApplication)
    {
        //
    }
}
