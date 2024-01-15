<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'tag',
        'name',
        'img',
        'share_level_id',
        'karizma_level_id',
        'charging_level_id',
        'phone',
        'email',
        'password',
        'isChargingAgent',
        'isHostingAgent',
        'registered_at',
        'last_login',
        'birth_date',
        'enable',
        'ipAddress',
        'macAddress',
        'deviceId',
        'isOnline',
        'isInRoom',
        'country',
        'register_with',
        'gender'
    ];

    // public function shareLevel()
    // {
    //     return $this->hasOne(Level::class , 'id' , 'share_level_id') ;
    // }
}
