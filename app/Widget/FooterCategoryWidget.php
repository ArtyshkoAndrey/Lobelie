<?php

namespace App\Widget;

use App\Models\Category;
use App\Widget\Interfaces\Widget;

class FooterCategoryWidget implements Widget
{

  public function execute()
  {
    $categories = Category::whereDoesntHave('parents')->with('child')->take(4)->get();

    return view('Widget::footer-category', [
      'categories' => $categories
    ]);
  }
}
