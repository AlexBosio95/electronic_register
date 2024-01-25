<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class MenuSezione extends Component
{
    /**
     * Create a new component instance.
     */

    public $pagina;

    public function __construct($pagina)
    {
        $this->pagina = $pagina;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu.menu-sezione');
    }
}
