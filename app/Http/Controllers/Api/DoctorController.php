<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorRegisterRequest;
use App\Http\Requests\DoctorLoginRequest;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function register(DoctorRegisterRequest $request)
    {
        $doctor = Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'specialization' => $request->specialization,
        ]);

        $token = $doctor->createToken('doctor-token')->accessToken;

        return response()->json([
            'message' => 'Doctor registered successfully!',
            'token' => $token,
            'doctor' => $doctor,
        ], 201);
    }

    public function login(DoctorLoginRequest $request)
    {
        $doctor = Doctor::where('email', $request->email)->first();

        if (!$doctor || !Hash::check($request->password, $doctor->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $doctor->createToken('doctor-token')->accessToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'doctor' => $doctor,
        ]);
    }
}