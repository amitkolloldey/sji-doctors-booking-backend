<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Doctor\AuthController as DoctorAuthController;
use App\Http\Controllers\Api\Patient\AuthController as PatientAuthController;

// This route serves the default welcome page
Route::get('/', function () {
    return view('welcome');
});

// Route to verify the email of a doctor using a verification token
// When a doctor clicks the verification link, this route will handle the request
Route::get('doctor-verify-email/{token}', [DoctorAuthController::class, 'verifyEmail'])
    ->name('doctors.verify.email'); // Naming the route for easy reference

// Route to verify the email of a patient using a verification token
// When a patient clicks the verification link, this route will handle the request
Route::get('patient-verify-email/{token}', [PatientAuthController::class, 'verifyEmail'])
    ->name('patients.verify.email'); // Naming the route for easy reference
