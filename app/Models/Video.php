<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'playlist_id',
        'youtube_id',
        'title',
        'duration'
    ];
    
    public function playlist()
    {
        return $this->belongsTo('App\Models\Playlist');
    }
    
    public function users()
    {
        return $this->belongsToMany('App\Models\Video', 'user_video', 'video_id', 'user_id');
    }
    
    public function watched()
    {
        return $this->users()->where('user_id', auth()->user()->id);
    }
}
