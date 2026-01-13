<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    ProfileController,
    PatientController,
    AppointmentController,
    ConsultationController,
    PrescriptionController,
    DoctorScheduleController,
    DoctorLeaveController,
    PaymentController
};
use App\Http\Controllers\Admin\DoctorController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| Authenticated (ALL USERS)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::prefix('patient')->name('patient.')->group(function () {
        Route::resource('patients', PatientController::class)->only(['create', 'store', 'show', 'edit', 'update', 'destroy']);
        Route::get('doctors', [PatientController::class, 'doctors'])->name('doctors');
        Route::get('doctors/{doctor}/book', [PatientController::class, 'book'])->name('book.doctor');
        Route::post('doctors/{doctor}/book', [PatientController::class, 'bookStore'])->name('book.store');
    });
});


Route::middleware(['auth'])->group(function () {

    /* ================= DASHBOARD ================= */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /* ================= PROFILE ================= */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /* =========================================================
     | APPOINTMENTS — SHARED (Admin / Doctor / Patient)
     ========================================================= */
    Route::get('/appointments', [AppointmentController::class, 'index'])
        ->name('appointments.index');

    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])
        ->name('appointments.show');

    Route::post('/appointments/{appointment}/check-in',
        [AppointmentController::class, 'checkIn'])
        ->name('appointments.checkin');

    /* ================= LIVE QUEUE ================= */
    Route::get('/appointments/queue',
        [AppointmentController::class, 'queue'])
        ->name('appointments.queue');

    /* ================= ADMIN ================= */
    Route::middleware(['role:admin'])->group(function () {

        // Doctors & Patients
        Route::resource('doctors', DoctorController::class);
        Route::resource('patients', PatientController::class);

        // ✅ Admin appointment CRUD (RESTORED & SAFE)
        Route::get('/appointments/create',
            [AppointmentController::class, 'create'])
            ->name('appointments.create');

        Route::post('/appointments',
            [AppointmentController::class, 'store'])
            ->name('appointments.store');

        Route::get('/appointments/{appointment}/edit',
            [AppointmentController::class, 'edit'])
            ->name('appointments.edit');

        Route::put('/appointments/{appointment}',
            [AppointmentController::class, 'update'])
            ->name('appointments.update');

        Route::delete('/appointments/{appointment}',
            [AppointmentController::class, 'destroy'])
            ->name('appointments.destroy');
    });

    /* ================= DOCTOR ================= */
    Route::middleware(['role:doctor'])->group(function () {

        Route::get('appointments/{appointment}/consult',
            [ConsultationController::class, 'create'])
            ->name('consultations.create');

        Route::post('appointments/{appointment}/consult',
            [ConsultationController::class, 'store'])
            ->name('consultations.store');

        Route::post('consultations/{consultation}/complete',
            [ConsultationController::class, 'complete'])
            ->name('consultations.complete');

        Route::get('consultations/{consultation}',
            [ConsultationController::class, 'show'])
            ->name('consultations.show');

        // Schedule
        Route::get('/my-schedule', [DoctorScheduleController::class, 'index'])
            ->name('doctor.schedule');

        Route::post('/my-schedule', [DoctorScheduleController::class, 'store'])
            ->name('doctor.schedule.store');

        Route::delete('/my-schedule/{schedule}',
            [DoctorScheduleController::class, 'destroy'])
            ->name('doctor.schedule.delete');

        // Leaves
        Route::get('/my-leaves', [DoctorLeaveController::class,'index'])
            ->name('doctor.leaves');

        Route::post('/my-leaves', [DoctorLeaveController::class,'store'])
            ->name('doctor.leaves.store');

        Route::delete('/my-leaves/{leave}',
            [DoctorLeaveController::class,'destroy'])
            ->name('doctor.leaves.delete');
    });


    Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    // Existing routes...
    Route::get('doctors', [PatientController::class, 'doctors'])->name('doctors');
    Route::get('doctors/{doctor}/book', [PatientController::class, 'book'])->name('book.doctor');
    Route::post('doctors/{doctor}/book', [PatientController::class, 'bookStore'])->name('book.store');
    
    // ADD THIS:
    Route::get('appointments', [PatientController::class, 'appointments'])->name('appointments');
    
    Route::get('/appointments/{appointment}/pay', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::post('/appointments/{appointment}/pay', [PaymentController::class, 'process'])->name('payment.process');
});


    /* ================= PATIENT BOOKING FLOW ================= */
    Route::middleware(['role:patient'])->group(function () {

        // STEP 1: Doctor list
        Route::get('/book-appointment',
            [AppointmentController::class, 'doctorList'])
            ->name('patient.book');

        // STEP 2: Doctor booking page
        Route::get('/book-appointment/{doctor}',
            [AppointmentController::class, 'doctorBooking'])
            ->name('patient.book.doctor');

        // STEP 3: Create appointment (pending_payment)
        Route::post('/book-appointment/{doctor}',
            [AppointmentController::class, 'initiatePayment'])
            ->name('patient.book.store');

        // STEP 4: Payment page
        Route::get('/appointments/{appointment}/pay',
            [PaymentController::class, 'pay'])
            ->name('payment.pay');

        // Payment callbacks (dummy / real later)
        Route::post('/payment/success',
            [PaymentController::class, 'success'])
            ->name('payment.success');

        Route::post('/payment/fail',
            [PaymentController::class, 'fail'])
            ->name('payment.fail');

        Route::post('/payment/cancel',
            [PaymentController::class, 'cancel'])
            ->name('payment.cancel');

        // Prescriptions
        Route::get('/my-prescriptions',
            [PrescriptionController::class, 'index'])
            ->name('patient.prescriptions');

        Route::get('/my-prescriptions/{prescription}',
            [PrescriptionController::class, 'show'])
            ->name('patient.prescriptions.show');
    });

    Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/appointments/{appointment}/pay', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::post('/appointments/{appointment}/pay', [PaymentController::class, 'process'])->name('payment.process');
});


    /* ================= PRESCRIPTIONS (DOCTOR + PATIENT) ================= */
    Route::get('/prescriptions/{prescription}',
        [PrescriptionController::class, 'show'])
        ->name('prescriptions.show');

    Route::get('/prescriptions/{prescription}/print',
        [PrescriptionController::class, 'print'])
        ->name('prescriptions.print');
});

require __DIR__ . '/auth.php';
