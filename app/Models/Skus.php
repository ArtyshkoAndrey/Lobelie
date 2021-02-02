<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Skus
 *
 * @property int $id
 * @property string $title
 * @property int $weight
 * @property int $skus_category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SkusCategory|null $category
 * @method static \Illuminate\Database\Eloquent\Builder|Skus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skus query()
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereSkusCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skus whereWeight($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 */
class Skus extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'title',
    'weight',
    'skus_category_id'
  ];

  public function category (): BelongsTo
  {
    return $this->belongsTo(SkusCategory::class, 'skus_category_id', 'id', 'skus_categories');
  }

  public function products (): BelongsToMany
  {
    return $this->belongsToMany(Product::class, 'product_skuses', 'skus_id', 'product_id', 'id');
  }
}
