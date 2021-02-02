<?php

namespace Database\Seeders;

use App\Models\Order;
use DB;
use Eloquent;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    Eloquent::unguard();

//    $this->call('UserTableSeeder');
//    $this->command->info('User table seeded!');

    $path = 'public/sql/countries.sql';
    DB::unprepared(file_get_contents($path));
    $this->command->info('Country table seeded!');

    $path = 'public/sql/cities.sql';
    DB::unprepared(file_get_contents($path));
    $this->command->info('City table seeded!');

    DB::table('users')->insert([
      'name'        => 'Артышко Андрей Алексеевич',
      'email'       => 'artyshko.andrey@gmail.com',
      'password'    => Hash::make('123123'),
      'address'     => 'ул.Горького 24, кв. 25',
      'post_code'   => '660099',
      'phone'       => '+7(902)9999999',
      'country_id'  => 1,
      'city_id'     => 1,
      'avatar'      => null,
      'is_admin'    => true,
      'created_at'  => now(),
      'updated_at'  => now(),
    ]);
//    Юзер админов

    DB::table('users')->insert([
      'name'        => 'Роман',
      'email'       => 'iminovarts@gmail.com',
      'password'    => Hash::make('123123'),
      'address'     => 'Казахстан',
      'post_code'   => '660099',
      'phone'       => '+7(902)9999999',
      'country_id'  => 82,
      'city_id'     => 10451,
      'avatar'      => null,
      'is_admin'    => true,
      'created_at'  => now(),
      'updated_at'  => now(),
    ]);
    $this->command->info('User table seeded!');

//    DB::table('brands')->insert([
//      'name'        => 'Nike',
//      'created_at'  => now(),
//      'updated_at'  => now(),
//    ]);
//
//    DB::table('brands')->insert([
//      'name'        => 'Adidas',
//      'created_at'  => now(),
//      'updated_at'  => now(),
//    ]);
//    $this->command->info('Brands table seeded!');
//
//    DB::table('categories')->insert([
//      'name'        => 'Сноуборды',
//      'created_at'  => now(),
//      'updated_at'  => now(),
//    ]);
//
//    DB::table('categories')->insert([
//      'name'        => 'Крепления для сноуборда',
//      'created_at'  => now(),
//      'updated_at'  => now(),
//    ]);
//
//    DB::table('categories_categories')->insert([
//      'category_id'  => 1,
//      'child_category_id'  => 2,
//      'created_at'  => now(),
//      'updated_at'  => now(),
//    ]);
//    $this->command->info('Categories table seeded!');
//
//    DB::table('skus_categories')->insert([
//      'name'  => 'Сноуборды',
//      'created_at'  => now(),
//      'updated_at'  => now(),
//    ]);
//    DB::table('skus_categories')->insert([
//      'name'  => 'Дети',
//      'created_at'  => now(),
//      'updated_at'  => now(),
//    ]);
//    $this->command->info('Skus Categories table seeded!');
//
//    DB::table('skuses')->insert([
//      'title'  => '180',
//      'weight' => '1',
//      'skus_category_id' => 1,
//      'created_at'  => now(),
//      'updated_at'  => now(),
//    ]);
//    DB::table('skuses')->insert([
//      'title'  => '160',
//      'weight' => '2',
//      'skus_category_id' => 1,
//      'created_at'  => now(),
//      'updated_at'  => now(),
//    ]);
//    DB::table('skuses')->insert([
//      'title'  => '36',
//      'weight' => '2',
//      'skus_category_id' => 2,
//      'created_at'  => now(),
//      'updated_at'  => now(),
//    ]);
//    DB::table('skuses')->insert([
//      'title'  => '38',
//      'weight' => '1',
//      'skus_category_id' => 2,
//      'created_at'  => now(),
//      'updated_at'  => now(),
//    ]);
//    $this->command->info('Skuses table seeded!');
//
//    DB::table('products')->insert([
//      'title'  => 'Товар 1',
//      'description' => 'Это товар',
//      'on_sale' => false,
//      'on_new' => false,
//      'on_top' => false,
//      'sold_count' => 0,
//      'price' => 10000,
//      'price_sale' => null,
//      'weight' => 1,
//      'meta' => '{"title": "Товар","description": "Официальный разработчик "}',
//      'brand_id' => 1,
//      'category_id' => 1,
//      'created_at'  => now(),
//      'updated_at'  => now(),
//    ]);
//
//    $path = 'public/sql/photos.sql';
//    DB::unprepared(file_get_contents($path));
//
//    $this->command->info('Product table seeded!');
//
//    DB::table('product_skuses')->insert([
//      'stock'  => 10,
//      'product_id' => 1,
//      'skus_id' => 1,
//      'created_at'  => now(),
//      'updated_at'  => now(),
//    ]);
//    DB::table('product_skuses')->insert([
//      'stock'  => 100,
//      'product_id' => 1,
//      'skus_id' => 2,
//      'created_at'  => now(),
//      'updated_at'  => now(),
//    ]);
//    $this->command->info('Product table seeded!');
//
//    DB::table('orders')->insert([
//      'no'      => '12321333254',
//      'user_id' => 1,
//      'address' => '{"address":"\u041a\u0430\u0437\u0430\u0445\u0441\u0442\u0430\u043d,\u0410\u043b\u043c\u0430\u0442\u044b (\u0410\u043b\u043c\u0430-\u0410\u0442\u0430),\u0410\u0440\u043a\u0442\u0438\u0447\u0435\u0441\u043a\u0430\u044f 115","contact_name":"\u0420\u043e\u043c\u0430\u043d","contact_phone":"+77474117635"}',
//      'price'   => 30000,
//      'paid_at' => now(),
//      'ship_price' => 1973,
//      'payment_method' => 'card',
//      'ship_status' => Order::SHIP_STATUS_DELIVERED,
//      'ship_data' => '{}',
//      'created_at'  => now(),
//      'updated_at'  => now(),
//    ]);
//    DB::table('orders')->insert([
//      'no'      => '1233622333254',
//      'user_id' => 1,
//      'address' => '{"address":"\u041a\u0430\u0437\u0430\u0445\u0441\u0442\u0430\u043d,\u0410\u043b\u043c\u0430\u0442\u044b (\u0410\u043b\u043c\u0430-\u0410\u0442\u0430),\u0410\u0440\u043a\u0442\u0438\u0447\u0435\u0441\u043a\u0430\u044f 115","contact_name":"\u0420\u043e\u043c\u0430\u043d","contact_phone":"+77474117635"}',
//      'price'   => 20000,
//      'paid_at' => now(),
//      'ship_price' => 5160,
//      'payment_method' => 'card',
//      'ship_status' => Order::SHIP_STATUS_RECEIVED,
//      'ship_data' => '{}',
//      'created_at'  => now(),
//      'updated_at'  => now(),
//    ]);
//
//    DB::table('order_items')->insert([
//      'order_id'    => 1,
//      'product_id'  => 1,
//      'amount'      => 3,
//      'skus_id'     => 2,
//      'price'       => 10000
//    ]);
//
//    DB::table('order_items')->insert([
//      'order_id'    => 2,
//      'product_id'  => 1,
//      'amount'      => 2,
//      'skus_id'     => 1,
//      'price'       => 10000
//    ]);

    DB::table('settings')->insert([
      'name'        => 'cash',
      'data'        => '1',
      'created_at'  => now(),
      'updated_at'  => now(),
    ]);

    DB::table('settings')->insert([
      'name'        => 'cloudPayment',
      'data'        => '1',
      'created_at'  => now(),
      'updated_at'  => now(),
    ]);
  }
}
