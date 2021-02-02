<?php
/*
 * Copyright (c) 2020. Данный файл является интелектуальной собственостью Fulliton.
 * Я буду рад если вы будите вносить улучшения, всегда жду ваших пул реквестов
 */

namespace App\Services;

use App\Models\Product;
use App\Models\Skus;
use Illuminate\Support\Facades\Auth;

class CartService
{
  private bool $auth;

  public function __construct ()
  {
    $this->auth = Auth::check();
  }

  public function add (Product $product, Skus $skus)
  {
    if ($this->auth) {
      auth()->user()->addToCart($skus);
    } else {
      dd($this);
    }
  }
}
