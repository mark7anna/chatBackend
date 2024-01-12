<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargingOpration extends Model
{
    use HasFactory;
    protected $fillable = [
      'id',
      'user_id',
      'gold',
      'source',
      'state',
      'charging_date'
    ];
}
