<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyChargingOperation extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'agency_id',
        'user_id',
        'type' , //IN , OUT'
        'gold',
        'source',
        'state',
        'charging_date'
    ];
}
