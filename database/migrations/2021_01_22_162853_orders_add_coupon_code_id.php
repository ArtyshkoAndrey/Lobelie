<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrdersAddCouponCodeId extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('orders', function (Blueprint $table) {
      $table->foreignId('coupon_code_id')
        ->nullable()
        ->constrained('coupon_codes')
        ->onDelete('set null');
      $table->decimal('sale', 10, 2)->default(0);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('orders', function (Blueprint $table) {
      $table->dropForeign(['coupon_code_id']);
      $table->dropColumn('coupon_code_id');
      $table->dropColumn('sale');
    });
  }
}
