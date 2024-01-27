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

    public $first_page;
    public $other_pages;

    public function __construct(string $first_page, array $other_pages)
    {
        $this->first_page = $first_page;
        $this->other_pages = $other_pages;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu.menu-sezione');
    }
}
