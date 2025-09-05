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
    public $completedPayments = 0;
    public $pendingPayments = 0;
    public $failedRefundedPayments = 0;

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

        // Payment status counts
        $this->completedPayments = Sales::where('payment_status', 'completed')->count();
        $this->pendingPayments = Sales::where('payment_status', 'pending')->count();
        $this->failedRefundedPayments = Sales::whereIn('payment_status', ['failed', 'refunded'])->count();

        // Calculate revenue from order_details in sales where payment is completed
        $completedSales = Sales::where('payment_status', 'completed')->get();
        $this->totalRevenue = 0;

        foreach ($completedSales as $sale) {
            if ($sale->order_details && is_array($sale->order_details)) {
                foreach ($sale->order_details as $item) {
                    $this->totalRevenue += $item['subtotal'] ?? 0;
                }
            }
            // Fallback for older records without order_details
            elseif ($sale->product_ids && is_array($sale->product_ids)) {
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
