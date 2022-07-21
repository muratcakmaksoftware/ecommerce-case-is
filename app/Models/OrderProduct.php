<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderProduct extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $table = 'order_product';
}
