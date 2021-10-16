<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'discount', 'limit_type', 'voucher_type', 'limit_time', 'limit_used', 'user_id',
    ];
    
    public function users()
    {
        $this->belongsToMany(User::class, 'user_voucher');
    }
}
