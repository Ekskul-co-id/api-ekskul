<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\APIResponse;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    use APIResponse;
    
    public function verify($id)
    {
        $user = User::findOrFail($id);
        
        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            event(new Verified($user));
        
            return $this->response("Successfully verified your account.", null, 201);
        } else {
            return $this->response("Your account has been verified.", null, 201);
        }
    }
    
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        
        return $this->response("Verification link sent!", null, 201);
    }
}
