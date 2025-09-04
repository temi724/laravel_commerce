<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Deal;
use App\Models\Sales;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutPage extends Component
{
    public $cartItems = [];
    public $cartTotal = 0;
    public $cartCount = 0;

    public $username = '';
    public $email = '';
    public $deliveryOption = 'pickup'; // Default to pickup
    public $location = '';
    public $city = '';
    public $state = '';
    public $phone = '';
    public $paymentMethod = 'bank_transfer'; // Default to bank transfer
    public $showBankModal = false;
    public $generatedOrderId = null;

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $cart = session()->get('cart', []);
        $this->cartItems = [];
        $this->cartTotal = 0;
        $this->cartCount = 0;

        foreach ($cart as $itemId => $item) {
            $quantity = is_array($item) ? ($item['quantity'] ?? 1) : $item;
            $type = is_array($item) ? ($item['type'] ?? 'product') : 'product';

            if ($type === 'deal') {
                $deal = Deal::find($itemId);
                if ($deal) {
                    $this->cartItems[] = [
                        'id' => $deal->id,
                        'type' => 'deal',
                        'name' => $deal->product_name,
                        'price' => $deal->price,
                        'quantity' => $quantity,
                        'image' => $deal->images_url && count($deal->images_url) > 0 ? $deal->images_url[0] : null,
                        'subtotal' => $deal->price * $quantity
                    ];
                    $this->cartTotal += $deal->price * $quantity;
                    $this->cartCount += $quantity;
                }
            } else {
                $product = Product::find($itemId);
                if ($product) {
                    $this->cartItems[] = [
                        'id' => $product->id,
                        'type' => 'product',
                        'name' => $product->product_name,
                        'price' => $product->price,
                        'quantity' => $quantity,
                        'image' => $product->images_url && count($product->images_url) > 0 ? $product->images_url[0] : null,
                        'subtotal' => $product->price * $quantity
                    ];
                    $this->cartTotal += $product->price * $quantity;
                    $this->cartCount += $quantity;
                }
            }
        }
    }

    public function placeOrder()
    {
        Log::info('placeOrder method called', [
            'paymentMethod' => $this->paymentMethod,
            'username' => $this->username,
            'email' => $this->email,
            'deliveryOption' => $this->deliveryOption
        ]);

        $validationRules = [
            'username' => 'required',
            'email' => 'required|email',
            'deliveryOption' => 'required|in:pickup,delivery',
            'phone' => 'required',
            'paymentMethod' => 'required|in:bank_transfer',
        ];

        // Add location fields validation only if delivery is selected
        if ($this->deliveryOption === 'delivery') {
            $validationRules['location'] = 'required';
            $validationRules['city'] = 'required';
            $validationRules['state'] = 'required';
        }

        try {
            $this->validate($validationRules);
            Log::info('Validation passed');
        } catch (\Exception $e) {
            Log::error('Validation failed', ['error' => $e->getMessage()]);
            throw $e;
        }

        // Show the bank transfer modal (only option now)
        Log::info('Bank transfer selected, showing modal');
        $this->generateOrderId();
        $this->showBankModal = true;
    }

    public function processPayment()
    {
        Log::info('processPayment method called', [
            'paymentMethod' => $this->paymentMethod,
            'username' => $this->username,
            'email' => $this->email,
            'deliveryOption' => $this->deliveryOption
        ]);

        $validationRules = [
            'username' => 'required',
            'email' => 'required|email',
            'deliveryOption' => 'required|in:pickup,delivery',
            'phone' => 'required',
            'paymentMethod' => 'required|in:bank_transfer',
        ];

        // Add location fields validation only if delivery is selected
        if ($this->deliveryOption === 'delivery') {
            $validationRules['location'] = 'required';
            $validationRules['city'] = 'required';
            $validationRules['state'] = 'required';
        }

        try {
            $this->validate($validationRules);
            Log::info('Validation passed for processPayment');
        } catch (\Exception $e) {
            Log::error('Validation failed in processPayment', ['error' => $e->getMessage()]);
            throw $e;
        }

        // Show the bank transfer modal (only option now)
        Log::info('Bank transfer selected, showing modal via processPayment');
        $this->generateOrderId();
        $this->showBankModal = true;
    }

    public function generateOrderId()
    {
        // Use the same format as Sales model
        do {
            $orderId = 'ORD-' . date('Ymd') . '-' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (Sales::where('order_id', $orderId)->exists());

        $this->generatedOrderId = $orderId;
    }

    public function confirmPayment()
    {
        $this->createSale();
        $this->showBankModal = false;

        // Clear the cart
        session()->forget('cart');

        // Show success message
        session()->flash('message', 'Order confirmed! Your payment is being processed. We will contact you soon.');

        // Redirect to success page
        return redirect()->route('checkout.success');
    }

    public function closeBankModal()
    {
        $this->showBankModal = false;
    }

    public function createSale()
    {
        try {
            // Collect product IDs from cart items
            $productIds = [];
            $totalQuantity = 0;

            foreach ($this->cartItems as $item) {
                $productIds[] = $item['id'];
                $totalQuantity += $item['quantity'];
            }

            // Create sale record
            $sale = Sales::create([
                'username' => $this->username,
                'emailaddress' => $this->email,
                'phonenumber' => $this->phone,
                'location' => $this->deliveryOption === 'delivery' ? $this->location : 'Pickup from Store - 123 Main Street, Ikeja, Lagos',
                'state' => $this->deliveryOption === 'delivery' ? $this->state : 'Lagos',
                'city' => $this->deliveryOption === 'delivery' ? $this->city : 'Ikeja',
                'product_ids' => $productIds,
                'quantity' => $totalQuantity,
                'order_status' => false, // Not completed yet
                'order_type' => $this->deliveryOption,
                'payment_status' => Sales::PAYMENT_PENDING
            ]);

            Log::info('Sale created successfully', [
                'sale_id' => $sale->id,
                'order_id' => $sale->order_id,
                'username' => $sale->username,
                'total_amount' => $this->cartTotal,
                'product_count' => count($productIds)
            ]);

            return $sale;

        } catch (\Exception $e) {
            Log::error('Failed to create sale', [
                'error' => $e->getMessage(),
                'username' => $this->username,
                'email' => $this->email
            ]);

            session()->flash('error', 'Failed to process order. Please try again.');
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}
