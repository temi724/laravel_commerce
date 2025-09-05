<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\Deal;
use App\Models\Category;

#[Layout('components.admin-layout')]
class ProductManager extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedType = 'all'; // all, products, deals

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedType()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        return redirect()->route('admin.products.create');
    }

    public function testLivewire()
    {
        session()->flash('message', 'Livewire is working! Button clicked successfully.');
    }

    public function editProduct($id)
    {
        // Add debugging
        session()->flash('message', 'Edit button clicked for product ID: ' . $id);

        // Check if product exists
        $product = Product::find($id);
        if (!$product) {
            session()->flash('error', 'Product not found with ID: ' . $id);
            return;
        }

        return redirect()->route('admin.products.edit', $id);
    }

    public function deleteProduct($id, $type = 'product')
    {
        if ($type === 'deal') {
            $deal = Deal::find($id);
            if ($deal) {
                $deal->delete();
                session()->flash('message', 'Deal deleted successfully!');
            }
        } else {
            $product = Product::find($id);
            if ($product) {
                $product->delete();
                session()->flash('message', 'Product deleted successfully!');
            }
        }
    }

    public function render()
    {
        $query = collect();

        if ($this->selectedType === 'products') {
            $query = Product::query();
        } elseif ($this->selectedType === 'deals') {
            $query = Deal::query();
        } else {
            // Combine both products and deals
            $products = Product::query();
            $deals = Deal::query();

            if ($this->search) {
                $products = $products->where('product_name', 'like', '%' . $this->search . '%');
                $deals = $deals->where('product_name', 'like', '%' . $this->search . '%');
            }

            // Get paginated results
            $products = $products->paginate(10, ['*'], 'page');
            $deals = $deals->get();

            // Combine results
            $combinedItems = collect($products->items())->merge($deals);

            return view('livewire.admin.product-manager', [
                'items' => $combinedItems,
                'pagination' => $products
            ]);
        }

        if ($this->search) {
            $query = $query->where('product_name', 'like', '%' . $this->search . '%');
        }

        $items = $query->paginate(10);

        return view('livewire.admin.product-manager', [
            'items' => $items,
            'pagination' => $items
        ]);
    }
}
