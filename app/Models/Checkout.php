<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $table = 'checkouts';

    protected $fillable = [
        'user_id',
        'course_id',
        'livestream_id',
        'qty',
        'type',
        'order_id',
        'snap_url',
        'metadata',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'metadata' => 'array',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
    
    public function livestream()
    {
        return $this->belongsTo('App\Models\Livestream');
    }
    
    public function paymentLog()
    {
        return $this->hasMany('App\Models\PaymentLog', 'checkout_id');
    }
}
