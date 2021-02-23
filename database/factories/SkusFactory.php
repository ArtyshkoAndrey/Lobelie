<?php

namespace Database\Factories;

use App\Models\Skus;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkusFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected string $model = Skus::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition(): array
  {
    return [
      'title' => $this->faker->unique()->words(1, true),
      'weight' => $this->faker->unique()->numberBetween(),
    ];
  }
}
