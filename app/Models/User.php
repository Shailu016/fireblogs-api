<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function bookmarks()
    {
        return $this->belongsToMany(Post::class, 'bookmarks', 'post_id', 'user_id');
    }


    public function sendPasswordResetNotification($token)
    {

        $url = '' . $token;

        $this->notify(new ResetPasswordNotification($url));
    }
    public function providers()
    {
        return $this->hasMany(Provider::class, 'user_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function profiles()
    {
        return $this->hasOne(Profile::class);
    }


public function following() {
    return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id');
}

// users that follow this user
public function followers() {
    return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id');
}

}
