<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property bool $to_menu
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereToMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $child
 * @property-read int|null $child_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $parents
 * @property-read int|null $parents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read string $search_name
 */
class Category extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'to_menu',
    'description',
    'photo',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'to_menu' => 'boolean',
  ];

  protected $appends = [
    'search_name'
  ];

  const PHOTO_PATH = 'storage/category/';

  /**
   * Дочерние категории
   *
   * @return BelongsToMany
   */
  public function child(): BelongsToMany
  {
    return $this->belongsToMany(Category::class, 'categories_categories', 'category_id', 'child_category_id');
  }

  /**
   * Родительская категория
   *
   * @return BelongsToMany
   */
  public function parents(): BelongsToMany
  {
    return $this->belongsToMany(Category::class, 'categories_categories', 'child_category_id', 'category_id');
  }

  public function products(): HasMany
  {
    return $this->hasMany(Product::class);
  }

  public function getSearchNameAttribute (): string
  {
    if ($this->parents()->count() > 0)
      return $this->name . '(' . $this->parents()->first()->name .')';

    if ($this->child()->count() > 0)
      return $this->name . '(' . $this->child()->first()->name .')';

    return $this->name;
  }

  public function getPhotoStorageAttribute (): string
  {
    if ($this->photo)
      return asset(Category::PHOTO_PATH . $this->photo);

    else
      return asset('images/user-o.png');

  }
}
