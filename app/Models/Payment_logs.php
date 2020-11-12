<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_logs extends Model
{
    use HasFactory;

    protected $table = 'payment_logs';

    protected $fillable = [
        'status','payment_type','id_checkout','raw_response'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];


}
