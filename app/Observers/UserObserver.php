<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\File;

class UserObserver
{
  /**
   * Handle the User "created" event.
   *
   * @param User $user
   * @return void
   */
  public function created(User $user)
  {
      //
  }

  /**
   * Handle the User "updated" event.
   *
   * @param User $user
   * @return void
   */
  public function updated(User $user)
  {
      //
  }

  /**
   * Handle the User "deleted" event.
   *
   * @param User $user
   * @return void
   */
  public function deleted(User $user)
  {
    if ($user->avatar)
      File::delete(public_path('storage/users/' . $user->avatar));
  }

  /**
   * Handle the User "restored" event.
   *
   * @param User $user
   * @return void
   */
  public function restored(User $user)
  {
      //
  }

  /**
   * Handle the User "force deleted" event.
   *
   * @param User $user
   * @return void
   */
  public function forceDeleted(User $user)
  {
      //
  }
}
