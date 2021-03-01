<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserFavoriteProduct extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_favorite_products', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')
        ->constrained('users')
        ->onDelete('cascade');
      $table->foreignId('product_id')
        ->constrained('products')
        ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('user_favorite_products');
  }
}
