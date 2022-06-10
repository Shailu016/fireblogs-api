<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use App\Models\User;
use App\Models\Bookmark;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'excerpt',
        'body',
        'tags',
        'image_path',
        'status',
    ];
    

    protected $searchable = [
        'columns' => [
            'posts.body' => 9,
            'posts.name' => 10,
            'posts.id' => 3,
        ],
        'joins' => [
            'posts' => ['users.id', 'posts.user_id'],
        ],
    ];

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

    public function likes()
    {
        return $this->hasMany(Likes::class, 'post_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id' );
    }
    public function bookmarks()
    {
        return $this->belongsToMany(User::class, 'bookmarks', 'user_id', 'post_id');
    }

    public function is_bookmarked(User $user)
    {
        return $this->bookmark->contains($user);
    }
    
    public function following() 
    {
     return $this->belongsToMany(User::class, 'followers', 'follower_id','following_id');
    }
    
    // users that follow this user
    public function followers()
    {
        
     return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id');
    
    }
    
}
