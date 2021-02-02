<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkusCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Mockery\Exception;

class SkusCategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
      //
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
   * @return Application|RedirectResponse|Response|Redirector
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string'
    ]);
    $sk = new SkusCategory($request->all());
    $sk->save();
    return redirect('admin/skus#modal-skus-' . $sk->id)->with('success', ['Категория размеров "'. $sk->name .'" успешно создана']);
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
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request, $id)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return RedirectResponse
   * @throws \Exception
   */
  public function destroy(int $id): RedirectResponse
  {
    $sk = SkusCategory::find($id);
    $sk_name = $sk->name;
    try {
      $sk->delete();
      return redirect()->route('admin.skus.index')->with('success', ['Категория размеров "' . $sk_name . '" успешно удалёна']);
    } catch (Exception $exception) {
      return redirect()->route('admin.skus.index')->withErrors($exception->getMessage());
    }
  }
}
