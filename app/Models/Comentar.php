<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentar extends Model
{
    use HasFactory;
    
    protected $table = 'comentars';

    protected $fillable = [
        'id_user',
        'id_livestream',
        'comentar'
    ];
}
