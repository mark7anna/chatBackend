<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyMemberPoints extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'agency_id',
        'gift_id',
        'points',
        'send_date',
     ];
}
