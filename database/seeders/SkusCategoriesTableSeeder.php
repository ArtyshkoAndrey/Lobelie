<?php

namespace Database\Seeders;

use App\Models\Skus;
use App\Models\SkusCategory;
use Illuminate\Database\Seeder;

class SkusCategoriesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $sk = SkusCategory::factory()
      ->create();

    Skus::factory()
      ->count(5)
      ->for($sk, 'category')
      ->create();
  }
}
