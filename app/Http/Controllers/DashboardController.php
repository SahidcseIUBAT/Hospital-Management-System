<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Prescription;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ADMIN DASHBOARD
        if ($user->hasRole('admin')) {
            $totalPatients = Patient::count();
            $totalDoctors = Doctor::count();
            $todaysAppointments = Appointment::whereDate('scheduled_at', Carbon::today())->count();

            $monthly = Appointment::selectRaw('MONTH(scheduled_at) month, COUNT(*) total')
                ->whereYear('scheduled_at', now()->year)
                ->groupByRaw('MONTH(scheduled_at)')
                ->pluck('total', 'month')
                ->toArray();

            return view('dashboards.admin', compact(
                'totalPatients',
                'totalDoctors',
                'todaysAppointments',
                'monthly'
            ));
        }

        // DOCTOR DASHBOARD
        if ($user->hasRole('doctor')) {
            $doctor = Doctor::where('user_id', $user->id)->first();

            $todayAppointments = $doctor
                ? $doctor->appointments()
                    ->whereDate('scheduled_at', Carbon::today())
                    ->orderBy('scheduled_at')
                    ->get()
                : collect();

            $currentQueue = $doctor
                ? Appointment::where('doctor_id', $doctor->id)
                    ->whereIn('status', ['booked', 'checked_in'])
                    ->orderBy('scheduled_at')
                    ->get()
                : collect();

            return view('dashboards.doctor', compact(
                'doctor',
                'todayAppointments',
                'currentQueue'
            ));
        }

        // PATIENT DASHBOARD
        if ($user->hasRole('patient')) {
            $patient = Patient::where('user_id', $user->id)->firstOrFail();

            $upcoming = $patient
                ? $patient->appointments()
                    ->whereDate('scheduled_at', '>=', now())
                    ->orderBy('scheduled_at')
                    ->get()
                : collect();

            $history = $patient
                ? $patient->appointments()
                    ->whereDate('scheduled_at', '<', now())
                    ->orderByDesc('scheduled_at')
                    ->limit(10)
                    ->get()
                : collect();

                $prescriptions = Prescription::where('patient_id', $patient->id)
        ->latest()
        ->limit(5)
        ->get();

            return view(
        'dashboards.patient',
        compact('patient','upcoming','history','prescriptions')
    );
            
        }

        abort(403);
    }
}
