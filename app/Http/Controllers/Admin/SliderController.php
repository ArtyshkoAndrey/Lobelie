<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;
use File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class SliderController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
   */
  public function index()
  {
    $sliders = Slider::all();

    return view('admin.slider.index', compact('sliders'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return void
   */
  public function create(): void
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
      'title' => 'required|string',
      'photo' => 'required|image'
    ]);
    $data = $request->all();
    $image = $request->file('photo');
    $img = Image::make($image->getRealPath())->encode('jpg', 100);
    $originalName = time() . '_' . pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '.jpg';
    $img->fit(1920, 1080, function ($constraint) {
      $constraint->aspectRatio();
      $constraint->upsize();
    });
    $img->save(SLider::PHOTO_PATH . $originalName);
    $data['photo'] = $originalName;

    $slider = new Slider($data);
    $slider->save();

    return redirect()->route('admin.slider.index')->with('success', ['Новая карточка Slider создана']);
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return void
   */
  public function show(int $id): void
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return void
   */
  public function edit(int $id): void
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request, int $id): RedirectResponse
  {
    $request->validate([
      'title' => 'required|string',
      'photo' => 'sometimes|image'
    ]);
    $slider = Slider::find($id);
    $data = $request->all();
    if($request->has('photo')) {
      File::delete(Slider::PHOTO_PATH . $slider->photo);
      $image = $request->file('photo');
      $img = Image::make($image->getRealPath())->encode('jpg', 100);
      $originalName = time() . '_' . pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '.jpg';
      $img->fit(1920, 1080, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
      });
      $img->save(SLider::PHOTO_PATH . $originalName);
      $data['photo'] = $originalName;
    }

    $slider->update($data);

    return redirect()->back()->with('success', ['Карточка для Slider успешно изменена']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return \Illuminate\Http\RedirectResponse
   * @throws \Exception
   */
  public function destroy(int $id): RedirectResponse
  {
    Slider::find($id)->delete();

    return redirect()->back()->with('success', ['Карточка для Slider успешно удалена']);
  }
}
