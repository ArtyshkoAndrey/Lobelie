<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skus;
use App\Models\SkusCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Mockery\Exception;
use Illuminate\Support\Facades\Validator;

class SkusController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|View|Response
   */
  public function index()
  {
    $skus_categories = SkusCategory::with('skuses')->get();
    return view('admin.skus.index', compact('skus_categories'));
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
      'title' => 'required|string',
      'sk'  => 'required|exists:skus_categories,id',
      'weight' => 'required|unique:skuses,weight,null,id,skus_category_id,'.$request->sk
    ]);

    $skus = new Skus($request->all());
    $sk = SkusCategory::find($request->sk);
    $sk->skuses()->save($skus);

    return redirect('admin/skus#modal-skus-' . $sk->id)->with('success', ['Размер успешно создан']);
  }

  /**
   * Display the specified resource.
   *
   * @return RedirectResponse
   */
  public function show(): RedirectResponse
  {
    return redirect()->back();
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return RedirectResponse|View
   */
  public function edit(int $id)
  {
    $validator = Validator::make(['id'=>$id], $this->rules());
    if ($validator->fails()) {
      return redirect()->route('admin.skus.index')->withErrors($validator);
    }
    $skus = Skus::find($id);
    $skuses = $skus->category->skuses;
    return view('admin.skus.edit', compact('skus', 'skuses'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param  int $id
   * @return RedirectResponse
   */
  public function update(Request $request, int $id): RedirectResponse
  {
    $request->validate([
      'title' => 'required|string',
      'weight' => 'required|integer'
    ]);

    $skus = Skus::find($id);
    if ($skus->weight !== $request->get('weight')) {
      $oldWeight = $skus->weight;
//      dump($skus->weight !== $request->get('weight'));
      $secondSkus = Skus::whereHas('category', function ($q) use ($skus) {
        $q->whereId($skus->category->id);
      })->whereWeight($request->get('weight'))->first();
      if ($secondSkus) {
//        dump($secondSkus);
        $secondSkus->weight = $oldWeight;
//        dd($secondSkus->weight, $oldWeight);
        $secondSkus->save();
//        dd($secondSkus->weight);
      }
    }
    $skus->update($request->all());
    return redirect()->back()->with('success', ['Размер успешно обнавлён']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return Application|RedirectResponse|Redirector
   * @throws \Exception
   */
  public function destroy(int $id)
  {
    $skus = Skus::with('category')->find($id);
    $sk_id = $skus->category->id;
    try {
      $skus->delete();
      return redirect('admin/skus#modal-skus-' . $sk_id)->with('success', ['Размер успешно удалён']);
    } catch (Exception $exception) {
      return redirect('admin/skus#modal-skus-' . $sk_id)->withErrors([$exception->getMessage()]);
    }

  }

  public function rules(): array
  {
    return [
      'id' => 'required|integer|exists:skuses,id',
    ];

  }
}
