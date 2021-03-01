<?php

namespace Database\Factories;

use App\Models\ProductSkus;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductSkusFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected string $model = ProductSkus::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition(): array
  {
    return [
      'stock' => $this->faker->numberBetween(0, 99)
    ];
  }
}
