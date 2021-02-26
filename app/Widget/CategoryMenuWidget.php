<?php

namespace App\Widget;

use App\Models\Category;
use App\Widget\Interfaces\Widget;

class CategoryMenuWidget implements Widget
{

  public function execute()
  {
    $categories = Category::whereDoesntHave('parents')->with('child')->get();

    return view('Widget::category-menu', [
      'categories' => $categories
    ]);
  }
}
