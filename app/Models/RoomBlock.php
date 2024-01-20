<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomBlock extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_id',
        'user_id',
        'blocked_date',
        'block_type',
        'block_until'
      ];
  
}
