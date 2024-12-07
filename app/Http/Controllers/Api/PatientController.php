<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRegisterRequest;
use App\Http\Requests\PatientLoginRequest;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function register(PatientRegisterRequest $request)
    {
        $patient = Patient::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $patient->createToken('patient-token')->accessToken;

        return response()->json([
            'message' => 'Patient registered successfully!',
            'token' => $token,
            'patient' => $patient,
        ], 201);
    }

    public function login(PatientLoginRequest $request)
    {
        $patient = Patient::where('email', $request->email)->first();

        if (!$patient || !Hash::check($request->password, $patient->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $patient->createToken('patient-token')->accessToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'patient' => $patient,
        ]);
    }
}
