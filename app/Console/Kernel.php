<?php

namespace App\Console;

use App\Jobs\ClearImages;
use App\Jobs\NotifyWhenItemsCart;
use App\Jobs\UpdateCurrencies;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  /**
   * The Artisan commands provided by your application.
   *
   * @var array
   */
  protected $commands = [
    //
  ];

  /**
   * Define the application's command schedule.
   *
   * @param Schedule $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule)
  {
    $schedule->job(new UpdateCurrencies, 'currency', 'database')->dailyAt('8:00');
    $schedule->job(new ClearImages, 'default', 'database')->weeklyOn(1, '8:00');;
    $schedule->command('telescope:prune --hours=100')->daily();
  }

  /**
   * Register the commands for the application.
   *
   * @return void
   */
  protected function commands()
  {
    $this->load(__DIR__.'/Commands');
    require base_path('routes/console.php');
  }
}
