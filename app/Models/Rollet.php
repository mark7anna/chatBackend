<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rollet extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'room_id',
        'type',
        'value',
        'member_count',
        'actual_member_count',
        'adminShare',
        'state',
        'winner_id'
    ];
}
