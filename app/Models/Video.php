<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'playlist_id',
        'video_id',
        'title',
        'duration'
    ];
    
    public function playlist()
    {
        return $this->belongsTo('App\Models\Playlist');
    }
}
