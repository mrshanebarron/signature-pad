<?php

namespace MrShaneBarron\SignaturePad;

use Illuminate\Support\ServiceProvider;
use MrShaneBarron\SignaturePad\Livewire\SignaturePad;
use MrShaneBarron\SignaturePad\View\Components\SignaturePad as BladeSignaturePad;

class SignaturePadServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sb-signature-pad.php', 'sb-signature-pad');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sb-signature-pad');

        if (class_exists(\Livewire\Livewire::class)) {
            \Livewire\Livewire::component('sb-signature-pad', SignaturePad::class);
        }

        $this->loadViewComponentsAs('ld', [
            BladeSignaturePad::class,
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
