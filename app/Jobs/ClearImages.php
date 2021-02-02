<?php

namespace App\Jobs;

use App\Models\Photo;
use App\Services\PhotoService;

use Ds\Set;
use Illuminate\Bus\Queueable;
use Illuminate\Http\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

// Работа отчистки хостинга от лишних фотографий
class ClearImages implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * @var PhotoService
   */
  private PhotoService $photoService;


  public function __construct()
  {
    $this->photoService = new PhotoService();
  }

  public function handle()
  {
    $dir = public_path('storage/images/photos');

    $files = array_values(array_filter(scandir($dir), function($file) use ($dir) {
      return !is_dir($dir . '/' . $file);
    }));
    $filesName = new Set();
    foreach ($files as $file) {
      if (file_exists($dir . '/' . $file)) {
        $userFile = new File($dir . '/' . $file);
        $filename = explode($userFile->getExtension(), $userFile->getBasename())[0];
        $filename = explode('.', $filename)[0];

        if (!$filesName->contains($filename)) {
          $filesName->add($filename);

          if (!Photo::whereName($filename)->exists()) {
            $this->photoService->delete($filename);
          }
        } else
          continue;
      }

    }
  }
}
