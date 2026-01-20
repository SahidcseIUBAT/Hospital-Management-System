<?php

namespace App\Http\Controllers;

use App\Events\AppointmentStatusChanged;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\DoctorSchedule;
use App\Models\DoctorLeave;


class AppointmentController extends Controller
{
    
    /*
    |--------------------------------------------------------------------------
    | PATIENT — STEP 1: Doctor List
    |--------------------------------------------------------------------------
    */
    public function doctorList()
    {
        $doctors = Doctor::with('schedules')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('appointments.patient.doctors', compact('doctors'));
    }
    

    /*
    |--------------------------------------------------------------------------
    | PATIENT — STEP 2: Doctor Booking Page
    |--------------------------------------------------------------------------
    */
    public function doctorBooking(Request $request, Doctor $doctor)
    {
        abort_unless($doctor->is_active, 404);

        $date = $request->input('date', now()->toDateString());
        $day  = strtolower(Carbon::parse($date)->format('l'));

        // Check availability
        $available = $doctor->schedules()
            ->where('day', $day)
            ->exists();

        $onLeave = $doctor->leaves()
            ->where('date', $date)
            ->exists();

        if (!$available || $onLeave) {
            return back()->withErrors([
                'error' => 'Doctor is not available on this date.'
            ]);
        }
        if (!$available || $onLeave) {
        return back()->withErrors([
            'error' => 'Doctor is not available on this date.'
        ]);
    }
    $leaveDates = DoctorLeave::where('doctor_id', $doctor->id)
        ->pluck('date')
        ->toArray();

        return view('appointments.patient.book', compact(
        'doctor',
        'date',
        'leaveDates'
    ));    
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX — Role-based
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $appointments = Appointment::with(['patient.user', 'doctor'])
                ->latest()
                ->paginate(20);
        } elseif ($user->hasRole('doctor')) {
            $doctor = Doctor::where('user_id', $user->id)->firstOrFail();

            $appointments = Appointment::with('patient.user')
                ->where('doctor_id', $doctor->id)
                ->orderBy('date')
                ->paginate(20);
        } elseif ($user->hasRole('patient')) {
            $patient = Patient::where('user_id', $user->id)->firstOrFail();

            $appointments = Appointment::with('doctor')
                ->where('patient_id', $patient->id)
                ->orderBy('date')
                ->paginate(20);
        } else {
            abort(403);
        }

        return view('appointments.index', compact('appointments'));
    }


        public function book(Doctor $doctor)
        {
            $schedules = DoctorSchedule::where('doctor_id', $doctor->id)
                ->where('is_active', true)
                ->get();

            $leaveDates = DoctorLeave::where('doctor_id', $doctor->id)
                ->pluck('date')
                ->toArray();

            return view('appointments.book', compact(
                'doctor',
                'schedules',
                'leaveDates'
            ));
            
        }

    /*
    |--------------------------------------------------------------------------
    | CREATE — ADMIN ONLY
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);

        $patients = Patient::with('user')->latest()->get();
        $doctors  = Doctor::where('is_active', true)->orderBy('name')->get();

        return view('appointments.create', compact('patients', 'doctors'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE — REAL BOOKING LOGIC
    |--------------------------------------------------------------------------
    */
 public function store(Request $request)
{
    $user = Auth::user();

    // ✅ EXISTING VALIDATION (UNCHANGED)
    $data = $request->validate([
        'doctor_id' => 'required|exists:doctors,id',
        'date'      => 'required|date|after_or_equal:today',
        'reason'    => 'nullable|string|max:1000',
    ]);

    // ✅ EXISTING PATIENT ATTACH LOGIC (UNCHANGED)
    if ($user->hasRole('patient')) {
        $patientId = Patient::where('user_id', $user->id)->value('id');
        abort_if(!$patientId, 403, 'Patient profile not found');
        $data['patient_id'] = $patientId;
    } else {
        $data['patient_id'] = $request->validate([
            'patient_id' => 'required|exists:patients,id'
        ])['patient_id'];
    }

    try {

        /* =====================================================
         | 🔒 ADDITION 1: CHECK DOCTOR ACTIVE SCHEDULE
         ===================================================== */
        $dayName = Carbon::parse($data['date'])->format('l'); // Monday, Tuesday

        $schedule = DoctorSchedule::where('doctor_id', $data['doctor_id'])
            
        ->where('day', strtolower($dayName))
            ->where('is_active', true)
            ->first();

        if (!$schedule) {
            return back()
                ->withInput()
                ->withErrors(['date' => 'Doctor is not available on this day.']);
        }

        /* =====================================================
         | 🔒 ADDITION 2: CHECK DOCTOR LEAVE
         ===================================================== */
        $onLeave = DoctorLeave::where('doctor_id', $data['doctor_id'])
            ->whereDate('leave_date', $data['date'])
            ->exists();

        if ($onLeave) {
            return back()
                ->withInput()
                ->withErrors(['date' => 'Doctor is on leave on this date.']);
        }

        /* =====================================================
         | 🔒 ADDITION 3: PREVENT OVERBOOKING (OPTIONAL SLOT LOGIC)
         ===================================================== */
        $existingCount = Appointment::where('doctor_id', $data['doctor_id'])
            ->whereDate('date', $data['date'])
            ->count();

        // Optional safety limit (example: 30 patients/day)
        if ($existingCount >= 30) {
            return back()
                ->withInput()
                ->withErrors(['date' => 'No available slots for this day.']);
        }

        /* =====================================================
         | ✅ EXISTING SERIAL & TOKEN LOGIC (UNCHANGED)
         ===================================================== */
        $serial = $existingCount + 1;

        $data['token'] = 'D'
            . $data['doctor_id'] . '-'
            . Carbon::parse($data['date'])->format('Ymd') . '-'
            . str_pad($serial, 3, '0', STR_PAD_LEFT);

        $data['status'] = 'booked';

        Appointment::create($data);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment booked successfully.');

    } catch (\Throwable $e) {
        Log::error('Appointment booking failed', ['error' => $e]);

        return back()
            ->withInput()
            ->withErrors(['error' => 'Booking failed. Try again.']);
    }
}



public function initiatePayment(Request $request, Doctor $doctor)
{
    $user = auth()->user();
    abort_unless($user->hasRole('patient'), 403);

    $data = $request->validate([
        'date'   => 'required|date|after_or_equal:today',
        'reason' => 'nullable|string|max:1000',
    ]);

    $patient = Patient::where('user_id', $user->id)->firstOrFail();

    // ✅ Re-check doctor availability (CRITICAL)
    $day = strtolower(Carbon::parse($data['date'])->format('l'));

    $available = $doctor->schedules()
        ->where('day', $day)
        ->exists();

    $onLeave = $doctor->leaves()
        ->where('date', $data['date'])
        ->exists();

    abort_if(!$available || $onLeave, 422, 'Doctor is not available on this date.');

    try {
        DB::beginTransaction();

        // 1️⃣ Create appointment (PENDING PAYMENT)
        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id'  => $doctor->id,
            'date'       => $data['date'],
            'status'     => 'pending_payment',
            'reason'     => $data['reason'] ?? null,
        ]);

        // 2️⃣ Create payment (ONE TIME ONLY)
        \App\Models\Payment::create([
            'appointment_id' => $appointment->id,
            'patient_id'     => $patient->id,
            'amount'         => (int) $doctor->fee, // force integer
            'method'         => 'sslcommerz',
            'status'         => 'pending',
        ]);

        DB::commit();

        // 3️⃣ Redirect to payment page (dummy / real later)
        return redirect()->route('payment.pay', $appointment);

    } catch (\Throwable $e) {
        DB::rollBack();

        Log::error('Payment initiation failed', [
            'user_id' => $user->id,
            'doctor_id' => $doctor->id,
            'error' => $e->getMessage(),
        ]);

        return back()->withErrors([
            'error' => 'Unable to initiate payment. Please try again.'
        ]);
    }
}
    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(Appointment $appointment)
    {
        $appointment->load('patient.user', 'doctor', 'consultation.prescription');
        return view('appointments.show', compact('appointment'));
    }

    /*    |--------------------------------------------------------------------------
    | APPOINTMENT QUEUE (ADMIN + DOCTOR)
    |--------------------------------------------------------------------------
    */
    
    public function queue()
{
    $user = auth()->user();

    // Doctor → only own queue
    if ($user->hasRole('doctor')) {

        $doctor = Doctor::where('user_id', $user->id)->first();

        if (!$doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $appointments = Appointment::with(['patient.user'])
            ->where('doctor_id', $doctor->id)
            ->whereIn('status', ['booked','checked_in','in_progress'])
            ->orderBy('created_at')
            ->get();
    }

    // Admin → all live queue
    elseif ($user->hasRole('admin')) {

        $appointments = Appointment::with(['patient.user'])
            ->whereIn('status', ['booked','checked_in','in_progress'])
            ->orderBy('created_at')
            ->get();
    }

    else {
        abort(403);
    }

    return view('appointments.queue', compact('appointments'));
}
    /*
    |--------------------------------------------------------------------------
    | CHECK-IN
    |--------------------------------------------------------------------------
    */
    public function checkIn(Appointment $appointment)
    {
        if ($appointment->status !== 'checked_in') {
            $appointment->update(['status' => 'checked_in']);
            event(new AppointmentStatusChanged($appointment));
        }

        return back()->with('success', 'Patient checked in.');
    }

    
    public function edit(Appointment $appointment)
    {
        abort_unless(Auth::user()->hasRole('admin'), 403);
        
        $patients = Patient::with('user')->get();
        $doctors = Doctor::where('is_active', true)->get();
        
        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    /**
     * Update the specified appointment in storage (ADD THIS METHOD)
     */
    public function update(Request $request, Appointment $appointment)
    {
        abort_unless(Auth::user()->hasRole('admin'), 403);

        // Validate input
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'scheduled_at' => 'required|date|after:now',
            'status' => 'required|in:pending_payment,booked,checked_in,in_progress,completed,cancelled',
            'reason' => 'nullable|string|max:500',
        ]);

        // Check doctor availability (prevent double booking)
        $conflict = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('scheduled_at', $validated['scheduled_at'])
            ->where('id', '!=', $appointment->id)
            ->whereIn('status', ['pending_payment', 'booked', 'checked_in'])
            ->exists();

        if ($conflict) {
            return back()->withErrors(['scheduled_at' => 'Doctor is already booked at this time.']);
        }

        // Update appointment
        $appointment->update($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully!');
    }
        public function destroy(Appointment $appointment)
    {
        // Admin authorization (already checked by middleware)
        abort_unless(Auth::user()->hasRole('admin'), 403);
        
        // Prevent deletion of completed/in-progress appointments
        if (in_array($appointment->status, ['in_progress', 'completed'])) {
            return back()->with('error', 'Cannot delete completed or active appointments.');
        }
        
        // Delete related payment first (if exists)
        $appointment->payment()->delete();
        
        // Delete appointment
        $appointment->delete();
        
        return back()->with('success', 'Appointment deleted successfully.');
    }

}
