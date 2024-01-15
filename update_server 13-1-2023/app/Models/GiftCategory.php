<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'order',
        'enable'
    ];
}
