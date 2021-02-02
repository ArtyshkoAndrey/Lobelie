<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property bool $on_sale
 * @property bool $on_new
 * @property bool $on_top
 * @property int $sold_count
 * @property string $price
 * @property string|null $price_sale
 * @property string $weight
 * @property object $meta
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|Brand[] $brands
 * @property-read int|null $brands_count
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @property-read Collection|Photo[] $photos
 * @property-read int|null $photos_count
 * @property-read Collection|ProductSkus[] $productSkuses
 * @property-read int|null $product_skuses_count
 * @property-read Collection|Skus[] $skuses
 * @property-read int|null $skuses_count
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static Builder|Product query()
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDeletedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereMeta($value)
 * @method static Builder|Product whereOnNew($value)
 * @method static Builder|Product whereOnSale($value)
 * @method static Builder|Product whereOnTop($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product wherePriceSale($value)
 * @method static Builder|Product whereSoldCount($value)
 * @method static Builder|Product whereTitle($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 * @mixin Eloquent
 * @property string $sex
 * @property int|null $brand_id
 * @property int|null $category_id
 * @property-read \App\Models\Brand|null $brand
 * @property-read \App\Models\Category|null $category
 * @property-read Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @method static Builder|Product whereBrandId($value)
 * @method static Builder|Product whereCategoryId($value)
 * @method static Builder|Product whereSex($value)
 * @property-read string $thumbnail_jpg
 * @property-read string $thumbnail_webp
 */
class Product extends Model
{
  use HasFactory;
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'title',
    'description',
    'on_sale',
    'on_new',
    'on_top',
    'sold_count',
    'price',
    'price_sale',
    'weight',
    'meta',
    'sex'
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'on_sale' => 'boolean',
    'on_new' => 'boolean',
    'on_top' => 'boolean',
    'meta' => 'object',
  ];

//  protected $with  = ['photos', 'promotions', 'skus'];

  protected $dates = ['deleted_at'];

  /**
   * The model's default values for attributes.
   *
   * @var array
   */
  protected $attributes = [
    'meta' => '{
      "description": "",
      "title": ""
    }'
  ];

  protected $appends =[
    'thumbnail_webp',
    'thumbnail_jpg'
  ];

  const SEX_MALE    = 'male';
  const SEX_FEMALE  = 'female';
  const SEX_UNISEX  = 'unisex';
  const SEX_CHILD   = 'child';

  const SEX_MAP = [
    self::SEX_MALE,
    self::SEX_FEMALE,
    self::SEX_UNISEX,
    self::SEX_CHILD
  ];

  public static array $sexMap = [
    self::SEX_UNISEX  => 'Унисекс',
    self::SEX_FEMALE  => 'Женский',
    self::SEX_MALE    => 'Мужской',
    self::SEX_CHILD   => 'Детский'
  ];

  public function available (): bool
  {
    $counter = 0;
    foreach ($this->skus as $sku) {
      $counter += $sku->stock;
    }
    return (boolean) $counter > 0;
  }

  public function category(): BelongsTo
  {
    return $this->belongsTo(Category::class, 'category_id', 'id');
  }

  public function brand(): BelongsTo
  {
    return $this->belongsTo(Brand::class, 'brand_id', 'id');
  }

  public function photos(): HasMany
  {
    return $this->hasMany(Photo::class, 'product_id', 'id');
  }

  public function skuses(): BelongsToMany
  {
    return $this->belongsToMany(Skus::class, 'product_skuses', 'product_id', 'skus_id')->withPivot('stock', 'id');
  }

  public function productSkuses(): HasMany
  {
    return $this->hasMany(ProductSkus::class, 'product_id', 'id');
  }

  public function orders(): BelongsToMany
  {
    return $this->belongsToMany(Order::class, 'order_items', 'product_id', 'order_id')->withPivot(['amount']);
  }

  public function getThumbnailWebpAttribute (): string
  {
    if ($this->photos->count() > 0) {
      return $this->photos->first()->thumbnail_url_webp;
    } else {
      return asset('images/product.jpg');
    }
  }

  public function getThumbnailJpgAttribute (): string
  {
    if ($this->photos->count() > 0) {
      return $this->photos->first()->thumbnail_url_jpg;
    } else {
      return asset('images/product.jpg');
    }
  }

  protected static function booted()
  {
    parent::boot();
    static::deleting(function ($product) {
      if ($product->isForceDeleting()) {
        foreach ($product->photos as $photo) {
          $photo->delete();
        }
      }
    });
  }
}
