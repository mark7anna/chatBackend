<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;
    protected $fillable = [
      'id',
      'tag',
      'name',
      'img',
      'state',
      'password',
      'userId',
      'subject',
      'talkers_count',
      'starred',
      'isBlocked',
      'blockedDate',
      'blockedUntil',
      'createdDate',
      'isTrend',
      'details',
      'micCount',
      'enableMessages',
      'reportCount',
      'themeId',
      'country_id'
    ];
}
