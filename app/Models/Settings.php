<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $fillable = [
      'id',
      'diamond_to_gold_ratio', //نسبة فك الماس الي ذهب
      'gift_sender_diamond_back' , // نسبة الماس الذي يحصل عليه مرسل الهدية
      'gift_room_owner_diamond_back',
       'gift_receiver_diamond_back' // نسبة الماس الذي يحصل عليه صاحب الغرفة من الهدية
    ];
}
