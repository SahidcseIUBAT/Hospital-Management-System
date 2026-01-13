<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new patient profile.
     */
    public function create()
    {
        return view('patient.create-patient');
    }

    /**
     * Store a newly created patient profile.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'medical_history' => 'nullable|string',
        ]);

        $user = Auth::user();
        abort_if($user->patient, 409, 'Patient profile already exists.');

        $patientId = 'P-' . str_pad(Patient::max('id') + 1, 4, '0', STR_PAD_LEFT);

        Patient::create([
            'user_id' => $user->id,
            'patient_id' => $patientId,
            'dob' => $validated['dob'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'medical_history' => $validated['medical_history'] ?? null,
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Patient profile created successfully!');
    }

    /**
     * Display the specified patient resource.
     */
    public function show(Patient $patient)
    {
        abort_unless($patient->user_id === Auth::id(), 403);
        return view('patient.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified patient resource.
     */
    public function edit(Patient $patient)
    {
        abort_unless($patient->user_id === Auth::id(), 403);
        return view('patient.edit', compact('patient'));
    }

    /**
     * Update the specified patient resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        abort_unless($patient->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'medical_history' => 'nullable|string',
        ]);

        $patient->update($validated);

        return back()->with('success', 'Patient profile updated successfully!');
    }

    /**
     * Remove the specified patient resource from storage.
     */
    public function destroy(Patient $patient)
    {
        abort_unless($patient->user_id === Auth::id(), 403);
        $patient->delete();
        return redirect()->route('dashboard')->with('success', 'Patient profile deleted.');
    }

    /**
     * Display list of doctors for booking.
     */
    public function doctors()
    {
        // Role check moved to routes
        $doctors = Doctor::with('schedules')
            ->where('is_active', true)
            ->get();
        return view('patient.doctors', compact('doctors'));
    }

    /**
     * Show booking form for specific doctor.
     */
    public function book(Doctor $doctor)
    {
        // Role check moved to routes
        $user = Auth::user();
        $patient = $user->patient;

        if (!$patient) {
            return redirect()->route('patient.create')
                ->with('error', 'Please complete your patient profile first.');
        }

        $doctor->load(['schedules' => function ($query) {
            $query->where('is_active', true);
        }]);

        return view('patient.book', compact('doctor', 'patient'));
    }

    /**
     * Store appointment booking (initiate payment).
     */
    /**
 * Store appointment booking (initiate payment).
 */
/**
 * Store appointment booking (initiate payment).
 */
public function bookStore(Request $request, Doctor $doctor)
{
    $user = Auth::user();
    $patient = $user->patient;
    abort_if(!$patient, 403, 'Patient profile required.');

    $validated = $request->validate([
        'scheduled_at' => 'required|date|after:now',
        'reason' => 'nullable|string|max:500',
    ]);

    // Check doctor availability
    $existing = Appointment::where('doctor_id', $doctor->id)
        ->where('scheduled_at', $validated['scheduled_at'])
        ->count();
    abort_if($existing >= 3, 409, 'Doctor unavailable at this time.');

    $token = Str::random(10);
    $appointment = Appointment::create([
        'token' => $token,
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'scheduled_at' => $validated['scheduled_at'],
        'status' => 'pending_payment',  // ✅ MATCHES YOUR MIGRATION
        'reason' => $validated['reason'],
    ]);

    // Create pending payment
    Payment::create([
        'appointment_id' => $appointment->id,
        'patient_id' => $patient->id,
        'amount' => $doctor->fee ?: 500,  // Default if fee is 0
        'method' => 'sslcommerz',
        'status' => 'pending',
        'transaction_id' => 'TXN-' . $appointment->id . '-' . time(),
    ]);

    return redirect()->route('payment.pay', $appointment)
        ->with('info', 'Proceed to payment to confirm booking.');
}
/**
 * Display patient's appointments
 */
public function appointments()
{
    $appointments = Auth::user()->patient->appointments()
        ->with('doctor')
        ->latest()
        ->paginate(10);
        
    return view('patient.appointments', compact('appointments'));
}



}
