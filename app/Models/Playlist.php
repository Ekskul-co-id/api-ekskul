<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_category',
        'playlist_name',
        'image',
        'about_playlist',
        'harga',
        'rating',
        'silabus1',
        'silabus2',
        'silabus3',
        'silabus4',
    ];
}
