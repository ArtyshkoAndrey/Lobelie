<?php

namespace Database\Factories;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected string $model = Photo::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition(): array
  {
    return [
      'name' => 'category-image.png'
    ];
  }
}
