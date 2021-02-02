<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('products', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('description');
      $table->boolean('on_sale')->default(true);
      $table->boolean('on_new')->default(false);
      $table->boolean('on_top')->default(false);
      $table->integer('sold_count')->default(0);
      $table->decimal('price', 10, 0);
      $table->decimal('price_sale', 10, 0)->nullable();
      $table->decimal('weight', 10, 2);
      $table->string('sex')->default(Product::SEX_UNISEX);
      $table->json('meta');
      $table->foreignId('brand_id')
        ->nullable()
        ->constrained('brands')
        ->onUpdate('cascade')
        ->onDelete('set null');
      $table->foreignId('category_id')
        ->nullable()
        ->constrained('categories')
        ->onUpdate('cascade')
        ->onDelete('set null');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('products');
  }
}
