<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class UserNotification extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'type',
        'notified_user',
        'action_user',
        'title',
        'content',
        'title_ar',
        'content_ar'
      ];
}
