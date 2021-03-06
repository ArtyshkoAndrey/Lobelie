<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CouponsBrands extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('coupons_brands', function (Blueprint $table) {
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
    Schema::dropIfExists('coupons_brands');
  }
}
