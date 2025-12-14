<?php

namespace MrShaneBarron\SignaturePad\Livewire;

use Livewire\Component;
use Livewire\Attributes\Modelable;

class SignaturePad extends Component
{
    #[Modelable]
    public ?string $signature = null;
    
    public int $width = 400;
    public int $height = 200;
    public string $strokeColor = '#000000';
    public int $strokeWidth = 2;
    public string $backgroundColor = '#ffffff';

    public function mount(
        ?string $signature = null,
        int $width = 400,
        int $height = 200,
        string $strokeColor = '#000000',
        int $strokeWidth = 2,
        string $backgroundColor = '#ffffff'
    ): void {
        $this->signature = $signature;
        $this->width = $width;
        $this->height = $height;
        $this->strokeColor = $strokeColor;
        $this->strokeWidth = $strokeWidth;
        $this->backgroundColor = $backgroundColor;
    }

    public function clear(): void
    {
        $this->signature = null;
        $this->dispatch('signature-cleared');
    }

    public function render()
    {
        return view('ld-signature-pad::livewire.signature-pad');
    }
}
