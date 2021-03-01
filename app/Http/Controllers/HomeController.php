<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
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

    $sliders = Slider::all();
    return view('user.index', compact('categories', 'newProducts', 'sliders'));
  }

  public function payment (): View
  {
    return view('user.info.pay');
  }

  public function policy (): View
  {
    return view('user.info.policy');
  }
}
