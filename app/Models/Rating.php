<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'playlist_id',
        'user_id',
        'value',
    ];
    
    public function playlist()
    {
        return $this->belongsTo('App\Models\Playlist');
    }
}
