<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
      
        'user_id',
        'comment_id',
        'post_id'
        
    ];
    
    public function comments()
    {
        return $this->belongsTo(Comments::class, 'comment_id' );
    }
    public function posts()
    {
        return $this->belongsTo(Post::class, 'post_id' );
    }

    
}
