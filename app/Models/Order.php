<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  /** @use HasFactory<\Database\Factories\OrderFactory> */
  use HasFactory;

  protected $fillable = [
    'status',
    'total',
    'shipping_fee',
    'customer_name',
    'customer_email',
    'customer_phone',
    'customer_address',
    'note',
  ];
}
