<?php

namespace App\Http\Controllers;

class CartController extends Controller {

  public function index ()
  {
    return view('user.cart.index');
  }
}
