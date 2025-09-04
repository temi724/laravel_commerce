<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Sales;
use App\Models\Product;
use App\Models\Deal;
use Illuminate\Support\Facades\Log;

#[Layout('components.admin-layout')]
class SalesManager extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all'; // all, pending, completed
    public $paymentFilter = 'all'; // all, pending, completed, failed, refunded
    public $orderTypeFilter = 'all'; // all, pickup, delivery
    public $expandedRows = ''; // Track expanded rows as comma-separated string

    // Confirmation modal properties
    public $showConfirmModal = false;
    public $confirmAction = '';
    public $confirmOrderId = '';
    public $confirmMessage = '';

    protected $paginationTheme = 'tailwind';

    protected $queryString = [
        'expandedRows' => ['except' => ''],
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'paymentFilter' => ['except' => 'all'],
        'orderTypeFilter' => ['except' => 'all'],
    ];

    public function getExpandedRowsArray()
    {
        return $this->expandedRows ? explode(',', $this->expandedRows) : [];
    }

    public function mount()
    {
        // Force complete initialization
        $this->initializeComponent();

        Log::info('SalesManager component mounted - state initialized');
    }

    public function hydrate()
    {
        // This runs every time the component is rehydrated (after page load/navigation)
        Log::info('SalesManager hydrating - expanded rows: ' . count($this->getExpandedRowsArray()));

        // Do not reset component state during hydrate - query string handles persistence
        Log::info('SalesManager hydrated - expanded rows state preserved via query string');
    }

    public function boot()
    {
        // This runs on every request - ensure clean state
        // Avoid initializing component here; initialization happens in mount() to preserve transient modal state.
    }

    private function initializeComponent()
    {
        // Initialize with empty arrays - query string will handle persistence
        $this->expandedRows = '';
        $this->showConfirmModal = false;
        $this->confirmAction = '';
        $this->confirmOrderId = '';
        $this->confirmMessage = '';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingPaymentFilter()
    {
        $this->resetPage();
    }

    public function updatingOrderTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingPaginators()
    {
        // This method is called when pagination changes
        Log::info('Pagination updating');
    }

    public function updatedPaginators()
    {
        // This method is called after pagination changes
        Log::info('Pagination updated');
    }

    public function updatedPage()
    {
        // This method is called when the page property changes
        Log::info('Page updated');
    }

    public function debugState()
    {
        Log::info('Debug State - expandedRows: ' . count($this->getExpandedRowsArray()));
        Log::info('Debug State - showConfirmModal: ' . ($this->showConfirmModal ? 'true' : 'false'));

        session()->flash('message', 'Debug info logged. Check application log.');
    }

    public function toggleExpanded($orderId)
    {
        $orderId = (string) $orderId;
        $rows = $this->getExpandedRowsArray();
        if (in_array($orderId, $rows)) {
            $rows = array_diff($rows, [$orderId]);
        } else {
            $rows[] = $orderId;
        }
        $this->expandedRows = implode(',', $rows);
    }

    public function resetModalState()
    {
        $this->expandedRows = '';
        $this->showConfirmModal = false;
        $this->confirmAction = '';
        $this->confirmOrderId = '';
        $this->confirmMessage = '';
        Log::info('Modal state reset');
    }

    public function confirmPaymentStatusUpdate($orderId)
    {
        $this->confirmOrderId = $orderId;
        $this->confirmAction = 'payment_status';
        $this->confirmMessage = 'Are you sure you want to mark this order as paid? This action cannot be undone.';
        $this->showConfirmModal = true;
    }

    public function confirmOrderStatusUpdate($orderId)
    {
        $this->confirmOrderId = $orderId;
        $this->confirmAction = 'order_status';
        $this->confirmMessage = 'Are you sure you want to mark this order as completed?';
        $this->showConfirmModal = true;
    }

    public function cancelConfirmation()
    {
        $this->showConfirmModal = false;
        $this->confirmAction = '';
        $this->confirmOrderId = '';
        $this->confirmMessage = '';
    }

    public function executeConfirmedAction()
    {
        try {
            if ($this->confirmAction === 'payment_status') {
                $this->updatePaymentStatus($this->confirmOrderId, 'completed');
            } elseif ($this->confirmAction === 'order_status') {
                $this->updateOrderStatus($this->confirmOrderId, true);
            }

            // If modal is open for the same order, refresh the data (no longer needed with expandable rows)
            // The table will automatically refresh with updated data

            $this->cancelConfirmation();

            // Force re-render to update all data
            $this->emitSelf('$refresh');

        } catch (\Exception $e) {
            Log::error('Error in executeConfirmedAction: ' . $e->getMessage());
            session()->flash('error', 'Failed to update order.');
            $this->cancelConfirmation();
        }
    }

    public function updateOrderStatus($orderId, $status)
    {
        try {
            // Check if trying to complete order without payment being completed first
            $sale = Sales::find($orderId);
            if (!$sale) {
                session()->flash('error', 'Order not found.');
                return;
            }

            if ($status && $sale->payment_status !== 'completed') {
                session()->flash('error', 'Order cannot be marked as completed until payment is marked as paid first.');
                return;
            }

            $adminName = session('admin_name', 'Admin'); // Get admin name from session

            if ($status) {
                // Mark order as completed with admin name
                $sale->markOrderAsCompleted($adminName);
                session()->flash('message', 'Order marked as completed successfully!');
            } else {
                $sale->update(['order_status' => $status]);
                session()->flash('message', 'Order status updated successfully!');
            }

            // Update the order data (no longer needed with expandable rows)
            // The table will automatically refresh with updated data

            // Force a full page refresh to ensure all data is up to date
            $this->emitSelf('$refresh');

        } catch (\Exception $e) {
            Log::error('Error updating order status: ' . $e->getMessage());
            session()->flash('error', 'Failed to update order status.');
        }
    }

    public function updatePaymentStatus($orderId, $status)
    {
        try {
            $sale = Sales::find($orderId);
            if ($sale) {
                $adminName = session('admin_name', 'Admin'); // Get admin name from session

                if ($status === 'completed') {
                    // Mark payment as completed with admin name and timestamp
                    $sale->markAsCompleted($adminName);
                } else {
                    $sale->update(['payment_status' => $status]);
                }

                session()->flash('message', 'Payment status updated successfully!');

                // Update the order data (no longer needed with expandable rows)
                // The table will automatically refresh with updated data

                Log::info('Payment status updated for order: ' . $orderId . ' to: ' . $status);
            } else {
                Log::error('Order not found for payment update: ' . $orderId);
                session()->flash('error', 'Order not found.');
            }
        } catch (\Exception $e) {
            Log::error('Error updating payment status: ' . $e->getMessage());
            session()->flash('error', 'Failed to update payment status.');
        }
    }

    public function canCompleteOrder($sale)
    {
        return $sale->payment_status === 'completed';
    }

    public function getOrderProducts($productIds)
    {
        if (!$productIds || !is_array($productIds)) {
            return collect();
        }

        $products = collect();

        foreach ($productIds as $productId) {
            $product = Product::find($productId);
            if ($product) {
                $product->type = 'product';
                $products->push($product);
            } else {
                $deal = Deal::find($productId);
                if ($deal) {
                    $deal->type = 'deal';
                    $products->push($deal);
                }
            }
        }

        return $products;
    }

    public function calculateOrderTotal($productIds)
    {
        $total = 0;
        $products = $this->getOrderProducts($productIds);

        foreach ($products as $product) {
            $total += $product->price;
        }

        return $total;
    }

    public function render()
    {
        // Log render state
        Log::info('SalesManager rendering - expandedRows: ' . count($this->getExpandedRowsArray()));

        $query = Sales::query();

        // Apply search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('username', 'like', '%' . $this->search . '%')
                  ->orWhere('emailaddress', 'like', '%' . $this->search . '%')
                  ->orWhere('order_id', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter
        if ($this->statusFilter !== 'all') {
            $query->where('order_status', $this->statusFilter === 'completed');
        }

        // Apply payment filter
        if ($this->paymentFilter !== 'all') {
            $query->where('payment_status', $this->paymentFilter);
        }

        // Apply order type filter
        if ($this->orderTypeFilter !== 'all') {
            $query->where('order_type', $this->orderTypeFilter);
        }

        $sales = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('livewire.admin.sales-manager', [
            'sales' => $sales
        ]);
    }
}
