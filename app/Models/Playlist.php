<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'course_id',
    ];
    
    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
    
    public function video()
    {
        return $this->hasMany('App\Models\Video', 'playlist_id');
    }
}
