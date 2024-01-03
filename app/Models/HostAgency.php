<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostAgency extends Model
{
    use HasFactory;
    protected $fillable = [
      'id',
      'name',
      'tag',
      'user_id',
      'monthly_gold_target',
      'details',
      'active',
      'allow_new_joiners',
      'automatic_accept_joiners',
      'automatic_accept_exit'
    ];
}
