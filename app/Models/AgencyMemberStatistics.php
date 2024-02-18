<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyMemberStatistics extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'agency_id',
        'start_time',
        'end_time',
        'net_hours',
     ];

}
