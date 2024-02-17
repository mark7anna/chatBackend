<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyWallet extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'agency_id',
        'balance',
    ];
}
