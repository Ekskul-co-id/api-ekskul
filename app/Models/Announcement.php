<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory;
    use Filterable;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'image',
        'message',
        'type',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // model filter
    public function modelFilter()
    {
        return $this->provideFilter(\App\ModelFilters\AnnouncementFilter::class);
    }

    // format timezone id
    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }
}
