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
        'design_cat',
        'user_id',
        'isAvailable',
        'purchase_date',
        'available_until',
        'price',
        'count',
        'isDefault'
    ];
}
