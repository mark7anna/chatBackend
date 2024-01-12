<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiamondGoldExchnage extends Model
{
    use HasFactory;
    protected $fillable = [
      'id',
      'user_id',
      'diamond',
      'diamond_gold_ration',
      'gold',
      'exchange_date'
    ];
}
