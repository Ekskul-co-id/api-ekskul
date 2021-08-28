<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', 'checkout_id', 'payment_type', 'raw_response', 'fcm_response'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'raw_response' => 'array',
        'fcm_response' => 'array',
    ];

    public function checkout()
    {
        return $this->belongsTo('App\Models\Checkout');
    }
}
