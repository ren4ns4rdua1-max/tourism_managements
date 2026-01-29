<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
   public function boot()
{
    Blade::directive('push', function ($expression) {
        return "<?php \$__env->startPush($expression); ?>";
    });
}


}
