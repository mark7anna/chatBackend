<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomGifts extends Model
{
    use HasFactory;
    protected $fillable =[
        'id',
        'room_id',
        'sender_id',
        'reciver_id',
        'gift_id',
        'price',
        'count',
        
    ]
}
