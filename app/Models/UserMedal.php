<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMedal extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'badge_id'
    ];
}
