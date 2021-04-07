<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $table = 'checkouts';

    protected $fillable = [
        'user_id',
        'playlist_id',
        'qty',
        'snap_url',
        'metadata',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'metadata' => 'array',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function playlist()
    {
        return $this->belongsTo('App\Models\Playlist');
    }
}
