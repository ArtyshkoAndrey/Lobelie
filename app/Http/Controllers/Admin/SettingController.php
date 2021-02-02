<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
  /**
   * @return Application|Factory|View
   */
  public function index ()
  {
    $cash = Setting::whereName('cash')->first();
    $cloudPayment = Setting::whereName('cloudPayment')->first();

    return view('admin.settings.money.index', compact('cash', 'cloudPayment'));
  }

  public function update (Request $request): RedirectResponse
  {
    $cash = Setting::whereName('cash')->first();
    $cash->data = $request->has('cash');
    $cash->save();
    $cloudPayment = Setting::whereName('cloudPayment')->first();
    $cloudPayment->data = $request->has('cloudPayment');
    $cloudPayment->save();
//    dd($request->has('cloudPayment'));

    return redirect()->route('admin.settings.money.index')->with('success', ['Настроки сохранены']);
  }
}
