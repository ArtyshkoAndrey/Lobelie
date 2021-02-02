<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Skus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Validator;

class ProductController extends Controller
{

  public function search (Request $request) {
    $q = $request->get('q', null);
    if ($q) {
      $products = Product::where('title', 'like', '%' . $q . '%')->get();
      return view ('user.product.search', compact('products'));
    } else  {
      return redirect()->back()->withErrors(['Поле поиск не может быть пустым']);
    }
  }


  /**
   * Показ товаров по фильтру
   *
   * @param Request $request
   * @return Application|Factory|View
   */
  public function all (Request $request)
  {
    $items = Product::query();
    $order = $request->input('order', 'sort-new');

    $sale = $request->get('sale', false);
    $new = $request->get('new', false);

    $size = $request->get('size', []);

    if($sale) {
      $items = $items->whereOnSale(true);
    }

    if($new) {
      $items = $items->whereOnNew(true);
    }

    if ($order) {
      if ($order === 'sort-new') {
        $items = $items->orderBy('created_at', 'desc');
      } else if ($order === 'sort-old') {
        $items = $items->orderBy('created_at');
      } else if ($order === 'sort-expensive') {
        $items = $items->orderBy('price', 'desc');
      } else if ($order === 'sort-cheap') {
        $items = $items->orderBy('price');
      }
    }

    if ($sex = $request->input('sex', [])) {
      !is_array($sex) ? $sex = [$sex] : null;
      $items = $items->whereIn('sex', $sex);
    }

    if ($categoryArr = $request->input('category', [])) {
      !is_array($categoryArr) ? $categoryArr = [$categoryArr] : null;
      $rules = [
        'categories' => 'required|array',
        'categories.*' => 'exists:categories,id', // check each item in the array
      ];
      $validator = Validator::make(['categories' => $categoryArr], $rules);
      if ($validator->fails()) {
        throw new NotFoundHttpException();
      }
      foreach ($categoryArr as $index => $category) {
        if ($index == 0) {
          $items = $items->whereHas('category', function ($query) use ($category) {
            return $query->where('categories.id', '=', $category);
          });
        } else {
          $items = $items->orWhereHas('category', function ($query) use ($category) {
            return $query->where('categories.id', '=', $category);
          });
        }
      }
    }

    if ($brandArr = $request->input('brand', [])) {
      !is_array($brandArr) ? $brandArr = [$brandArr] : null;

      $rules = [
        'brands' => 'required|array',
        'brands.*' => 'exists:brands,id', // check each item in the array
      ];
      $validator = Validator::make(['brands' => $brandArr], $rules);
      if ($validator->fails()) {
        throw new NotFoundHttpException();
      }

      foreach ($brandArr as $index => $brand) {
        if ($index == 0) {
          $items = $items->whereHas('brand', function ($query) use ($brand) {
            return $query->where('brands.id', '=', $brand);
          });
        } else {
          $items = $items->orWhereHas('brand', function ($query) use ($brand) {
            return $query->where('brands.id', '=', $brand);
          });
        }
      }
    }

    if ($brandArr !== [] && $categoryArr !== []) {
      $attributes = Skus::whereHas('products.brand', function ($q) use ($brandArr) {
        $q->whereIn('products.brand_id', $brandArr);
      })
        ->whereHas('products.category', function ($q) use ($categoryArr) {
          $q->whereIn('products.category_id', $categoryArr);
        })->get();
    } else if ($categoryArr !== [] && $brandArr === []) {
      $attributes = Skus::whereHas('products.category', function ($q) use ($categoryArr) {
        $q->whereIn('products.category_id', $categoryArr);
      })->get();
    } else if ($categoryArr === [] && $brandArr !== []) {
      $attributes = Skus::whereHas('products.brand', function ($q) use ($brandArr) {
        $q->whereIn('products.brand_id', $brandArr);
      })->get();
    } else {
      $attributes = Skus::all();
    }

    if ($size) {
      !is_array($size) ? $size = [$size] : null;

      $rules = [
        'skuses' => 'required|array',
        'skuses.*' => 'exists:skuses,id', // check each item in the array
      ];
      $validator = Validator::make(['skuses' => $size], $rules);
      if ($validator->fails()) {
        throw new NotFoundHttpException();
      }

      $items = $items->whereHas('skuses', function ($query) use ($size) {
        return $query->whereIn('skus_id', $size);
      });
//      foreach ($size as $index => $s) {
//        if ($index == 0) {
//          $items = $items->whereHas('skuses', function ($query) use ($s) {
//            return $query->where('id', '=', $s);
//          });
//        } else {
//          $items = $items->orWhereHas('skuses', function ($query) use ($s) {
//            return $query->where('id', '=', $s);
//          });
//        }
//      }
    }

    $itemsCount = $items->count();
    $items = $items->paginate(15);
    $filter = [
      'category' => $categoryArr,
      'order' => $order,
      'brand' => $brandArr,
      'sale'  => $sale,
      'new'   => $new,
      'sex'   => $sex,
      'size'  => $size
    ];
    $counter = 0;
    foreach ($filter as $name => $f) {
      if ($name !== 'sale' && $name !== 'new' && $name !== 'order')
        $counter += count($f);
      else
        if ($f && $name !== 'order')
          $counter++;
    }
    return view('user.product.catalog', compact('items', 'filter', 'itemsCount', 'attributes', 'counter'));
  }

  /**
   * @param int $id
   * @return View|void
   */
  public function show (int $id): View
  {
    $product = Product::find($id);
    if ($product) {
      try {
        $childCategory = $product->category()->first();
        $categories = [];
        while($category = $childCategory->parents()->first()) {
          array_unshift($categories, $category);
          $childCategory = $category;
        }
        array_push($categories, $product->category()->first());
      } catch (\Error $exception) {
        $categories = [];
      }

      return view('user.product.show', compact('product', 'categories'));
    }
    throw new NotFoundHttpException();
  }
}
