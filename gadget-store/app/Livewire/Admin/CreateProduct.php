<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\Deal;
use App\Models\Category;

#[Layout('components.admin-layout')]
class CreateProduct extends Component
{
    // Form fields
    public $product_name = '';
    public $price = '';
    public $category_id = '';
    public $overview = '';
    public $description = '';
    public $about = '';
    public $reviews = '';
    public $what_is_included = '';
    public $in_stock = false;
    public $out_of_stock = false;
    public $images_url = '';
    public $colors = '';
    public $specification = '';
    public $product_status = 'new';
    public $storage_options = [];
    public $has_storage = false;

    // Deal-specific fields
    public $is_deal = false;
    public $old_price = '';
    public $new_price = '';

    protected $rules = [
        'product_name' => 'required|min:3',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'overview' => 'nullable|min:10',
        'description' => 'required|min:10',
        'about' => 'nullable|min:10',
        'reviews' => 'nullable|string',
        'what_is_included' => 'nullable|string',
        'in_stock' => 'nullable|boolean',
        'out_of_stock' => 'nullable|boolean',
        'product_status' => 'required|in:new,uk_used,refurbished',
        'has_storage' => 'boolean',
        'storage_options.*.storage' => 'required_if:has_storage,true|string|min:1',
        'storage_options.*.price' => 'required_if:has_storage,true|numeric|min:0',
        'is_deal' => 'boolean',
        'old_price' => 'required_if:is_deal,true|numeric|min:0|gt:new_price',
        'new_price' => 'required_if:is_deal,true|numeric|min:0',
    ];

    public function mount()
    {
        // Initialize with one empty storage option
        $this->storage_options = [
            ['storage' => '', 'price' => '']
        ];
    }

    public function addStorageOption()
    {
        $this->storage_options[] = ['storage' => '', 'price' => ''];
    }

    public function removeStorageOption($index)
    {
        if (count($this->storage_options) > 1) {
            unset($this->storage_options[$index]);
            $this->storage_options = array_values($this->storage_options);
        }
    }

    public function updatedHasStorage()
    {
        if (!$this->has_storage) {
            $this->storage_options = [];
        } else if (empty($this->storage_options)) {
            $this->storage_options = [
                ['storage' => '', 'price' => '']
            ];
        }
    }

    public function updatedIsDeal()
    {
        if ($this->is_deal) {
            // When deal is enabled, set new_price to current price if available
            if ($this->price) {
                $this->new_price = $this->price;
            }
        } else {
            // Clear deal fields when not a deal
            $this->old_price = '';
            $this->new_price = '';
        }
    }

    public function createProduct()
    {
        $this->validate();

        // Prepare storage options data
        $storageOptionsData = null;
        if ($this->has_storage && !empty($this->storage_options)) {
            $storageOptionsData = array_filter($this->storage_options, function ($option) {
                return !empty(trim($option['storage'])) && !empty(trim($option['price']));
            });
            // Convert prices to numbers
            $storageOptionsData = array_map(function ($option) {
                return [
                    'storage' => trim($option['storage']),
                    'price' => (float) $option['price']
                ];
            }, $storageOptionsData);
        }

        $data = [
            'product_name' => $this->product_name,
            'price' => $this->is_deal ? $this->new_price : $this->price,
            'category_id' => $this->category_id,
            'overview' => $this->overview,
            'description' => $this->description,
            'about' => $this->about,
            'reviews' => $this->reviews ? json_decode($this->reviews, true) : [],
            'what_is_included' => $this->what_is_included ? array_filter(explode("\n", $this->what_is_included)) : [],
            'in_stock' => $this->in_stock && !$this->out_of_stock,
            'images_url' => $this->images_url ? array_filter(explode("\n", $this->images_url)) : [],
            'colors' => $this->colors ? array_map('trim', explode(',', $this->colors)) : [],
            'specification' => $this->specification ? array_filter(explode("\n", $this->specification)) : [],
            'storage_options' => $storageOptionsData,
            'product_status' => $this->product_status,
        ];

        if ($this->is_deal) {
            // Add old_price for deals
            $data['old_price'] = $this->old_price;
            Deal::create($data);
            $message = 'Deal created successfully!';
        } else {
            Product::create($data);
            $message = 'Product created successfully!';
        }

        session()->flash('message', $message);
        return redirect()->route('admin.products');
    }

    public function cancel()
    {
        return redirect()->route('admin.products');
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.admin.create-product', compact('categories'));
    }
}
