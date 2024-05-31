<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ButtonModifica extends Component
{
    /**
     * Create a new component instance.
     */
    public $presenza;

    public function __construct($presenza)
    {
        $this->presenza = $presenza;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button-modifica');
    }
}
