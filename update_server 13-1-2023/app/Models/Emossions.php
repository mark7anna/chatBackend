<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emossions extends Model
{
    use HasFactory;
    protected $fillable = [
       'id',
       'img',
       'icon'
    ];
}
