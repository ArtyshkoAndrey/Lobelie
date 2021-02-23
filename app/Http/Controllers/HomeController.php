<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;


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
      ->take(3)
      ->get();

    return view('user.index', compact('categories', 'newProducts'));
  }
}
