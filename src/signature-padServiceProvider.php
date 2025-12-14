<?php

namespace MrShaneBarron\signature-pad;

use Illuminate\Support\ServiceProvider;
use MrShaneBarron\signature-pad\Livewire\signature-pad;
use MrShaneBarron\signature-pad\View\Components\signature-pad as Bladesignature-pad;
use Livewire\Livewire;

class signature-padServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sb-signature-pad.php', 'sb-signature-pad');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sb-signature-pad');

        Livewire::component('sb-signature-pad', signature-pad::class);

        $this->loadViewComponentsAs('ld', [
            Bladesignature-pad::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/sb-signature-pad.php' => config_path('sb-signature-pad.php'),
            ], 'sb-signature-pad-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/sb-signature-pad'),
            ], 'sb-signature-pad-views');
        }
    }
}
