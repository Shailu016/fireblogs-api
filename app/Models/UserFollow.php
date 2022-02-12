<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    use HasFactory;
    protected $guarded = [];

   
    public function posts()
    {
        return $this->hasMany(Post::class, 'post_id');
    }
    
public function users()
 { return $this->belongsTo(User::class, 'user_id'); }





}
