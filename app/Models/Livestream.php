<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livestream extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'youtube_id',
        'description',
        'user_id',
        'price',
        'is_paid',
        'silabus',
        'start_date',
        'end_date',
    ];
    
    protected $casts = [
        'silabus' => 'array',
        'start_date' => 'datetime:Y-m-d H:m',
        'end_date' => 'datetime:Y-m-d H:m',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
