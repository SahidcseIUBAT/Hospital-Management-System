<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PrescriptionController extends Controller
{
    public function show(Prescription $prescription)
{
    $user = auth()->user();

    // Doctor can view if it's his consultation
    if ($user->hasRole('doctor')) {
        abort_unless(
            $prescription->consultation->doctor->user_id === $user->id,
            403
        );
    }

    // Patient can view only own prescription
    if ($user->hasRole('patient')) {

    $patient = $user->patient;

    // Patient profile missing → block access
    if (!$patient) {
        abort(403, 'Patient profile not found.');
    }

    abort_unless(
        $prescription->patient_id === $patient->id,
        403
    );
}


    // Admin denied
    if ($user->hasRole('admin')) {
        abort(403);
    }

    $prescription->load('items','consultation.patient.user','consultation.doctor');

    return view('prescriptions.show', compact('prescription'));
}

    public function print(Prescription $prescription)
{
    $user = auth()->user();

    if ($user->hasRole('doctor')) {
        abort_unless(
            $prescription->consultation->doctor->user_id === $user->id,
            403
        );
    }

    if ($user->hasRole('patient')) {

    $patient = $user->patient;

    if (!$patient) {
        abort(403);
    }

    abort_unless(
        $prescription->patient_id === $patient->id,
        403
    );
}


    if ($user->hasRole('admin')) {
        abort(403);
    }

    $prescription->load('items','consultation.patient.user','consultation.doctor');

    $pdf = Pdf::loadView(
        'prescriptions.print',
        compact('prescription')
    );

    return $pdf->stream('prescription.pdf');
}

}
