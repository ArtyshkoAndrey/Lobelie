<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Product;
use App\Models\ProductSkus;
use App\Models\Skus;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Product::factory()
      ->count(20)
      ->for(Brand::all()->random(10)->first(), 'brand')
      ->for(Category::all()->random(10)->first(), 'category')
      ->hasPhotos(
        Photo::factory()
          ->count(5)
          ->create()
      )
      ->create();

    $products = Product::all();
    foreach ($products as $i => $item) {
      $c = $i % 5;
      if ($c === 0)
        $c = 1;

      ProductSkus::factory()
        ->create([
          'skus_id' => $c,
          'product_id' => $item->id
        ]);
    }
  }
}
