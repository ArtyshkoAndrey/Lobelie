<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->string('no')->unique();
      $table->foreignId('user_id')
        ->constrained('users')
        ->onUpdate('cascade')
        ->onDelete('cascade');
      $table->json('address');
      $table->decimal('price', 10, 2);
      $table->decimal('ship_price', 10,2)->default(0);
      $table->timestamp('paid_at')->nullable();
      $table->text('payment_method');
      $table->string('ship_status')->default(Order::SHIP_STATUS_PAID);
      $table->json('ship_data')->nullable();
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
    Schema::dropIfExists('orders');
  }
}
