<?php

namespace App\Http\Controllers;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use App\Models\ForgotPassword;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    use APIResponse;
    
    public function forgot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);
        
        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $user = User::where('email', $request->email)->firstOrFail();
        
        $code = rand(11111, 99999);
        
        ForgotPassword::create([
            'code' => $code,
            'user_id' => $user->id
        ]);
        
        Mail::to($user->email)->send(new ForgotPasswordMail($user, $code));
        
        return $this->response("Forgot password code sent.", null, 201);
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|integer',
            'new_password' => 'required|string|min:6|confirmed',
        ]);
        
        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $forgotPassword = ForgotPassword::where('code', $request->code)->first();

        if (empty($forgotPassword)) {
            return $this->response("Forgot password code does not match, please try again.", null, 422);
        }
        
        $date_expired = $forgotPassword->created_at->addMinutes(5);
        
        $date_now = now();
        
        if ($date_expired <= $date_now) {
            return $this->response("The forgot password code has expired.", null, 422);
        }
        
        $user = User::where('email', $forgotPassword->user->email)->first();
        
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);
        
        $forgotPassword->delete();
        
        return $this->response("Successfully reset password your account.", null, 201);
    }
}
