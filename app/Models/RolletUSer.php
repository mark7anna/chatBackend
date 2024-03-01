<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolletUSer extends Model
{
    use HasFactory;
    protected $fillable = [
      'id',
      'rollet_id',
      'user_id',
       
    ];
}
