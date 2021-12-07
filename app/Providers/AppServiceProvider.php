<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;


class AppServiceProvider extends ServiceProvider
{
    public function register() {}

    public function boot()
    {
        Blade::directive('rowBackground', function ($index) {
            return "<?php echo (int) $index % 2 === 0 ? 'bg-white' : 'bd-gray-50' ?>";
        });
    }
}
