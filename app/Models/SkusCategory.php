<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\SkusCategory
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SkusCategory newModelQuery()
 * @method static Builder|SkusCategory newQuery()
 * @method static Builder|SkusCategory query()
 * @method static Builder|SkusCategory whereCreatedAt($value)
 * @method static Builder|SkusCategory whereId($value)
 * @method static Builder|SkusCategory whereName($value)
 * @method static Builder|SkusCategory whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Skus[] $skuses
 * @property-read int|null $skuses_count
 */
class SkusCategory extends Model
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

  public function skuses ()
  {
    return $this->hasMany(Skus::class);
  }

}
