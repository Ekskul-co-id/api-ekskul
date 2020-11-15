<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livestream extends Model
{
    use HasFactory;

    protected $table = 'livestreams';

    protected $fillable = [
        'videoid',
        'start_date',
        'end_date',
        'title',
        'gambar',
        'description',
    ];
}
