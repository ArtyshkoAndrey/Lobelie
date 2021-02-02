<?php


namespace App\Jobs;

use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class UpdateCurrencies implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected string $url = 'https://nationalbank.kz/rss/rates_all.xml';

  /**
   * Create a new job instance.
   *
   */
  public function __construct()
  {

  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $arrContextOptions = array(
      "ssl"=> array(
        "verify_peer" => false,
        "verify_peer_name" => false
      )
    );

    try {
      $assertion = file_get_contents($this->url, false, stream_context_create($arrContextOptions));
      $ar = simplexml_load_string($assertion);
      if (isset($ar->channel)) {
        if(isset($ar->channel->item)) {
          foreach ($ar->channel->item as $item) {
            if (isset($item->title) && isset($item->description)) {
              if ((string)$item->title === 'USD') {
                $currency = Currency::where('short_name', 'USD')->first();
                $currency->ratio = 1 / $item->description;
                $currency->save();
              } else if ((string)$item->title === 'RUB') {
                $currency = Currency::where('short_name', 'RUB')->first();
                $currency->ratio = 1 / $item->description;
                $currency->save();
              }
            }
          }
        }
      }

      $currency = Currency::where('name', 'Тенге')->first();
      $currency->updated_at = Carbon::now();
      $currency->save();
    } catch (\ErrorException $e) {
      Log::info($e);
    }
  }

}
