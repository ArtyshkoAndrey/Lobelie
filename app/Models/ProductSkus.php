<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProductSkus
 *
 * @property int $id
 * @property int $stock
 * @property int $product_id
 * @property int $skus_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Product|null $product
 * @property-read Skus|null $skus
 * @method static Builder|ProductSkus newModelQuery()
 * @method static Builder|ProductSkus newQuery()
 * @method static Builder|ProductSkus query()
 * @method static Builder|ProductSkus whereCreatedAt($value)
 * @method static Builder|ProductSkus whereId($value)
 * @method static Builder|ProductSkus whereProductId($value)
 * @method static Builder|ProductSkus whereSkusId($value)
 * @method static Builder|ProductSkus whereStock($value)
 * @method static Builder|ProductSkus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductSkus extends Model
{
  use HasFactory;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'stock',
    'skus_id',
    'product_id'
  ];

  public function skus (): HasOne
  {
    return $this->hasOne(Skus::class, 'id', 'skus_id');
  }

  public function product (): HasOne
  {
    return $this->hasOne(Product::class, 'id', 'product_id');
  }
}
