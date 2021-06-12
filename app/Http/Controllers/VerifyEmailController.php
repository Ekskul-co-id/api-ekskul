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
            $error = [
                'code' => [ 
                    'Verification code does not match.',
                ]
            ];
            return $this->response(null, $error, 422);
        }
        
        $date_expired = $verification->created_at->addMinutes(5);
        
        $date_now = now();
        
        if ($date_expired <= $date_now) {
            $error = [
                'code' => [ 
                    'The verification code has expired.',
                ]
            ];
            
            return $this->response(null, $error, 422);
        }
        
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            
            return $this->response("Successfully verified your account.", null, 201);
        } else {
            return $this->response("Your account has been verified.", null, 201);
        }
    }
    
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
