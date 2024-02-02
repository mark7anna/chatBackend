<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'sender_id',
        'reciver_id',
        'last_action_date',
        'last_message',
        'last_sender',
    ];
    
}
