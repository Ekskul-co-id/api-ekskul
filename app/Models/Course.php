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
        'silabus1',
        'silabus2',
        'silabus3',
        'silabus4',
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
        return $this->hasMany('App\Models\Rating', 'playlist_id');
    }
}
