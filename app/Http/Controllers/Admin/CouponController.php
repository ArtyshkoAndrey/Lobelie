<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CouponCode;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CouponController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|View|Response
   */
  public function index()
  {
    $coupons = CouponCode::all();

    return view('admin.coupon.index', compact('coupons'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View|Response
   */
  public function create()
  {
    return view('admin.coupon.create');
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
      'code' => 'required|unique:coupon_codes,code',
      'value' => 'required|numeric|min:0',
      'total' => 'required|numeric|min:0',
      'not_before' => 'required',
      'not_after' => 'required',
      'type' => 'required',
      'min_amount' => 'required',
      'max_amount' => 'required',
      'enabled' => 'required'
    ]);
    $coupon = new CouponCode();
    $coupon->code = $request->code;
    $coupon->type = $request->type;
    $coupon->value = $request->value;
    $coupon->total = $request->total;
    $coupon->min_amount = $request->min_amount;
    $coupon->max_amount  =$request->max_amount;
    $coupon->disabled_other_sales = $request->disabled_other_sales;
    $coupon->enabled = $request->enabled;

    $coupon->not_after = Carbon::parse($request->not_after);
    $coupon->not_before = Carbon::parse($request->not_before);
    $coupon->save();
    $coupon->productsEnabled()->sync($request->products);
    $coupon->productsDisabled()->sync($request->disabled_products);
    $coupon->brandsEnabled()->sync($request->brands);
    $coupon->brandsDisabled()->sync($request->disabled_brands);
    $coupon->categoriesEnabled()->sync($request->categories);
    $coupon->categoriesDisabled()->sync($request->disabled_categories);

    return redirect()->route('admin.coupon.index')->with('success', ['Промокод добавлен']);
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
   * @param  int $id
   * @return Application|Factory|View|Response
   */
  public function edit(int $id)
  {
    $cp = CouponCode::find($id);
    return view('admin.coupon.edit', compact('cp'));
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
      'code' => 'required|unique:coupon_codes,code,'.$id,
      'value' => 'required|numeric|min:0',
      'total' => 'required|numeric|min:0',
      'not_before' => 'required',
      'not_after' => 'required',
      'type' => 'required',
      'min_amount' => 'required',
      'max_amount' => 'required',
      'enabled' => 'required'
    ]);
    $coupon = CouponCode::find($id);
    $coupon->code = $request->code;
    $coupon->type = $request->type;
    $coupon->value = $request->value;
    $coupon->total = $request->total;
    $coupon->min_amount = $request->min_amount;
    $coupon->max_amount = $request->max_amount;
    $coupon->disabled_other_sales = $request->disabled_other_sales;
    $coupon->not_after = Carbon::parse($request->not_after);
    $coupon->not_before = Carbon::parse($request->not_before);
    $coupon->enabled = $request->enabled;
    $coupon->save();
    $coupon->productsEnabled()->sync($request->products);
    $coupon->productsDisabled()->sync($request->disabled_products);
    $coupon->brandsEnabled()->sync($request->brands);
    $coupon->brandsDisabled()->sync($request->disabled_brands);
    $coupon->categoriesEnabled()->sync($request->categories);
    $coupon->categoriesDisabled()->sync($request->disabled_categories);
    return redirect()->route('admin.coupon.edit', $id)->with('success', ['Промокод обновлён']);
  }
//  TODO: Дописать удаление

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
      CouponCode::find($id)->delete();
      return redirect()->back()->with('success', ['Промокод успешно удалён']);
    } catch(Exception $e) {
      return redirect()->back()->withErrors(['Ошибка удаления промокода']);
    }
  }
}
