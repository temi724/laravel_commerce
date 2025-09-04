<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Layout extends Component
{
    public $title;

    /**
     * Create a new component instance.
     */
    public function __construct($title = null)
    {
        $this->title = $title ?? 'Gadget Store - Premium Electronics & Gadgets';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.layout');
    }
}
