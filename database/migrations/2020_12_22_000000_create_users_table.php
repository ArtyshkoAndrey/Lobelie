<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->text('avatar')->nullable();
      $table->string('email')->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->text('address')->nullable();
      $table->string('post_code')->nullable();
      $table->string('phone')->nullable();
      $table->foreignId('country_id')
        ->nullable()
        ->constrained()
        ->onUpdate('cascade')
        ->onDelete('set null');

      $table->foreignId('city_id')
        ->nullable()
        ->constrained()
        ->onUpdate('cascade')
        ->onDelete('set null');

      $table->foreignId('currency_id')
        ->nullable()
        ->constrained()
        ->onUpdate('cascade')
        ->onDelete('set null');

      $table->boolean('is_admin')->default(false);
      $table->rememberToken();
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
    Schema::dropIfExists('users');
  }
}
