<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'visitor_id',
        'visits_count',
        'last_visit_date'
      ];
}
