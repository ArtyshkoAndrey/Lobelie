<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected string $model = Category::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition(): array
  {
    return [
      'name' => $this->faker->title,
      'description' => $this->faker->paragraph,
      'to_menu' => $this->faker->boolean,
      'photo' => 'category-image.png'
    ];
  }
}
