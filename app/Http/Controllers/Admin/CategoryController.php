<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return Application|Factory|View|RedirectResponse|Response
   */
  public function index(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'category_id' => 'exists:categories,id'
    ]);

    if ($validator->fails()) {
      return redirect()->route('admin.index')->withErrors($validator);
    }
    $categoriesLink = [];
    if($category_id = $request->get('category_id')) {

      $childCategory =  Category::find($category_id);
      $categoryTemp = $childCategory;
      $categories = Category::find($category_id)->child;
      while($category = $childCategory->parents()->first()) {
        array_unshift($categoriesLink, $category);
        $childCategory = $category;
      }
      array_push($categoriesLink, $categoryTemp);
    } else {
      $categories = Category::select('*')->whereNotIn('id',function($query) {
        $query->select('child_category_id')->from('categories_categories');
      })->get();
    }

    return view('admin.category.index', compact('categories', 'categoriesLink'));
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
      'name' => 'required|string',
      'category_id' => 'required|exists_or_null:categories,id',
      'to_menu' => 'required|boolean'
    ]);

    $category = new Category($request->all());
    $category->save();
    if((int) $category_id = $request->get('category_id')) {
      $category->parents()->attach($category_id);
      return redirect()->route('admin.category.index', ['category_id' => $category_id])->with('success', ['Категория успешно создана']);
    }
    return redirect()->route('admin.category.index')->with('success', ['Категория успешно создана']);
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
   * @param  int $id
   * @return RedirectResponse
   */
  public function update(Request $request, int $id)
  {
    $request->validate([
      'name' => 'required|string',
      'to_menu' => 'required|boolean'
    ]);
    Category::find($id)->update($request->all());
    return redirect()->back()->with('success', ['Категория успешна изменена']);
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
    try {
      Category::find($id)->delete();
      return redirect()->back()->with('success', ['Категория успешна удалена']);
    } catch (Exception $exception) {
      return redirect()->back()->withErrors(['Ошибка удаления категории']);
    }
  }
}
