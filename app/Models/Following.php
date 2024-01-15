<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'following_id',
        'following_date'
      ];
}
