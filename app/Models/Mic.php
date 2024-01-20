<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mic extends Model
{
    use HasFactory;
    protected $fillable = [
      'id', 
      'room_id',
      'order',
      'user_id',
      'isClosed',
      'isMute',
      
    ];
}
