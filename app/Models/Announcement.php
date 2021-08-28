<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'image',
        'message', 
        'type',
        'user_id',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
