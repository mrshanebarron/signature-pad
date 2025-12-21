<?php

namespace MrShaneBarron\SignaturePad\Livewire;

use Livewire\Component;

class SignaturePad extends Component
{
    public int $width = 400;
    public int $height = 200;
    public string $strokeColor = '#000000';
    public int $strokeWidth = 2;
    public string $backgroundColor = '#ffffff';
    public ?string $signature = null;

    public function render()
    {
        return view('sb-signature-pad::livewire.signature-pad');
    }
}
