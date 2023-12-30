<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignPurchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'design_id',
        'user_id',
        'isAvailable',
        'purchase_date',
        'available_until',
        'price'
    ];
}
