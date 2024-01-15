<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
      'id',
      'content',
      'user_id',
      'img',
      'auth',
      'accepted',
      'likes_count',
      'comments_count'
    ];
}
