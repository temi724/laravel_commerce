<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\Category;

#[Layout('components.admin-layout')]
class EditProduct extends Component
{
    public Product $product;

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
    ];

    public function mount(Product $product)
    {
        $this->product = $product;

        // Populate form fields with existing data
        $this->product_name = $product->product_name;
        $this->price = $product->price;
        $this->category_id = $product->category_id;
        $this->overview = $product->overview;
        $this->description = $product->description;
        $this->about = $product->about;
        $this->reviews = $product->reviews ? json_encode($product->reviews) : '';
        $this->what_is_included = is_array($product->what_is_included) ? implode("\n", $product->what_is_included) : $product->what_is_included;
        $this->in_stock = $product->in_stock;
        $this->out_of_stock = !$product->in_stock;
        $this->images_url = is_array($product->images_url) ? implode("\n", $product->images_url) : $product->images_url;

        // Handle colors - extract names if it's an array of objects, otherwise treat as string array
        if (is_array($product->colors)) {
            if (!empty($product->colors) && is_array($product->colors[0])) {
                // Array of objects with 'name' property
                $this->colors = implode(', ', array_column($product->colors, 'name'));
            } else {
                // Simple array of strings
                $this->colors = implode(', ', $product->colors);
            }
        } else {
            $this->colors = $product->colors;
        }

        $this->specification = is_array($product->specification) ? json_encode($product->specification, JSON_PRETTY_PRINT) : $product->specification;
        $this->product_status = $product->product_status;

        // Handle storage options
        $storageOptions = $product->getStorageOptionsAttribute();
        if ($storageOptions && is_array($storageOptions) && !empty($storageOptions)) {
            $this->has_storage = true;
            $this->storage_options = $storageOptions;
        } else {
            $this->has_storage = false;
            $this->storage_options = [['storage' => '', 'price' => '']];
        }
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

    public function updateProduct()
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

        $this->product->update($data);

        session()->flash('message', 'Product updated successfully!');
        return redirect()->route('admin.products');
    }

    public function cancel()
    {
        return redirect()->route('admin.products');
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.admin.edit-product', compact('categories'));
    }
}
