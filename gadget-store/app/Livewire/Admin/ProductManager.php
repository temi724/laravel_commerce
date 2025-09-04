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
    public $showCreateModal = false;
    public $showEditModal = false;
    public $editingProduct = null;

    // Form fields
    public $product_name = '';
    public $price = '';
    public $category_id = '';
    public $description = '';
    public $images_url = '';
    public $colors = '';
    public $specification = '';

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'product_name' => 'required|min:3',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'description' => 'required|min:10',
    ];

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
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
    }

    public function openEditModal($id, $type = 'product')
    {
        if ($type === 'deal') {
            $this->editingProduct = Deal::find($id);
        } else {
            $this->editingProduct = Product::find($id);
        }

        if ($this->editingProduct) {
            $this->product_name = $this->editingProduct->product_name;
            $this->price = $this->editingProduct->price;
            $this->category_id = $this->editingProduct->category_id;
            $this->description = $this->editingProduct->description ?? '';
            $this->images_url = is_array($this->editingProduct->images_url) ? implode("\n", $this->editingProduct->images_url) : '';
            $this->colors = is_array($this->editingProduct->colors) ? implode(', ', $this->editingProduct->colors) : '';
            $this->specification = is_array($this->editingProduct->specification) ? implode("\n", $this->editingProduct->specification) : '';

            $this->showEditModal = true;
        }
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingProduct = null;
        $this->resetForm();
    }

    public function createProduct()
    {
        $this->validate();

        $data = [
            'product_name' => $this->product_name,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'images_url' => $this->images_url ? array_filter(explode("\n", $this->images_url)) : [],
            'colors' => $this->colors ? array_map('trim', explode(',', $this->colors)) : [],
            'specification' => $this->specification ? array_filter(explode("\n", $this->specification)) : [],
        ];

        Product::create($data);

        session()->flash('message', 'Product created successfully!');
        $this->closeCreateModal();
    }

    public function updateProduct()
    {
        $this->validate();

        if ($this->editingProduct) {
            $data = [
                'product_name' => $this->product_name,
                'price' => $this->price,
                'category_id' => $this->category_id,
                'description' => $this->description,
                'images_url' => $this->images_url ? array_filter(explode("\n", $this->images_url)) : [],
                'colors' => $this->colors ? array_map('trim', explode(',', $this->colors)) : [],
                'specification' => $this->specification ? array_filter(explode("\n", $this->specification)) : [],
            ];

            $this->editingProduct->update($data);

            session()->flash('message', 'Product updated successfully!');
            $this->closeEditModal();
        }
    }

    public function deleteProduct($id, $type = 'product')
    {
        if ($type === 'deal') {
            Deal::find($id)->delete();
            session()->flash('message', 'Deal deleted successfully!');
        } else {
            Product::find($id)->delete();
            session()->flash('message', 'Product deleted successfully!');
        }
    }

    private function resetForm()
    {
        $this->product_name = '';
        $this->price = '';
        $this->category_id = '';
        $this->description = '';
        $this->images_url = '';
        $this->colors = '';
        $this->specification = '';
        $this->resetValidation();
    }

    public function render()
    {
        $perPage = 10;

        if ($this->selectedType === 'products') {
            $items = Product::with('category')
                ->when($this->search, fn($q) => $q->where('product_name', 'like', '%' . $this->search . '%'))
                ->paginate($perPage);

            // Add type to each item
            $items->getCollection()->transform(function ($product) {
                $product->type = 'product';
                return $product;
            });
        } elseif ($this->selectedType === 'deals') {
            $items = Deal::when($this->search, fn($q) => $q->where('product_name', 'like', '%' . $this->search . '%'))
                ->paginate($perPage);

            // Add type to each item
            $items->getCollection()->transform(function ($deal) {
                $deal->type = 'deal';
                return $deal;
            });
        } else { // 'all'
            // For combined results, we need to handle this differently
            // Get products
            $products = Product::with('category')
                ->when($this->search, fn($q) => $q->where('product_name', 'like', '%' . $this->search . '%'))
                ->get()
                ->map(function ($product) {
                    $product->type = 'product';
                    return $product;
                });

            // Get deals
            $deals = Deal::when($this->search, fn($q) => $q->where('product_name', 'like', '%' . $this->search . '%'))
                ->get()
                ->map(function ($deal) {
                    $deal->type = 'deal';
                    return $deal;
                });

            // Combine and sort
            $allItems = $products->merge($deals)->sortByDesc('created_at');

            // Manual pagination for combined results
            $currentPage = $this->getPage();
            $items = new \Illuminate\Pagination\LengthAwarePaginator(
                $allItems->forPage($currentPage, $perPage),
                $allItems->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'pageName' => 'page']
            );
        }

        return view('livewire.admin.product-manager', [
            'items' => $items,
            'categories' => Category::all()
        ]);
    }
}
