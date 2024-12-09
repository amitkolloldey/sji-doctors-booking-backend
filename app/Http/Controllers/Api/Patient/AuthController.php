<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\BaseController;
use App\Http\Requests\PatientRegisterRequest;
use App\Http\Requests\PatientLoginRequest;
use App\Http\Requests\PatientResendVerificationEmailRequest;
use App\Mail\PatientEmailVerification;
use App\Mail\PatientResetPassword;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\PatientForgotPasswordRequest;
use App\Http\Requests\PatientResetPasswordRequest;

/**
 * Class AuthController
 *
 * This controller handles patient authentication, including registration, login, email verification,
 * password reset, and related operations.
 *
 * @package App\Http\Controllers\Api\Patient
 */
class AuthController extends BaseController
{
    /**
     * Handle patient registration.
     *
     * @param PatientRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(PatientRegisterRequest $request)
    {
        $patient = Patient::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_no' => $request->phone_no,
        ]);

        $patient->verification_token = Str::random(60);
        $patient->save();

        Mail::to($patient->email)->queue(new PatientEmailVerification($patient));

        return response()->json([
            'message' => 'Registered successfully! Please check your email for verification.',
            'patient' => $patient,
        ], 201);
    }

    /**
     * Handle patient login.
     *
     * @param PatientLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(PatientLoginRequest $request)
    {
        $patient = Patient::where('email', $request->email)->first();

        if (!$patient || !Hash::check($request->password, $patient->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if (!$patient->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email not verified. Please check your email for the verification link.'], 401);
        }

        $token = $patient->createToken('patient-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'patient' => $patient,
        ]);
    }

    /**
     * Verify the patient's email using the provided token.
     *
     * @param string $token
     * @return \Illuminate\View\View
     */
    public function verifyEmail($token)
    {
        $patient = Patient::where('verification_token', $token)->first();

        if (!$patient || $patient->email_verified_at) {
            return view('emails.patient_verification_error', [
                'message' => 'Invalid or expired verification token.',
            ]);
        }

        DB::beginTransaction();

        try {
            $patient->email_verified_at = now();
            $patient->verification_token = null;
            $patient->save();
            DB::commit();

            return view('emails.patient_verification_success', [
                'message' => 'Your email has been verified successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return view('emails.patient_verification_error', [
                'message' => 'Something went wrong, please try again later.',
            ]);
        }
    }

    /**
     * Resend the verification email to the patient.
     *
     * @param PatientResendVerificationEmailRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendVerificationEmail(PatientResendVerificationEmailRequest $request)
    {
        $patient = Patient::where('email', $request->email)->first();

        if (!$patient) {
            return response()->json(['message' => 'No account found with that email address.'], 404);
        }

        if ($patient->hasVerifiedEmail()) {
            return response()->json(['message' => 'Your email is already verified.'], 400);
        }

        $patient->verification_token = Str::random(60);
        $patient->save();

        Mail::to($patient->email)->queue(new PatientEmailVerification($patient));

        return response()->json(['message' => 'Verification link has been sent to your email.']);
    }

    /**
     * Handle password reset request for patients.
     *
     * @param PatientForgotPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(PatientForgotPasswordRequest $request)
    {
        $email = $request->input('email');
        $patient = DB::table('patients')->where('email', $email)->first();

        if (!$patient) {
            return response()->json(['error' => 'We could not find a patient with that email address.'], 404);
        }

        $token = Str::random(60);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'type' => 'patient', 'created_at' => now()]
        );

        $frontUrl = config('app.front_url');
        $resetUrl = "$frontUrl/patient/reset-password?token=$token&email=" . urlencode($email);

        Mail::to($email)->queue(new PatientResetPassword($resetUrl, $patient->name));

        return response()->json(['message' => 'Password reset link sent to your email.'], 200);
    }

    /**
     * Reset the patient's password.
     *
     * @param PatientResetPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(PatientResetPasswordRequest $request)
    {
        $patient = Patient::where('email', $request->email)->first();

        if (!$patient) {
            return response()->json(['error' => 'Patient not found.'], 404);
        }

        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('type', 'patient')
            ->first();

        if (!$tokenData || $tokenData->token !== $request->token) {
            return response()->json(['error' => 'Invalid or expired token.'], 400);
        }

        $patient->password = bcrypt($request->password);
        $patient->save();

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('type', 'patient')
            ->delete();

        return response()->json(['message' => 'Password has been reset successfully.'], 200);
    }
}
