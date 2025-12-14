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
        $this->mergeConfigFrom(__DIR__ . '/../config/ld-signature-pad.php', 'ld-signature-pad');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ld-signature-pad');

        Livewire::component('ld-signature-pad', signature-pad::class);

        $this->loadViewComponentsAs('ld', [
            Bladesignature-pad::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/ld-signature-pad.php' => config_path('ld-signature-pad.php'),
            ], 'ld-signature-pad-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/ld-signature-pad'),
            ], 'ld-signature-pad-views');
        }
    }
}
