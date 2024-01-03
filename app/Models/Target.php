<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;
    protected $fillable = [
      'id',
      'order',
      'gold',
      'dollar_amount',
      'agent_amount',
      'icon'
    ];
}
