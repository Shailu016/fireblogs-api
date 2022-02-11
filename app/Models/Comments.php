<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $fillable = [
        'body',
        'user_id',
        'post_id',
        'user_name',
        'image_path'
    ];
    
    public $table = "comments";

    public function post()
    {
        return $this->belongsTo(Post::class, 'posts');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', );
    }
    

   
}
