<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuckyCase extends Model
{
    use HasFactory;
    protected $fillable = [
      'id',
      'type',
      'value',
      'user_id',
      'room_id',
      'out_value',
      'created_date'
    ];
}
