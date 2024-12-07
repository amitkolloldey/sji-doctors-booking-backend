<?php

use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\AppointmentController;

Route::prefix('doctors')->group(function () {
    Route::post('register', [DoctorController::class, 'register']);
    Route::post('login', [DoctorController::class, 'login']);
});

Route::prefix('patients')->group(function () {
    Route::post('register', [PatientController::class, 'register']);
    Route::post('login', [PatientController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('appointments', [AppointmentController::class, 'bookAppointment']);
});
