<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyMember extends Model
{
    use HasFactory;
    protected $fillable = [
      'id',
      'agency_id',
      'user_id',
      'state', // 0 request to join , 1 is joiner , 2 out 
      'joining_date',
      'approval_date'
    ];
}
