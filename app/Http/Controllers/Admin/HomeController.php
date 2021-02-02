<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class HomeController extends Controller {

  public function index (): View
  {
    return view('admin.index');
  }

  public function redirect ()
  {
    return redirect()->route('admin.index')->withSuccess(['Это новые тестовые уведомления, Добро пожаловать'])->withErrors(['Это новые тестовые уведомления, Добро пожаловать']);
  }
}
