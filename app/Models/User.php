<?php
/*
* Copyright (c) 2020. Данный файл является интелектуальной собственостью Fulliton.
* Я буду рад если вы будите вносить улучшения, всегда жду ваших пул реквестов
*/

namespace App\Models;

use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string|null $avatar
 * @property string|null $address
 * @property string|null $post_code
 * @property int|null $country_id
 * @property int|null $city_id
 * @property-read City|null $city
 * @property-read Country|null $country
 * @method static Builder|User whereAddress($value)
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereCityId($value)
 * @method static Builder|User whereCountryId($value)
 * @method static Builder|User wherePostCode($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductSkus[] $cartItems
 * @property-read int|null $cart_items_count
 * @property bool $is_admin
 * @method static Builder|User whereIsAdmin($value)
 * @property int|null $currency_id
 * @method static Builder|User whereCurrencyId($value)
 * @property string|null $phone
 * @property-read \App\Models\Currency|null $currency
 * @property-read string $avatar_image
 * @property-read string $full_address
 * @method static Builder|User wherePhone($value)
 */
class User extends Authenticatable
{
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'avatar',
    'email',
    'password',
    'address',
    'post_code',
    'is_admin',
    'currency_id',
    'phone'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'is_admin' => 'boolean'
  ];

  /**
   * User city
   *
   * @return BelongsTo
   */
  public function city (): BelongsTo
  {
    return $this->belongsTo(City::class);
  }

  public function cartItems (): HasMany
  {
    return $this->hasMany(CartItems::class, 'user_id', 'id');
  }

  public function orders ()
  {
    return $this->hasMany(Order::class);
  }

  /**
   * User country
   *
   * @return BelongsTo
   */
  public function country (): BelongsTo
  {
    return $this->belongsTo(Country::class);
  }

  public function addToCart (Skus $skus)
  {
    if ($item = $this->cartItems()->where('product_sku_id', $skus->pivot->id)->first()) {
      $item->amount++;
      $item->save();
    } else {
      CartItems::create([
        'user_id' => auth()->user()->id,
        'product_skus_id' => $skus->pivot->id,
        'amount' => 1
      ]);
    }
  }

  public function currency (): belongsTo
  {
    return $this->belongsTo(Currency::class);
  }

  public function getAvatarImageAttribute (): string
  {
    return $this->avatar ? asset('storage/avatar/' . $this->avatar) : asset('images/product.jpg');
  }

  public function getFullAddressAttribute (): string
  {
    $text = '';
    if($this->country)
      $text .= $this->country->name . ', ';

    if($this->city)
      $text .= $this->city->name . ', ';

    if($this->address)
      if($this->post_code)
        $text .= $this->address . ', ';
      else
        $text .= $this->address;

    if($this->post_code)
      $text .= $this->post_code;

    return $text;
  }
}
