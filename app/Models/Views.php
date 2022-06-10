<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Views extends Model
{
    use HasFactory;
    public $table = "views";

    protected $fillable = [
        'views',
        'post_id',
        
    ];
}
