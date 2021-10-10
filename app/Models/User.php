<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use Filterable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'remember_token',
        'address',
        'profession',
        'device_token',
        'has_update_avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function providers()
    {
        return $this->hasMany('App\Models\SocialProvider');
    }

    public function videos()
    {
        return $this->belongsToMany('App\Models\Video', 'user_video', 'user_id', 'video_id');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_user')
            ->withPivot('role');
    }

    // model filter
    public function modelFilter()
    {
        return $this->provideFilter(\App\ModelFilters\UserFilter::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s',strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s',strtotime($value));
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return date('d-m-Y H:i:s',strtotime($value));
    }

    public function getDeletedAtAttribute($value)
    {
        if(is_null($value)){
            return null;
        } else {
            return date('d-m-Y H:i:s',strtotime($value));
        }
    }
}
