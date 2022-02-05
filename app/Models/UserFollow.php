<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'author'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class,'posts');
    }
}
