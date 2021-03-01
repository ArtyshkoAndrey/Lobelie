<?php

namespace App\Observers;

use App\Models\Slider;
use File;

class SliderObserver
{
  /**
  * Handle the Photo "created" event.
  *
  * @param Slider $slider
  * @return void
  */
  public function created(Slider $slider)
  {
    //
  }

  /**
   * Handle the Photo "updated" event.
   *
   * @param Slider $slider
   * @return void
   */
  public function updated(Slider $slider)
  {
    //
  }

  /**
   * Handle the Photo "deleted" event.
   *
   * @param Slider $slider
   * @return void
   */
  public function deleted(Slider $slider)
  {
    File::delete(Slider::PHOTO_PATH . $slider->photo);
  }

  /**
   * Handle the Photo "restored" event.
   *
   * @param Slider $slider
   * @return void
   */
  public function restored(Slider $slider)
  {
    //
  }

  /**
   * Handle the Photo "force deleted" event.
   *
   * @param Slider $slider
   * @return void
   */
  public function forceDeleted(Slider $slider)
  {
    File::delete(Slider::PHOTO_PATH . $slider->photo);
  }
}
