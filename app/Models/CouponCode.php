<?php

namespace App\Models;

use App\Exceptions\CouponCodeUnavailableException;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\CouponCode
 *
 * @property int $id
 * @property string $code
 * @property string $type
 * @property string $value
 * @property int $total
 * @property int $used
 * @property string $min_amount
 * @property string $max_amount
 * @property bool $disabled_other_sales
 * @property Carbon $not_before
 * @property Carbon $not_after
 * @property bool $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $description
 * @method static Builder|CouponCode newModelQuery()
 * @method static Builder|CouponCode newQuery()
 * @method static Builder|CouponCode query()
 * @method static Builder|CouponCode whereCode($value)
 * @method static Builder|CouponCode whereCreatedAt($value)
 * @method static Builder|CouponCode whereDisabledOtherSales($value)
 * @method static Builder|CouponCode whereEnabled($value)
 * @method static Builder|CouponCode whereId($value)
 * @method static Builder|CouponCode whereMaxAmount($value)
 * @method static Builder|CouponCode whereMinAmount($value)
 * @method static Builder|CouponCode whereNotAfter($value)
 * @method static Builder|CouponCode whereNotBefore($value)
 * @method static Builder|CouponCode whereTotal($value)
 * @method static Builder|CouponCode whereType($value)
 * @method static Builder|CouponCode whereUpdatedAt($value)
 * @method static Builder|CouponCode whereUsed($value)
 * @method static Builder|CouponCode whereValue($value)
 * @mixin Eloquent
 */
class CouponCode extends Model
{
  use HasFactory;

  protected $fillable = [
    'code',
    'type',
    'value',
    'total',
    'used',
    'min_amount',
    'max_amount',
    'disabled_other_sales',
    'not_before',
    'not_after',
    'enabled'
  ];

  protected $casts = [
    'enabled' => 'boolean',
    'disabled_other_sales'   => 'boolean',
  ];

  // Постоянно определяйте поддерживаемые типы купонов
  const TYPE_FIXED   = 'fixed';
  const TYPE_PERCENT = 'percent';

  const TYPE_MAP = [
    self::TYPE_FIXED,
    self::TYPE_PERCENT
  ];

  public static array $typeMap = [
    self::TYPE_FIXED   => 'Фиксированная сумма',
    self::TYPE_PERCENT => 'Процентная',
  ];
  protected $dates = ['not_before', 'not_after'];

  protected $appends = ['description'];

  public function getDescriptionAttribute (): string
  {
    $str = '';

    if ($this->min_amount > 0) {
      $str = 'От '.str_replace('.00', '', $this->min_amount). ' тг. ';
    }
    if ($this->type === self::TYPE_PERCENT) {
      return $str.'Скидка '.str_replace('.00', '', $this->value).'%';
    }

    return $str.'до '.str_replace('.00', '', $this->value) . ' тг. скидка';
  }

  /**
   * @param int|null $price
   * @throws CouponCodeUnavailableException
   */
  public function checkAvailable (int $price = null)
  {
    if (!$this->enabled) {
      throw new CouponCodeUnavailableException('Купон не существует');
    }

    if ($this->total - $this->used <= 0) {
      throw new CouponCodeUnavailableException('Все купоны были истрачены');
    }

    if ($this->not_before && $this->not_before->gt(Carbon::now())) {
      throw new CouponCodeUnavailableException('Купон еще не доступен');
    }

    if ($this->not_after && $this->not_after->lt(Carbon::now())) {
      throw new CouponCodeUnavailableException('Срок действия этого купона истек');
    }

    if (!is_null($price) && $price < $this->min_amount) {
      throw new CouponCodeUnavailableException('Сумма заказа не соответствует минимальной сумме купона');
    }
  }

  public function productsEnabled (): BelongsToMany
  {
    return $this->belongsToMany(Product::class, 'coupons_products', 'coupon_id', 'product_id');
  }

  public function brandsEnabled (): BelongsToMany
  {
    return $this->belongsToMany(Brand::class, 'coupons_brands', 'coupon_id', 'brand_id');
  }

  public function categoriesEnabled (): BelongsToMany
  {
    return $this->belongsToMany(Category::class, 'coupons_categories', 'coupon_id', 'category_id');
  }

  public function productsDisabled (): BelongsToMany
  {
    return $this->belongsToMany(Product::class, 'disabled_coupons_products', 'coupon_id', 'product_id');
  }

  public function brandsDisabled (): BelongsToMany
  {
    return $this->belongsToMany(Brand::class, 'disabled_coupons_brands', 'coupon_id', 'brand_id');
  }

  public function categoriesDisabled(): BelongsToMany
  {
    return $this->belongsToMany(Category::class, 'disabled_coupons_categories', 'coupon_id', 'category_id');
  }
}
