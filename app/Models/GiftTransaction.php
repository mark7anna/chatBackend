<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
       'id',
       'gift_id',
       'sender_id',
       'receiver_id',
       'room_id',
       'count',
       'price',
       'total',
       'sendDate'
    ];
}
