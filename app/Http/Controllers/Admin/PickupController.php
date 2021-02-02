<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PickupController extends Controller {

  public function index (Request $request)
  {
    $name = $request->get('name');
    $cities = City::query();
    if($name) {
      $cities = $cities->where('name', 'like', '%' . $name . '%');
    }
    $filter = [
      'name' => $name
    ];
    $cities = $cities->wherePickup(true)
      ->paginate(14)
      ->appends($filter);

    return view('admin.settings.pickup.index', compact('cities', 'filter'));
  }

  public function store (Request $request): RedirectResponse
  {
    $request->validate([
      'city' => 'required|exists:cities,id,pickup,0'
    ]);

    $city = City::find($request->city);
    $city->pickup = true;
    $city->save();

    return redirect()->route('admin.settings.pickup.index')->with('success', ['Город добавлен к самовывозу']);
  }

  public function destroy (int $id): RedirectResponse
  {
    $city = City::find($id);
    $city->pickup = false;
    $city->save();

    return redirect()->route('admin.settings.pickup.index')->with('success', ['Город убран из самовывозу']);
  }
}
