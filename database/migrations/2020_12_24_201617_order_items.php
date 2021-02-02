<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderItems extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('order_items', function (Blueprint $table) {
      $table->id();
      $table->foreignId('product_id')
        ->constrained('products')
        ->onUpdate('cascade')
        ->onDelete('cascade');
      $table->foreignId('order_id')
        ->constrained('orders')
        ->onUpdate('cascade')
        ->onDelete('cascade');
      $table->foreignId('skus_id')
        ->constrained('skuses')
        ->onUpdate('cascade')
        ->onDelete('cascade');
      $table->integer('amount')->default(0);
      $table->decimal('price', 10, 0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('order_items');
  }
}
