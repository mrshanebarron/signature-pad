<?php

namespace MrShaneBarron\signature-pad\View\Components;

use Illuminate\View\Component;

class signature-pad extends Component
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
