<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
  /** @use HasFactory<\Database\Factories\CartDetailFactory> */
  use HasFactory;

  protected $fillable = [
    'product_id',
    'user_id',
    'product_size',
    'product_color',
    'product_quantity',
    'product_price',
  ];
}
