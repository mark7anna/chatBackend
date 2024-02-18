<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'is_store',
        'name',
        'tag',
        'order',
        'category_id',
        'gift_category_id',
        'price',
        'days',
        'behaviour',
        'icon',
        'motion_icon',
        'dark_icon',
        'subject',
        'vip_id',
        'video_url',
        'audio_url'
    ];
}
