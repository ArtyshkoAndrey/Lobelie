<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return Application|Factory|View|Response
   */
  public function index(Request $request)
  {
    $brands = Brand::query();
    $name = $request->get('name');
    if ($name) {
      $brands = $brands->where('name', 'like', '%' . $name . '%');
    }

    $filter = [
      'name' => $name
    ];
    $brands = $brands->paginate(7);
    $brands->appends($filter);
    return view('admin.brand.index', compact('brands', 'filter'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
      //
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
      'name' => 'required|string|unique:brands,name'
    ]);
    Brand::create($request->all());
    return redirect()->back()->with('success', ['Бренд успешно создан']);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param int $id
   * @return RedirectResponse
   */
  public function update(Request $request, int $id): RedirectResponse
  {
    $request->validate([
      'name' => 'required|string|unique:brands,name'
    ]);
    $brand = Brand::find($id);
    $brand->update($request->all());
    return redirect()->back()->with('success', ['Бренд успешно обнавлён']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return RedirectResponse
   * @throws Exception
   */
  public function destroy(int $id): RedirectResponse
  {
    $brand = Brand::find($id);
    $brand->delete();
    return redirect()->back()->with('success', ['Бренд успешно удалён']);
  }
}
