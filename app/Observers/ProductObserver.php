<?php

namespace App\Observers;

use App\Models\Product;
use Exception;

class ProductObserver
{
  /**
   * Handle the Product "created" event.
   *
   * @param Product $product
   * @return void
   */
  public function created(Product $product)
  {
    //
  }

  /**
   * Handle the Product "updated" event.
   *
   * @param Product $product
   * @return void
   */
  public function updated(Product $product)
  {
    //
  }

  /**
   * Handle the Product "deleted" event.
   *
   * @param Product $product
   * @return void
   */
  public function deleted(Product $product)
  {
    //
  }

  /**
   * Handle the Product "restored" event.
   *
   * @param Product $product
   * @return void
   */
  public function restored(Product $product)
  {
    //
  }

/**
 * Handle the Product "force deleted" event.
 *
 * @param Product $product
 * @return void
 * @throws Exception
 */
  public function forceDeleted(Product $product)
  {

  }
}
