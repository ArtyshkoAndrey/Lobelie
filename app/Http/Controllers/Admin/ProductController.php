<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Product;
use App\Models\ProductSkus;
use App\Services\PhotoService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Expr\Array_;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return Application|Factory|View|Response
   */
  public function index(Request $request): View
  {
    $name = $request->get('name');
    $type = $request->get('type', 'isset');
    $products = Product::query()->orderByDesc('id');
    if ($type === 'all') {
      $products = $products->withTrashed();
    } else if ($type === 'deleted') {
      $products = $products->onlyTrashed();
    }
    if ($name) {
      $products = $products->where('title', 'like', '%' . $name . '%');
    }
    $products = $products->paginate(10);
    $filter = [
      'name' => $name,
      'type' => $type
    ];
    return view('admin.product.index', compact('products', 'filter'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View|Response
   */
  public function create()
  {
    return view('admin.product.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function store(Request $request): RedirectResponse
  {
    $request->validate([
      'title' => 'required|string|max:255',
      'price' => 'required|integer|min:0',
      'weight' => 'required|min:0',
      'brand' => 'required|exists:brands,id',
      'category' => 'required|exists:categories,id',
      'meta_title' => 'required|string',
      'meta_description' => 'required|string',
      'description' => 'required|string',
      'on_sale' => 'boolean',
      'on_top' => 'boolean',
      'on_new' => 'boolean',
      'photos' => 'array',
    ]);
//    dd($request->all());
    $data = $request->all();
    $data['meta'] = (object) [
      'title' => $data['meta_title'],
      'description' => $data['meta_description']
    ];
    $product = new Product($data);
    $product
      ->brand()
      ->associate($request->get('brand'));

    $product
      ->category()
      ->associate($request->get('category'));

    $product->save();

    if (is_array($request->get('skus', []))) {
      foreach ($request->get('skus', []) as $id => $stock) {
        $ps = new ProductSkus(['skus_id' => $id, 'stock' => $stock, 'product_id' => $product->id]);
        $ps->save();
      }
    }

    foreach ($data['photos'] as $name) {
      Photo::whereName($name)->first()->product()->associate($product->id)->save();
    }

    return redirect()->route('admin.product.index')->with('success', ['Товар успешно создан']);
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return Response
   */
  public function show(int $id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return Application|Factory|View|Response
   */
  public function edit(int $id)
  {
    $product = Product::find($id);
    return view('admin.product.edit', compact('product'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param int $id
   * @return RedirectResponse
   * @throws Exception
   */
  public function update(Request $request, int $id): RedirectResponse
  {
    $request->validate([
      'title' => 'required|string|max:255',
      'price' => 'required|integer|min:0',
      'weight' => 'required|min:0',
      'brand' => 'required|exists:brands,id',
      'category' => 'required|exists:categories,id',
      'meta_title' => 'required|string',
      'meta_description' => 'required|string',
      'description' => 'required|string',
      'on_sale' => 'boolean',
      'on_top' => 'boolean',
      'on_new' => 'boolean',
    ]);
    $product = Product::find($id);
    $ids = [];

    if (is_array($request->get('skus', []))) {
      foreach ($request->get('skus', []) as $id => $stock) {
        array_push($ids, $id);
        $flag = false;
        foreach ($product->productSkuses as $productSkus) {
          if ($productSkus->skus_id === $id) {
            $flag = true;

            $productSkus->stock = $stock;
            $productSkus->save();
          }
        }
        if (!$flag) {
          $ps = new ProductSkus(['skus_id' => $id, 'stock' => $stock, 'product_id' => $product->id]);
          $ps->save();
        }
      }
    }

    $idsPS = $product->productSkuses()->pluck('skus_id')->toArray();

    $ids = array_diff($idsPS, $ids);

    foreach ($ids as $id) {
      ProductSkus::whereSkusId($id)->delete();
    }
    $data = $request->all();
    $data['meta'] = (object) [
      'title' => $data['meta_title'],
      'description' => $data['meta_description']
    ];
    $product->update($data);
    $product
      ->brand()
      ->associate($request->brand);

    $product
      ->category()
      ->associate($request->category);
    $product->save();
    return redirect()->back()->with('success', ['Товар успешно обновлён']);
  }

  /**
   * Удаление или востановление товара.
   *
   * @param int $id
   * @return RedirectResponse
   */
  public function destroy(int $id): RedirectResponse
  {
    $product = Product::withTrashed()->find($id);
    if ($product->trashed()) {
      $product->restore();
      return redirect()->back()->with('success', ['Товар успешно востановлен']);
    } else {
      try {
        $product->delete();
        return redirect()->back()->with('success', ['Товар успешно удалён']);
      } catch (Exception $exception) {
        return redirect()->back()->withErrors($exception->getMessage());
      }
    }
  }

  public function photo(Request $request, $id) {

    $name = PhotoService::create($request->file('file'), 'storage/images/thumbnails', true, 30, 500);
    PhotoService::create($request->file('file'), 'storage/images/photos', true, 80, 1200);
    $photo = new Photo(['name' => $name]);
    $photo->product()->associate($id);
    $photo->save();
    echo $name;
  }

  public function photoDelete(Request $request): JsonResponse
  {
    $request->validate([
      'name' => 'required|string'
    ]);
    try {
      $ph = Photo::where('name', explode('.' ,$request->name)[0])->first()->delete();
      return response()->json(['status' => 'success']);
    } catch (Exception $e) {
      return response()->json(['status' => 'error'], 500);
    }
  }

  public function photoStore(Request $request) {
    $name = PhotoService::create($request->file('file'), 'storage/images/thumbnails', true, 30, 500);
    PhotoService::create($request->file('file'), 'storage/images/photos', true, 80, 1200);
    try {
      $photo = new Photo(['name' => $name]);
      $photo->product()->associate(null);
      $photo->save();
    } catch (Exception $exception) {
      PhotoService::delete($name);
      return response()->json($exception->getMessage(), 500);
    }
    return $name;
  }
}
