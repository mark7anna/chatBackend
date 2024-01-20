<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;
    protected $fillable = [
      'id',
       'user_id',
       'blocke_user',
       'blocked_date'
    ];
}
