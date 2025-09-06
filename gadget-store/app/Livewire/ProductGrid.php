<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

class ProductGrid extends Component
{
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 12;
    public $selectedCategory = '';
    public $minPrice = '';
    public $maxPrice = '';
    public $productStatus = '';
    public $searchQuery = '';
    public $page = 1;
    public $hasMore = true;
    public $products = [];

    protected $listeners = [
        'categorySelected' => 'filterByCategory',
        'refresh' => '$refresh',
        'loadMore' => 'loadMore',
        'addToCart' => 'addToCart'
    ];

    public function mount()
    {
        // Set search query from URL parameter
        $this->searchQuery = request('q', '');

        // Set category from URL parameter
        $this->selectedCategory = request('category_id', '');

        // Load initial products
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $query = $this->buildQuery();

        $newProducts = $query->skip(($this->page - 1) * $this->perPage)
                           ->take($this->perPage)
                           ->get();

        if ($this->page === 1) {
            $this->products = $newProducts->toArray();
        } else {
            $this->products = array_merge($this->products, $newProducts->toArray());
        }

        $this->hasMore = $newProducts->count() === $this->perPage;
    }

    public function loadMore()
    {
        if ($this->hasMore) {
            $this->page++;
            $this->loadProducts();
        }
    }

    private function buildQuery()
    {
        $query = Product::query();

        // Apply filters
        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        if ($this->minPrice) {
            $query->where('price', '>=', $this->minPrice);
        }

        if ($this->maxPrice) {
            $query->where('price', '<=', $this->maxPrice);
        }

        if ($this->productStatus) {
            $query->where('product_status', $this->productStatus);
        }

        if ($this->searchQuery) {
            $query->where(function ($q) {
                $q->where('product_name', 'LIKE', "%{$this->searchQuery}%")
                  ->orWhere('description', 'LIKE', "%{$this->searchQuery}%")
                  ->orWhere('overview', 'LIKE', "%{$this->searchQuery}%")
                  ->orWhere('about', 'LIKE', "%{$this->searchQuery}%");
            });
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query->with('category');
    }    public function filterByCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->resetProducts();
    }

    public function updatedSelectedCategory()
    {
        $this->resetProducts();
    }

    public function updatedMinPrice()
    {
        $this->resetProducts();
    }

    public function updatedMaxPrice()
    {
        $this->resetProducts();
    }

    public function updatedProductStatus()
    {
        $this->resetProducts();
    }

    private function resetProducts()
    {
        $this->page = 1;
        $this->products = [];
        $this->hasMore = true;
        $this->loadProducts();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortBy = $field;
        $this->resetProducts();
    }

    public function clearFilters()
    {
        $this->selectedCategory = '';
        $this->minPrice = '';
        $this->maxPrice = '';
        $this->productStatus = '';
        $this->resetProducts();
    }

    public function addToCart($productId)
    {
        // Dispatch Livewire event to the Cart component
        $this->dispatch('addToCart', $productId);
    }

    public function render()
    {
        $categories = Category::all();

        // Get total count for display
        $totalCount = $this->buildQuery()->count();

        return view('livewire.product-grid', [
            'categories' => $categories,
            'totalCount' => $totalCount,
            'displayedCount' => count($this->products)
        ]);
    }
}
