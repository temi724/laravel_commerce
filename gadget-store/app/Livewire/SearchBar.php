<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class SearchBar extends Component
{
    public $query = '';
    public $searchResults;
    public $showDropdown = false;

    protected $listeners = ['hideDropdown' => 'hideDropdown'];

    public function mount()
    {
        $this->searchResults = collect([]);
    }

    public function updatedQuery()
    {
        if (strlen($this->query) >= 2) {
            $this->searchProducts();
            $this->showDropdown = true;
        } else {
            $this->searchResults = collect([]);
            $this->showDropdown = false;
        }
    }

    public function searchProducts()
    {
        $query = Product::query();

        // Apply text search if query exists
        if ($this->query) {
            $query->where(function ($q) {
                $q->where('product_name', 'LIKE', "%{$this->query}%")
                  ->orWhere('description', 'LIKE', "%{$this->query}%")
                  ->orWhere('overview', 'LIKE', "%{$this->query}%")
                  ->orWhere('about', 'LIKE', "%{$this->query}%");
            });
        }

        // If no search query, don't show results
        if (!$this->query) {
            $this->searchResults = collect([]);
            return;
        }

        $this->searchResults = $query->limit(8)->get();
    }

    public function selectProduct($productId)
    {
        // Redirect to product detail page
        return redirect()->route('product.show', $productId);
    }

    public function hideDropdown()
    {
        $this->showDropdown = false;
    }

    public function search()
    {
        if ($this->query) {
            return redirect()->route('search.results', [
                'q' => $this->query
            ]);
        }
    }

    public function render()
    {
        return view('livewire.search-bar');
    }
}
