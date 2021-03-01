<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Slider
 *
 * @property int $id
 * @property string $photo
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $photo_storage
 * @method static Builder|Slider newModelQuery()
 * @method static Builder|Slider newQuery()
 * @method static Builder|Slider query()
 * @method static Builder|Slider whereCreatedAt($value)
 * @method static Builder|Slider whereId($value)
 * @method static Builder|Slider wherePhoto($value)
 * @method static Builder|Slider whereTitle($value)
 * @method static Builder|Slider whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Slider extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'photo'
  ];

  const PHOTO_PATH = 'public/storage/slider/';

  public function getPhotoStorageAttribute (): string
  {
    return asset(Slider::PHOTO_PATH . $this->photo);
  }
}
