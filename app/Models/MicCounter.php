<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MicCounter extends Model
{
    use HasFactory;
    protected $fillable = [
       'id',
       'mic_id',
       'user_id',
       'room_id',
       
    ];
}
