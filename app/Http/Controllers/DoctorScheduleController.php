<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    public function index()
    {
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();
        $schedules = $doctor->schedules()->orderBy('day')->get();

        return view('doctors.schedule', compact('doctor','schedules'));
    }

    public function store(Request $request)
    {
        $doctor = Doctor::where('user_id', auth()->id())->firstOrFail();

        $data = $request->validate([
            'day'        => 'required|string',
            'start_time' => 'required',
            'end_time'   => 'required|after:start_time',
        ]);

        DoctorSchedule::create([
            'doctor_id' => $doctor->id,
            'day'       => $data['day'],
            'start_time'=> $data['start_time'],
            'end_time'  => $data['end_time'],
        ]);

        return back()->with('success', 'Schedule added successfully.');
    }

    public function destroy(DoctorSchedule $schedule)
    {
        abort_unless(
            $schedule->doctor->user_id === auth()->id(),
            403
        );

        $schedule->delete();

        return back()->with('success', 'Schedule removed.');
    }
}
