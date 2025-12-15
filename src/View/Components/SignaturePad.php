<?php

namespace MrShaneBarron\SignaturePad\View\Components;

use Illuminate\View\Component;

class SignaturePad extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        return view('sb-signature-pad::components.signature-pad');
    }
}
