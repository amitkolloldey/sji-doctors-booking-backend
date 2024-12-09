<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\BaseController;
use App\Http\Requests\DoctorRegisterRequest;
use App\Http\Requests\DoctorLoginRequest;
use App\Http\Requests\DoctorResendVerificationEmailRequest;
use App\Mail\DoctorEmailVerification;
use App\Mail\DoctorResetPassword;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\DoctorForgotPasswordRequest;
use App\Http\Requests\DoctorResetPasswordRequest;

class AuthController extends BaseController
{
    /**
     * Register a new doctor account.
     * 
     * @param DoctorRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(DoctorRegisterRequest $request)
    {
        $doctor = Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'specialization' => $request->specialization,
        ]);

        $doctor->verification_token = Str::random(60);
        $doctor->save();

        Mail::to($doctor->email)->send(new DoctorEmailVerification($doctor));

        return response()->json([
            'message' => 'Registered successfully! Please check your email for verification.',
            'doctor' => $doctor,
        ], 201);
    }

    /**
     * Authenticate a doctor and issue a token.
     * 
     * @param DoctorLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(DoctorLoginRequest $request)
    {
        $doctor = Doctor::where('email', $request->email)->first();

        if (!$doctor || !Hash::check($request->password, $doctor->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if (!$doctor->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email not verified. Please check your email for the verification link.'], 401);
        }

        $token = $doctor->createToken('doctor-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'doctor' => $doctor,
        ]);
    }

    /**
     * Verify the doctor's email using a token.
     * 
     * @param string $token
     * @return \Illuminate\Contracts\View\View
     */
    public function verifyEmail($token)
    {
        $doctor = Doctor::where('verification_token', $token)->first();

        if (!$doctor || $doctor->email_verified_at) {
            return view('emails.doctor_verification_error', [
                'message' => 'Invalid or expired verification token.',
            ]);
        }

        DB::beginTransaction();

        try {
            $doctor->email_verified_at = now();
            $doctor->verification_token = null;
            $doctor->save();
            DB::commit();

            return view('emails.doctor_verification_success', [
                'message' => 'Your email has been verified successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return view('emails.doctor_verification_error', [
                'message' => 'Something went wrong, please try again later.',
            ]);
        }
    }

    /**
     * Resend the verification email to the doctor.
     * 
     * @param DoctorResendVerificationEmailRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendVerificationEmail(DoctorResendVerificationEmailRequest $request)
    {
        $doctor = Doctor::where('email', $request->email)->first();

        if (!$doctor) {
            return response()->json(['message' => 'No account found with that email address.'], 404);
        }

        if ($doctor->hasVerifiedEmail()) {
            return response()->json(['message' => 'Your email is already verified.'], 400);
        }

        $doctor->verification_token = Str::random(60);
        $doctor->save();

        Mail::to($doctor->email)->send(new DoctorEmailVerification($doctor));

        return response()->json(['message' => 'Verification link has been sent to your email.']);
    }

    /**
     * Send a password reset link to the doctor's email.
     * 
     * @param DoctorForgotPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(DoctorForgotPasswordRequest $request)
    {
        $email = $request->input('email');
        $doctor = DB::table('doctors')->where('email', $email)->first();

        if (!$doctor) {
            return response()->json(['error' => 'We could not find a doctor with that email address.'], 404);
        }

        $token = Str::random(60);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'type' => 'doctor', 'created_at' => now()]
        );

        $frontUrl = config('app.front_url');

        $resetUrl = "$frontUrl/doctor/reset-password?token=$token&email=" . urlencode($email);

        Mail::to($email)->send(new DoctorResetPassword($resetUrl, $doctor->name));

        return response()->json(['message' => 'Password reset link sent to your email.'], 200);
    }

    /**
     * Reset the doctor's password.
     * 
     * @param DoctorResetPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(DoctorResetPasswordRequest $request)
    {
        $doctor = Doctor::where('email', $request->email)->first();

        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found.'], 404);
        }

        $tokenData = DB::table('password_reset_tokens')->where('email', $request->email)->where('type', 'doctor')->first();

        if (!$tokenData || $tokenData->token !== $request->token) {
            return response()->json(['error' => 'Invalid or expired token.'], 400);
        }

        $doctor->password = bcrypt($request->password);
        $doctor->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->where('type', 'doctor')->delete();

        return response()->json(['message' => 'Password has been reset successfully.'], 200);
    }
}
