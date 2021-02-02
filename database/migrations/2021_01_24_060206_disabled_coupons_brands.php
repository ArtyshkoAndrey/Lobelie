<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DisabledCouponsBrands extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('disabled_coupons_brands', function (Blueprint $table) {
      $table->id();
      $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade')->onUpdate('cascade');
      $table->foreignId('coupon_id')->constrained('coupon_codes')->onDelete('cascade')->onUpdate('cascade');

    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('disabled_coupons_brands');
  }
}
