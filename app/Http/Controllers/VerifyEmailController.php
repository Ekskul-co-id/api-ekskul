<?php

namespace App\Http\Controllers;

use App\Mail\VerificationMail;
use App\Models\User;
use App\Models\Verification;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class VerifyEmailController extends Controller
{
    use APIResponse;
    
    /**
     * @OA\Post(
     *     path="/api/verify",
     *     summary="Verification",
     *     description="Verification email",
     *     operationId="authVerify",
     *     security={{ "bearer_token": {} }},
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass verify credentials",
     *         @OA\JsonContent(
     *             required={"code"},
     *             @OA\Property(property="code", type="integer", format="int", example="52413"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Success",
     *     ),
     * )
     */
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|integer|digits:5'
        ]);
        
        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $user = Auth::user();
        
        $verification = Verification::where('user_id', $user->id)->latest()->first(); // Get the last user verification code
        
        $code = $request->code;
        
        if ($verification->code != $code) {
            return $this->response("Verification code does not match, please try again.", null, 422);
        }
        
        $date_expired = $verification->created_at->addMinutes(5);
        
        $date_now = now();
        
        if ($date_expired <= $date_now) {
            return $this->response("The verification code has expired.", null, 422);
        }
        
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            
            return $this->response("Successfully verified your account.", null, 201);
        } else {
            return $this->response("Your account has been verified.", null, 201);
        }
    }
    
    /**
     * @OA\Post(
     *     path="/api/verify/resend",
     *     summary="Verification",
     *     description="Resend verification code",
     *     operationId="authVerifyResend",
     *     security={{ "bearer_token": {} }},
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=201,
     *         description="Success",
     *     ),
     * )
     */
    public function resend()
    {
        $user = Auth::user();
        
        $code = rand(11111, 99999);
        
        Verification::create([
            'code' => $code,
            'user_id' => $user->id
        ]);
        
        Mail::to($user->email)->send(new VerificationMail($user, $code));
        
        return $this->response("Verification code sent.", null, 201);
    }
}
