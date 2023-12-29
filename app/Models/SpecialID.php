<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialID extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'uid',
        'img',
        'price',
        'isAvailable'

    ];
}
