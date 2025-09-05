<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Deal;
use Illuminate\Support\Facades\Log;

class CartPage extends Component
{
    public $cartItems = [];
    public $cartTotal = 0;
    public $cartCount = 0;

    protected $listeners = [
        'cartUpdated' => '$refresh',
        'refreshCart' => '$refresh'
    ];

    public function mount()
    {
        Log::info('CartPage mounting, current session cart:', ['cart' => session()->get('cart', [])]);
        $this->migrateCartFormat();
        $this->loadCart();
        Log::info('CartPage mounted, final cart count:', ['count' => $this->cartCount]);
    }

    private function migrateCartFormat()
    {
        $cart = session()->get('cart', []);
        $needsUpdate = false;

        foreach ($cart as $itemId => $item) {
            if (!is_array($item)) {
                // Convert old integer format to new array format
                $cart[$itemId] = ['quantity' => $item, 'type' => 'product'];
                $needsUpdate = true;
            } elseif (!isset($item['type'])) {
                // Add type field if missing
                $cart[$itemId]['type'] = 'product';
                $needsUpdate = true;
            }
        }

        if ($needsUpdate) {
            session()->put('cart', $cart);
        }
    }

    public function loadCart()
    {
        $cart = session()->get('cart', []);
        $this->cartItems = [];
        $this->cartTotal = 0;
        $this->cartCount = 0;

        Log::info('CartPage loadCart called', ['cart' => $cart]);

        foreach ($cart as $itemId => $item) {
            // Handle both old format (integer) and new format (array)
            $quantity = is_array($item) ? ($item['quantity'] ?? 1) : $item;
            $type = is_array($item) ? ($item['type'] ?? 'product') : 'product';
            $selectedStorage = is_array($item) ? ($item['selected_storage'] ?? null) : null;
            $storagePrice = is_array($item) ? ($item['storage_price'] ?? null) : null;

            if ($type === 'deal') {
                $deal = Deal::find($itemId);
                if ($deal) {
                    $itemPrice = $storagePrice ?? $deal->price;
                    $this->cartItems[] = [
                        'id' => $deal->id,
                        'type' => 'deal',
                        'name' => $deal->product_name,
                        'price' => $itemPrice,
                        'old_price' => $deal->old_price,
                        'quantity' => $quantity,
                        'image' => $deal->images_url && count($deal->images_url) > 0 ? $deal->images_url[0] : null,
                        'subtotal' => $itemPrice * $quantity,
                        'selected_storage' => $selectedStorage,
                        'storage_price' => $storagePrice
                    ];
                    $this->cartTotal += $itemPrice * $quantity;
                    $this->cartCount += $quantity;
                }
            } else {
                $product = Product::find($itemId);
                if ($product) {
                    $itemPrice = $storagePrice ?? $product->display_price;
                    $this->cartItems[] = [
                        'id' => $product->id,
                        'type' => 'product',
                        'name' => $product->product_name,
                        'price' => $itemPrice,
                        'quantity' => $quantity,
                        'image' => $product->images_url && count($product->images_url) > 0 ? $product->images_url[0] : null,
                        'subtotal' => $itemPrice * $quantity,
                        'selected_storage' => $selectedStorage,
                        'storage_price' => $storagePrice
                    ];
                    $this->cartTotal += $itemPrice * $quantity;
                    $this->cartCount += $quantity;
                }
            }
        }

        Log::info('CartPage loadCart completed', [
            'cartItems_count' => count($this->cartItems),
            'cartTotal' => $this->cartTotal,
            'cartCount' => $this->cartCount
        ]);
    }

    public function updateQuantity($itemId, $quantity)
    {
        Log::info('CartPage updateQuantity called', [
            'itemId' => $itemId,
            'quantity' => $quantity,
            'current_cart' => session()->get('cart', [])
        ]);

        if ($quantity <= 0) {
            $this->removeFromCart($itemId);
            return;
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$itemId])) {
            $cart[$itemId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        Log::info('CartPage updated cart', ['cart' => $cart]);

        $this->loadCart();
        $this->dispatch('cartCountUpdated', $this->cartCount);
        $this->dispatch('cartUpdated');
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
        Log::info('CartPage removeFromCart called', [
            'itemId' => $itemId,
            'current_cart' => session()->get('cart', [])
        ]);

        $cart = session()->get('cart', []);
        unset($cart[$itemId]);
        session()->put('cart', $cart);

        Log::info('CartPage item removed', ['cart' => $cart]);

        $this->loadCart();
        $this->dispatch('cartCountUpdated', $this->cartCount);
        $this->dispatch('cartUpdated');
    }

    public function clearCart()
    {
        session()->forget('cart');
        $this->loadCart();
        $this->dispatch('cartCountUpdated', 0);
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}
