<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Post extends Model
{
    use HasFactory, SearchableTrait;
    protected $fillable = [
        'name',
        'excerpt',
        'body',
        'tag_id',
        'image_path',
        'status',
    ];

    protected $searchable = [
        'columns' => [
            'posts.body' => 9,
            'posts.name' => 10,
            'posts.id' => 3,
        ]
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
