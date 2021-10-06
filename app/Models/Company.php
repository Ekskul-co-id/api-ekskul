<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'slug', 'avatar', 'user_id',
    ];
    
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'company_user')
                        ->withPivot('role')
                        ->withTimestamps()
                        ->as('member');
    }
    
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
