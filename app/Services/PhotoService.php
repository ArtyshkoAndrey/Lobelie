<?php
/*
 * Copyright (c) 2021. Данный файл является интелектуальной собственостью Fulliton.
 * Я буду рад если вы будите вносить улучшения, всегда жду ваших пул реквестов
 */

namespace App\Services;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;


class PhotoService
{
  protected static array $type = [
    'jpg',
    'webp'
  ];

  /**
   * @param $image
   * @param string $path
   * @param bool $cube
   * @param int $quality
   * @param int|null $width
   * @param int|null $height
   * @return string
   */
  public static function create ($image , string $path, bool $cube, int $quality, int $width = null, int $height = null): string
  {
    $file = $image->getClientOriginalName();
    $destinationPath = public_path($path);
    $originalName = pathinfo($file, PATHINFO_FILENAME);
    foreach (PhotoService::$type as $type) {
      $name = $originalName . '.' . $type;
      $img = Image::make($image->getRealPath())->encode($type, $quality);
      if ($cube) {
        $img->fit($width, $width, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
        });
      } else {
        $img->resize($width, $height, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
        });
      }
      $img->save($destinationPath.'/'.$name);
    }

    return $originalName;
  }

  /**
   * Delete Files by name
   *
   * @param $name
   * @return bool
   */
  public static  function delete ($name): bool
  {
    foreach (PhotoService::$type as $type) {
      if (file_exists(public_path('storage/images/photos/' . $name . '.' . $type)))
        File::delete(public_path('storage/images/photos/' . $name . '.' . $type));
      if (file_exists(public_path('storage/images/thumbnails/' . $name . '.' . $type)))
        File::delete(public_path('storage/images/thumbnails/' . $name . '.' . $type));
    }
    return true;
  }

}
