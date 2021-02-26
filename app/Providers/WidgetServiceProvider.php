<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use Blade;

class WidgetServiceProvider extends ServiceProvider
{
  public function boot()
  {
    Blade::directive('widget', function ($name) {
      return "<?php echo app('widget')->show($name); ?>";
    });
    /*
     * Регистрируется (добавляем) каталог для хранения шаблонов виджетов
     * app\Widgets\view
     */
    $this->loadViewsFrom(app_path() .'/../resources/views/widget', 'Widget');
  }

  public function register()
  {
    App::singleton('widget', function(){
      return new \App\Widget\Widget();
    });
  }
}
