<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller {
  public function countries (Request $request): JsonResponse
  {
    if ($name = $request->get('name', null)) {
      $countries = Country::where('name', 'like', '%'.$name.'%')->limit(5)->get();
    } else {
      $countries = Country::limit(5)->get();
    }
    return response()->json(['countries'=> $countries], 200);
  }

  public function categories (Request $request): JsonResponse
  {
    if ($name = $request->get('name', null)) {
      $categories = Category::where('name', 'like', '%'.$name.'%')->limit(5)->get();
    } else {
      $categories = Category::limit(5)->get();
    }
    return response()->json(['categories'=> $categories], 200);
  }

  public function cities (Request $request): JsonResponse
  {
    if ($name = $request->get('name', null)) {
      $cities = City::where('name', 'like', '%'.$name.'%')->limit(5)->get();
    } else {
      $cities = City::limit(5)->get();
    }
    return response()->json(['cities'=> $cities], 200);
  }

  public function brands (Request $request): JsonResponse
  {
    $name = $request->get('name', null);
    if ($name && $name !== '') {
      $brands = Brand::where('name', 'like', '%'.$name.'%')->limit(5)->get();
    } else {
      $brands = Brand::limit(5)->get();
    }
    return response()->json(['brands'=> $brands], 200);
  }

  public function check (): JsonResponse
  {
    $data = (object) [
      'auth' => Auth::check(),
      'user' => Auth::user()
    ];
    return response()->json($data, 200);
  }
}
