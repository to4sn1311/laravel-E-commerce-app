<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
  /** @use HasFactory<\Database\Factories\ProductOrderFactory> */
  use HasFactory;

  protected $fillable = [
    'product_id',
    'product_size',
    'product_color',
    'product_quantity',
    'product_price',
  ];
}
