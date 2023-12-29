<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'code',
        'order',
        'dial_code',
        'icon',
        'enable'
    ];
}
