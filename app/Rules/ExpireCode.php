<?php

namespace App\Rules;

use App\Models\ForgotPassword;
use App\Models\Verification;
use Illuminate\Contracts\Validation\Rule;

class ExpireCode implements Rule
{
    public $code;
    public $type;
    
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($code, $type)
    {
        $this->code = $code;
        $this->type = $type;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $date_now = now();
        
        if ($this->type == 'verify') {
            $verification = Verification::where('code', $this->code)->first();
            
            $date_expired = $verification->created_at->addMinutes(5);
            
            if ($date_expired <= $date_now) {
                return false;
            }
            
            return true;
        } else {
            $forgotPassword = ForgotPassword::where('code', $this->code)->first();
            
            $date_expired = $forgotPassword->created_at->addMinutes(5);
        
            if ($date_expired <= $date_now) {
                return false;
            }
            
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':Attribute telah kedaluwarsa.';
    }
}
