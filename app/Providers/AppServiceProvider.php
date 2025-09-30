<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Helpers\NumberHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Custom Blade directives untuk formatting angka
        Blade::directive('comparison', function ($expression) {
            return "<?php echo NumberHelper::formatComparison($expression); ?>";
        });

        Blade::directive('weight', function ($expression) {
            return "<?php echo NumberHelper::formatWeight($expression); ?>";
        });

        Blade::directive('percentage', function ($expression) {
            return "<?php echo NumberHelper::formatPercentage($expression); ?>";
        });

        Blade::directive('score', function ($expression) {
            return "<?php echo NumberHelper::formatScore($expression); ?>";
        });

        Blade::directive('subcriteria', function ($expression) {
            return "<?php echo NumberHelper::formatSubCriteria($expression); ?>";
        });

        Blade::directive('cr', function ($expression) {
            return "<?php echo NumberHelper::formatCR($expression); ?>";
        });
    }
}
