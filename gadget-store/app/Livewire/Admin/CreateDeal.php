<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Deal;
use App\Models\Category;

#[Layout('components.admin-layout')]
class CreateDeal extends Component
{
    // Form fields
    public $product_name = '';
    public $price = '';
    public $old_price = '';
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

    protected $rules = [
        'product_name' => 'required|min:3',
        'price' => 'required|numeric|min:0',
        'old_price' => 'nullable|numeric|min:0',
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

    public function createDeal()
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
            'price' => $this->price,
            'old_price' => $this->old_price,
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

        Deal::create($data);

        session()->flash('message', 'Deal created successfully!');
        return redirect()->route('admin.products');
    }

    public function cancel()
    {
        return redirect()->route('admin.products');
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.admin.create-deal', compact('categories'));
    }
}
