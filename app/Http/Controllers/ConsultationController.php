<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsultationController extends Controller
{
    
    public function create(Appointment $appointment)
{
    $appointment->load('patient.user', 'doctor');

    // ensure logged-in doctor owns this appointment
    $doctor = \App\Models\Doctor::where('user_id', auth()->id())->firstOrFail();

    abort_if($appointment->doctor_id !== $doctor->id, 403);

    // prevent duplicate consultation
    if ($appointment->consultation) {
        return redirect()
            ->route('consultations.show', $appointment->consultation)
            ->with('info', 'Consultation already started.');
    }

    return view('consultations.create', compact('appointment'));
}


    // store consultation + prescription
    public function store(Request $request, Appointment $appointment)
{
    $doctor = \App\Models\Doctor::where('user_id', auth()->id())->firstOrFail();

    abort_if($appointment->doctor_id !== $doctor->id, 403);

    $data = $request->validate([
        'chief_complaint' => 'nullable|string|max:1000',
        'notes' => 'nullable|string',
        'diagnosis' => 'nullable|string|max:2000',
        'vitals' => 'nullable|array',
        'vitals.bp' => 'nullable|string|max:50',
        'vitals.pulse' => 'nullable|numeric',
        'vitals.temp' => 'nullable|numeric',

        // prescription
        'advice' => 'nullable|string|max:2000',
        'follow_up_at' => 'nullable|date',
        'medicine_name' => 'nullable|array',
        'medicine_name.*' => 'nullable|string|max:255',
        'dosage.*' => 'nullable|string|max:255',
        'days.*' => 'nullable|integer',
        'item_notes.*' => 'nullable|string',
    ]);

    DB::beginTransaction();

    try {
        // 1️⃣ create consultation (START)
        $consult = Consultation::create([
            'appointment_id' => $appointment->id,
            'doctor_id' => $doctor->id,
            'patient_id' => $appointment->patient_id,
            'chief_complaint' => $data['chief_complaint'] ?? null,
            'notes' => $data['notes'] ?? null,
            'diagnosis' => $data['diagnosis'] ?? null,
            'vitals' => $data['vitals'] ?? null,
            'started_at' => now(),
        ]);

        // 2️⃣ prescription (same as before)
        if (!empty($data['medicine_name'])) {
            $pres = Prescription::create([
                'consultation_id' => $consult->id,
                'doctor_id' => $consult->doctor_id,
                'patient_id' => $consult->patient_id,
                'advice' => $data['advice'] ?? null,
                'follow_up_at' => $data['follow_up_at'] ?? null,
            ]);

            foreach ($data['medicine_name'] as $i => $med) {
                if (!$med) continue;

                PrescriptionItem::create([
                    'prescription_id' => $pres->id,
                    'medicine_name' => $med,
                    'dosage' => $data['dosage'][$i] ?? null,
                    'days' => $data['days'][$i] ?? null,
                    'notes' => $data['item_notes'][$i] ?? null,
                ]);
            }
        }

        // 3️⃣ mark appointment IN PROGRESS
        $appointment->update(['status' => 'in_progress']);

        DB::commit();

        return redirect()
            ->route('consultations.show', $consult)
            ->with('success', 'Consultation started.');

    } catch (\Throwable $e) {
        DB::rollBack();
        logger()->error('Consultation start error', ['e' => $e]);
        return back()->withErrors(['error' => 'Failed to start consultation']);
    }
}

    // complete consultation
    public function complete(Consultation $consultation)
{
    $doctor = \App\Models\Doctor::where('user_id', auth()->id())->firstOrFail();

    abort_if($consultation->doctor_id !== $doctor->id, 403);

    if ($consultation->completed_at) {
        return back()->with('info', 'Consultation already completed.');
    }

    DB::transaction(function () use ($consultation) {
        $consultation->update([
            'completed_at' => now(),
        ]);

        $consultation->appointment->update([
            'status' => 'completed',
        ]);
    });

    return redirect()
        ->route('dashboard')
        ->with('success', 'Consultation completed.');
}


    // show consultation (with prescription)
    public function show(Consultation $consultation)
    {
        $consultation->load('appointment','patient.user','doctor','prescription.items');
        return view('consultations.show', compact('consultation'));
    }
}
