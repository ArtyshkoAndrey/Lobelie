<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


class HomeController extends Controller
{
  /**
   * @return View
   */
  public function index () :View
  {

    $categories = Category::whereToMenu(true)->get();
    $newProducts = Product::whereOnNew(true)
      ->orderByDesc('id')
      ->take(4)
      ->get();
    $hitProducts = Product::whereOnTop(true)
      ->orderByDesc('id')
      ->take(4)
      ->get();
    return view('user.index', compact('categories', 'newProducts', 'hitProducts'));
  }
}
