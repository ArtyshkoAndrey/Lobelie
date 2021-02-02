<?php

namespace App\Observers;

use App\Models\Photo;
use App\Services\PhotoService;
use Illuminate\Support\Facades\File;

class PhotoObserver
{
  /**
   * Handle the Photo "created" event.
   *
   * @param Photo $photo
   * @return void
   */
  public function created(Photo $photo)
  {
    //
  }

  /**
   * Handle the Photo "updated" event.
   *
   * @param Photo $photo
   * @return void
   */
  public function updated(Photo $photo)
  {
    //
  }

  /**
   * Handle the Photo "deleted" event.
   *
   * @param Photo $photo
   * @return void
   */
  public function deleted(Photo $photo)
  {
    PhotoService::delete($photo->name);
  }

  /**
   * Handle the Photo "restored" event.
   *
   * @param Photo $photo
   * @return void
   */
  public function restored(Photo $photo)
  {
    //
  }

  /**
   * Handle the Photo "force deleted" event.
   *
   * @param Photo $photo
   * @return void
   */
  public function forceDeleted(Photo $photo)
  {

  }
}
