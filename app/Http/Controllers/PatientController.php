<?php

namespace App\Http\Controllers;

use App\Http\Requests\Patient\ActivePatientRequest;
use App\Models\Chat;
use App\Models\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class PatientController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Patient/Index', [
            'patients' => User::role('user')->filter(Request::only('search'))->paginate(15),
        ]);
    }

    public function update(ActivePatientRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        if ($request->input('status') == 'monitor') {
            Chat::create([
                'patient_id' => $user->id,
                'doctor_id' => Auth::id(),
            ]);
        }

        return Redirect::route('patient.index')->banner('Update Status Berhasil.');
    }
}
