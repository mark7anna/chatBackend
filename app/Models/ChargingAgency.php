<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargingAgency extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'active',
        'notes'
    ];
}
