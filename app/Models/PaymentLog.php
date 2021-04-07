<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_logs extends Model
{
    use HasFactory;

    protected $fillable = [
        'status','payment_type','checkout_id','raw_response'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    public function checkout()
    {
        return $this->belongsTo('App\Models\Checkout');
    }
}
