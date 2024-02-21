<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipPurchase extends Model
{
    use HasFactory;
    protected $fillable = [
       'id',
       'user_id',
       'vip_id',
       'purchase_date',
       'available_untill',
       'price',
       'isDefault'
    ];
}
