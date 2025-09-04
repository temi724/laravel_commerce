<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\Deal;
use App\Models\Sales;
use App\Models\Category;

#[Layout('components.admin-layout')]
class Dashboard extends Component
{
    public $currentTab = 'overview';

    // Stats properties
    public $totalProducts = 0;
    public $totalDeals = 0;
    public $totalSales = 0;
    public $totalRevenue = 0;
    public $pendingOrders = 0;
    public $completedOrders = 0;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->totalProducts = Product::count();
        $this->totalDeals = Deal::count();
        $this->totalSales = Sales::count();
        $this->pendingOrders = Sales::where('order_status', false)->count();
        $this->completedOrders = Sales::where('order_status', true)->count();

        // Calculate revenue from products in sales
        $sales = Sales::all();
        $this->totalRevenue = 0;

        foreach ($sales as $sale) {
            if ($sale->product_ids && is_array($sale->product_ids)) {
                foreach ($sale->product_ids as $productId) {
                    $product = Product::find($productId);
                    if ($product) {
                        $this->totalRevenue += $product->price;
                    } else {
                        // Check if it's a deal
                        $deal = Deal::find($productId);
                        if ($deal) {
                            $this->totalRevenue += $deal->price;
                        }
                    }
                }
            }
        }
    }

    public function setTab($tab)
    {
        $this->currentTab = $tab;
        $this->loadStats(); // Refresh stats when switching tabs
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
