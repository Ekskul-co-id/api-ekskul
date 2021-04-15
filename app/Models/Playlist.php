<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
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
    
    public function video()
    {
        return $this->hasMany('App\Models\Video', 'playlist_id');
    }
    
    public function rating()
    {
        return $this->hasMany('App\Models\Rating', 'playlist_id');
    }
}
