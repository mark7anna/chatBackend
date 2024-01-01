<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FestivalBanner extends Model
{
    use HasFactory;
    protected $fillable = [
      'id',
      'title',
      'type',
      'description',
      'img',
      'room_id',
      'start_date',
      'duration_in_hour',
      'enable',
      'accepted'
    ];
}
