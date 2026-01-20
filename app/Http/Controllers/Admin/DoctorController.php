<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('user')->latest()->get();
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
        // Simple validation - 6 digit password OK
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|digits:6',  // ✅ 6 DIGIT PASSWORD ONLY
            'specialty' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'fee' => 'required|numeric|min:0|max:100000',
            'is_active' => 'boolean',
        ]);

        // Create User with simple 6-digit password
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),  // ✅ Works with 123456
        ]);

        // Assign doctor role
        $user->assignRole('doctor');

        // Create doctor record
        Doctor::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'specialty' => $validated['specialty'],
            'fee' => (float) $validated['fee'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('doctors.index')
            ->with('success', 'Doctor created! Login: ' . $validated['email'] . ' / ' . $validated['password']);
    }



    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        // $validated = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'nullable|email',
        //     'phone' => 'required|string',
        //     'specialty' => 'required|string|max:255',
        //     'fee' => 'required|numeric|min:0|max:100000',  // ← CRITICAL
        //     'is_active' => 'boolean',
        // ]);
        $validated = $request->validate([
    'name'      => 'required|string|max:255',
    'email'     => 'nullable|email',
    'phone'     => 'required|string',
    'specialty' => 'required|string|max:255',
    'fee'       => 'required|numeric|min:0|max:100000',
]);

$doctor->update([
    'name'      => $validated['name'],
    'email'     => $validated['email'],
    'phone'     => $validated['phone'],
    'specialty' => $validated['specialty'],
    'fee'       => (float) $validated['fee'],
    'is_active' => $request->boolean('is_active'), // ✅ FORCE TRUE/FALSE
]);


        // Ensure fee is properly casted
        $validated['fee'] = (float) $validated['fee'];

        $doctor->update($validated);

        return redirect()->route('doctors.index')
            ->with('success', 'Doctor updated successfully!');
    }



    public function destroy(Doctor $doctor)
    {
        $doctor->user->delete(); // cascades doctor
        return back()->with('success', 'Doctor removed.');
    }
}
