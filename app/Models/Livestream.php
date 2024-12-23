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
        'category_id',
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
    
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    
    public function mentor()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
