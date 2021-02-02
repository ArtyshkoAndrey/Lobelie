<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\City
 *
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Country|null $country
 * @method static Builder|City newModelQuery()
 * @method static Builder|City newQuery()
 * @method static Builder|City query()
 * @method static Builder|City whereCountryId($value)
 * @method static Builder|City whereCreatedAt($value)
 * @method static Builder|City whereId($value)
 * @method static Builder|City whereName($value)
 * @method static Builder|City whereUpdatedAt($value)
 * @mixin Eloquent
 * @property bool $pickup
 * @property-read string $search_name
 * @method static Builder|City wherePickup($value)
 */
class City extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'pickup'
  ];

  protected $casts = [
    'pickup' => 'boolean'
  ];

  protected $appends = [
    'search_name'
  ];

  /**
   * Country city
   *
   * @return HasOne
   */
  public function country (): HasOne
  {
    return $this->hasOne(Country::class, 'id', 'country_id');
  }

  public function getSearchNameAttribute (): string
  {
    return $this->name . '(' . $this->country->name . ')';
  }
}
