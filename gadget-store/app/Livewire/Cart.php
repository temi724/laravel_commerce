<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Deal;
use Illuminate\Support\Facades\Log;

class Cart extends Component
{
    public $cartItems = [];
    public $isOpen = false;

    protected $listeners = [
        'addToCart' => 'addToCart',
        'openCart' => 'openCart'
    ];

    public function mount()
    {
        $this->refreshCart();
    }

    public function refreshCart()
    {
        $cart = session()->get('cart', []);
        $this->cartItems = [];

        Log::info('Cart refreshCart called', ['cart' => $cart]);

        foreach ($cart as $itemId => $item) {
            $type = $item['type'] ?? 'product'; // Default to product for backward compatibility
            $quantity = $item['quantity'] ?? 1;
            $selectedStorage = $item['selected_storage'] ?? null;
            $storagePrice = $item['storage_price'] ?? null;

            Log::info('Processing cart item', ['itemId' => $itemId, 'type' => $type, 'quantity' => $quantity, 'selectedStorage' => $selectedStorage, 'storagePrice' => $storagePrice]);

            if ($type === 'deal') {
                $deal = Deal::find($itemId);
                Log::info('Looking for deal', ['itemId' => $itemId, 'deal_found' => $deal ? true : false]);
                if ($deal) {
                    Log::info('Deal found', ['deal_name' => $deal->product_name]);
                    $itemPrice = $storagePrice ?? $deal->price;
                    $this->cartItems[] = [
                        'id' => $deal->id,
                        'type' => 'deal',
                        'name' => $deal->product_name,
                        'price' => $itemPrice,
                        'old_price' => $deal->old_price,
                        'quantity' => $quantity,
                        'image' => $deal->images_url && count($deal->images_url) > 0 ? $deal->images_url[0] : null,
                        'total' => $itemPrice * $quantity,
                        'selected_storage' => $selectedStorage,
                        'storage_price' => $storagePrice
                    ];
                } else {
                    Log::warning('Deal not found in database', ['itemId' => $itemId]);
                }
            } else {
                $product = Product::find($itemId);
                Log::info('Looking for product', ['itemId' => $itemId, 'product_found' => $product ? true : false]);
                if ($product) {
                    Log::info('Product found', ['product_name' => $product->product_name]);
                    $itemPrice = $storagePrice ?? $product->price;
                    $this->cartItems[] = [
                        'id' => $product->id,
                        'type' => 'product',
                        'name' => $product->product_name,
                        'price' => $itemPrice,
                        'quantity' => $quantity,
                        'image' => $product->images_url && count($product->images_url) > 0 ? $product->images_url[0] : null,
                        'total' => $itemPrice * $quantity,
                        'selected_storage' => $selectedStorage,
                        'storage_price' => $storagePrice
                    ];
                } else {
                    Log::warning('Product not found in database', ['itemId' => $itemId]);
                }
            }
        }

        Log::info('Cart refresh completed', ['cartItems_count' => count($this->cartItems)]);
    }

    public function addToCart($itemId, $quantity = 1, $type = 'product', $selectedStorage = null, $storagePrice = null, $selectedColor = null)
    {
        Log::info('CART COMPONENT: addToCart called', ['itemId' => $itemId, 'quantity' => $quantity, 'type' => $type, 'selectedStorage' => $selectedStorage, 'storagePrice' => $storagePrice, 'selectedColor' => $selectedColor]);
        $cart = session()->get('cart', []);
        Log::info('CART COMPONENT: Current cart before add:', ['cart' => $cart]);

        if (isset($cart[$itemId])) {
            $cart[$itemId]['quantity'] += $quantity;
            // Update storage selection if provided
            if ($selectedStorage) {
                $cart[$itemId]['selected_storage'] = $selectedStorage;
            }
            if ($storagePrice) {
                $cart[$itemId]['storage_price'] = $storagePrice;
            }
            if ($selectedColor) {
                $cart[$itemId]['selected_color'] = $selectedColor;
            }
        } else {
            $cart[$itemId] = [
                'quantity' => $quantity,
                'type' => $type
            ];
            // Add storage and color selections if provided
            if ($selectedStorage) {
                $cart[$itemId]['selected_storage'] = $selectedStorage;
            }
            if ($storagePrice) {
                $cart[$itemId]['storage_price'] = $storagePrice;
            }
            if ($selectedColor) {
                $cart[$itemId]['selected_color'] = $selectedColor;
            }
        }

        session(['cart' => $cart]);
        Log::info('Cart after add:', ['cart' => $cart]);
        $this->refreshCart();
        $this->dispatch('$refresh');

        // Get item name for success message
        $itemName = 'Product';
        if ($type === 'deal') {
            $deal = Deal::find($itemId);
            $itemName = $deal ? $deal->product_name : 'Deal';
        } else {
            $product = Product::find($itemId);
            $itemName = $product ? $product->product_name : 'Product';
        }

        $totalItems = $this->getTotalItems();
        Log::info('Dispatching cart-item-added event', [
            'itemId' => $itemId,
            'itemName' => $itemName,
            'count' => $totalItems,
            'cartItems' => count($this->cartItems)
        ]);
        $this->dispatch('cart-item-added', [
            'itemId' => $itemId,
            'itemName' => $itemName,
            'count' => $totalItems,
        ]);
    }

    public function updateQuantity($itemId, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeFromCart($itemId);
            return;
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$itemId])) {
            $cart[$itemId]['quantity'] = $quantity;
            session(['cart' => $cart]);
            $this->refreshCart();
            $this->dispatch('cartCountUpdated', $this->getTotalItems());
        }
    }

    public function increaseQuantity($itemId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$itemId])) {
            $currentQuantity = $cart[$itemId]['quantity'] ?? 1;
            $this->updateQuantity($itemId, $currentQuantity + 1);
        }
    }

    public function decreaseQuantity($itemId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$itemId])) {
            $currentQuantity = $cart[$itemId]['quantity'] ?? 1;
            if ($currentQuantity > 1) {
                $this->updateQuantity($itemId, $currentQuantity - 1);
            }
        }
    }

    public function removeFromCart($itemId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$itemId]);
        session(['cart' => $cart]);
        $this->refreshCart();
        $this->dispatch('cartCountUpdated', $this->getTotalItems());
    }

    public function clearCart()
    {
        session()->forget('cart');
        $this->cartItems = [];
        $this->dispatch('cartCountUpdated', 0);
    }

    public function openCart()
    {
        $this->isOpen = true;
    }

    public function closeCart()
    {
        $this->isOpen = false;
    }

    public function getTotalItems()
    {
        return array_sum(array_column($this->cartItems, 'quantity'));
    }

    public function getTotalPrice()
    {
        return array_sum(array_column($this->cartItems, 'total'));
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
