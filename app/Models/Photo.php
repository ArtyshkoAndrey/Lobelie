<?php

namespace App\Models;

use App\Observers\PhotoObserver;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Photo
 *
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Photo newModelQuery()
 * @method static Builder|Photo newQuery()
 * @method static Builder|Photo query()
 * @method static Builder|Photo whereCreatedAt($value)
 * @method static Builder|Photo whereId($value)
 * @method static Builder|Photo whereName($value)
 * @method static Builder|Photo whereProductId($value)
 * @method static Builder|Photo whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \App\Models\Product|null $product
 * @property-read string $thumbnail_url_jpg
 * @property-read string $thumbnail_url_webp
 * @property-read string $url_jpg
 * @property-read string $url_webp
 */
class Photo extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
  ];

  protected $appends = [
    'thumbnail_url_webp',
    'url_webp',
    'url_jpg',
    'thumbnail_url_jpg'
  ];
  public function product(): BelongsTo
  {
    return $this->belongsTo(Product::class, 'product_id', 'id')->withTrashed();
  }

  public function getUrlWebpAttribute(): string
  {
    return asset('storage/images/photos/' . str_replace(" ", "%20", $this->name)  . '.webp');
  }

  public function getThumbnailUrlWebpAttribute(): string
  {
    return asset('storage/images/thumbnails/' . str_replace(" ", "%20", $this->name)  . '.webp');
  }

  public function getUrlJpgAttribute(): string
  {
    return asset('storage/images/photos/' . str_replace(" ", "%20", $this->name)  . '.jpg');
  }

  public function getThumbnailUrlJpgAttribute(): string
  {
    return asset('storage/images/thumbnails/' .  str_replace(" ", "%20", $this->name) . '.jpg');
  }

}
