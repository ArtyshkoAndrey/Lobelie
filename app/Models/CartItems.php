<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\CartItems
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_sku_id
 * @property int $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|CartItems newModelQuery()
 * @method static Builder|CartItems newQuery()
 * @method static Builder|CartItems query()
 * @method static Builder|CartItems whereAmount($value)
 * @method static Builder|CartItems whereCreatedAt($value)
 * @method static Builder|CartItems whereId($value)
 * @method static Builder|CartItems whereProductSkuId($value)
 * @method static Builder|CartItems whereUpdatedAt($value)
 * @method static Builder|CartItems whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $user
 */
class CartItems extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'amount',
    'user_id',
    'product_sku_id'
  ];

  /**
   * Отношения Продукта к данному товару в корзине
   *
   * @return BelongsTo
   */
  public function product(): BelongsTo
  {
    return $this->belongsTo(Product::class);
  }

  /**
   * Отношения пользователя к данному товару в корзине
   *
   * @return BelongsTo
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
