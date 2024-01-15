<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'type',
        'name',
        'order',
        'img',
        'action',
        'url',
        "user_id",
        "room_id"
    ];
}
