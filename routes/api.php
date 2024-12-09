<?php

use App\Http\Controllers\Api\Doctor\AuthController as DoctorAuthController;
use App\Http\Controllers\Api\Doctor\AvailabilityController;
use App\Http\Controllers\Api\Doctor\AppointmentController;
use App\Http\Controllers\Api\Doctor\CalendarController;
use App\Http\Controllers\Api\Doctor\ProfileController as DoctorProfileController;
use App\Http\Controllers\Api\Patient\ProfileController as PatientProfileController;
use App\Http\Controllers\Api\Patient\AuthController as PatientAuthController;
use App\Http\Controllers\Api\Doctor\ManagementController;

/**
 * Routes for Doctor APIs
 * These routes handle authentication, availability, appointments, profile updates, and calendar data for doctors.
 */
Route::prefix('doctors')->group(function () {
    // Authentication routes for doctors
    Route::post('register', [DoctorAuthController::class, 'register']); // Doctor registration
    Route::post('login', [DoctorAuthController::class, 'login']); // Doctor login
    Route::post('resend-verification', [DoctorAuthController::class, 'resendVerificationEmail']); // Resend verification email
    Route::post('forgot-password', [DoctorAuthController::class, 'forgotPassword'])->name('doctors.password.email'); // Forgot password
    Route::post('reset-password', [DoctorAuthController::class, 'resetPassword'])->name('doctors.password.reset'); // Reset password

    // Protected routes for authenticated doctors
    Route::middleware(['auth:sanctum'])->group(function () {
        // Availability management
        Route::post('availability', [AvailabilityController::class, 'storeAvailability']); // Create or update availability
        Route::get('availability/{doctorId}', [AvailabilityController::class, 'getAvailability']); // Fetch availability by doctor ID
        Route::delete('availability/{id}', [AvailabilityController::class, 'deleteAvailability']); // Delete availability

        // Appointment management
        Route::get('appointments', [AppointmentController::class, 'getAppointments']); // List appointments for the doctor
        Route::post('appointments', [AppointmentController::class, 'storeAppointments']); // Create an appointment
        Route::patch('appointments/{id}/cancel', [AppointmentController::class, 'cancelAppointment']); // Cancel an appointment

        // Calendar data
        Route::get('calendar-data', [CalendarController::class, 'getCalendarData']); // Get calendar data for appointments

        // Profile management
        Route::put('profile/update', [DoctorProfileController::class, 'update']); // Update doctor profile

        // Management data
        Route::get('/', [ManagementController::class, 'index']); // Doctor management dashboard
    });

    // Public route for fetching doctor specializations
    Route::get('specializations', [DoctorProfileController::class, 'getSpecializations']); // Get all available doctor specializations
});

/**
 * Routes for Patient APIs
 * These routes handle authentication, appointments, and profile updates for patients.
 */
Route::prefix('patients')->group(function () {
    // Authentication routes for patients
    Route::post('register', [PatientAuthController::class, 'register']); // Patient registration
    Route::post('login', [PatientAuthController::class, 'login']); // Patient login
    Route::post('resend-verification', [PatientAuthController::class, 'resendVerificationEmail']); // Resend verification email
    Route::post('forgot-password', [PatientAuthController::class, 'forgotPassword'])->name('patients.password.email'); // Forgot password
    Route::post('reset-password', [PatientAuthController::class, 'resetPassword'])->name('patients.password.reset'); // Reset password

    // Protected routes for authenticated patients
    Route::middleware(['auth:sanctum'])->group(function () {
        // Appointment management
        Route::get('appointments', [AppointmentController::class, 'getAppointmentsForPatient']); // List appointments for the authenticated patient

        // Profile management
        Route::put('profile/update', [PatientProfileController::class, 'update']); // Update patient profile
    });
});
