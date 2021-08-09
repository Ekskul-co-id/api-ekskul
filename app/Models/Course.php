<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'image',
        'preview',
        'about',
        'price',
        'is_paid',
        'silabus',
    ];
    
    protected $casts = [
        'silabus' => 'array',
    ];
    
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    
    public function playlist()
    {
        return $this->hasMany('App\Models\Playlist', 'course_id');
    }
    
    public function rating()
    {
        return $this->hasMany('App\Models\Rating', 'course_id');
    }
    
    public function totalDurations()
    {
        return $this->hasManyThrough(Video::class, Playlist::class)
            ->selectRaw('sum(duration) as total, course_id')
            ->groupBy('course_id');
    }
}
