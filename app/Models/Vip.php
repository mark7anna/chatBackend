<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vip extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'tag',
        'price',
        'icon',
        'motion_icon'
    ];
}
