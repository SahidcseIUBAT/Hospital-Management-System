<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
 public function store(Request $request): RedirectResponse
    {
    $user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
]);

// Assign patient role
$user->assignRole('patient');

// Auto-create patient profile
Patient::create([
    'user_id' => $user->id,
    'patient_id' => 'SH-' . str_pad(
        (Patient::max('id') ?? 0) + 1,
        4,
        '0',
        STR_PAD_LEFT
    ),
]);

event(new Registered($user));
Auth::login($user);

return redirect()->route('dashboard');
}


}
