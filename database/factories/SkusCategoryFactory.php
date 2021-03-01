<?php

namespace Database\Factories;

use App\Models\SkusCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkusCategoryFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected string $model = SkusCategory::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition(): array
  {
    return [
      'name' => $this->faker->unique()->words(1, true),
    ];
  }
}
