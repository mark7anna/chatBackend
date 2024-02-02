<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'chat_id',
        'sender_id',
        'reciver_id',
        'message_date',
        'message',
        'img',
        'type',
        'isSeen'
    ];
}
