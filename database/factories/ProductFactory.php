<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected string $model = Product::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition(): array
  {
    return [
      'title' => $this->faker->words(10, true),
      'description' => $this->faker->words(100, true),
      'on_sale' => $this->faker->boolean,
      'on_new' => $this->faker->boolean,
      'sold_count' => 0,
      'price' => $this->faker->numberBetween(1, 250000),
      'price_sale' => $this->faker->numberBetween(1, 250000),
      'weight' => $this->faker->numberBetween(1, 10)
    ];
  }
}
