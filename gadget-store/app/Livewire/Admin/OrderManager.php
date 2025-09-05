<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.admin-layout')]
class OrderManager extends Component
{
    public function render()
    {
        return view('livewire.admin.order-manager');
    }
}
