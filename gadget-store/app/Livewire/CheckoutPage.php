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
            $selectedStorage = is_array($item) ? ($item['selected_storage'] ?? null) : null;
            $storagePrice = is_array($item) ? ($item['storage_price'] ?? null) : null;
            $selectedColor = is_array($item) ? ($item['selected_color'] ?? null) : null;

            if ($type === 'deal') {
                $deal = Deal::find($itemId);
                if ($deal) {
                    $itemPrice = $storagePrice ?? $deal->price;
                    $this->cartItems[] = [
                        'id' => $deal->id,
                        'type' => 'deal',
                        'name' => $deal->product_name,
                        'price' => $itemPrice,
                        'quantity' => $quantity,
                        'image' => $deal->images_url && count($deal->images_url) > 0 ? $deal->images_url[0] : null,
                        'subtotal' => $itemPrice * $quantity,
                        'selected_storage' => $selectedStorage,
                        'storage_price' => $storagePrice,
                        'selected_color' => $selectedColor
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
                        'storage_price' => $storagePrice,
                        'selected_color' => $selectedColor
                    ];
                    $this->cartTotal += $itemPrice * $quantity;
                    $this->cartCount += $quantity;
                }
            }
        }
    }

    public function generateOrderId()
    {
        // Use the same format as Sales model
        do {
            $orderId = 'ORD-' . date('Ymd') . '-' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (Sales::where('order_id', $orderId)->exists());

        $this->generatedOrderId = $orderId;
    }

    public function updateItemStorage($itemIndex, $storageOption, $storagePrice)
    {
        if (isset($this->cartItems[$itemIndex])) {
            $itemId = $this->cartItems[$itemIndex]['id'];
            $cart = session()->get('cart', []);

            // Update the selected storage and price in session
            if (isset($cart[$itemId])) {
                $cart[$itemId]['selected_storage'] = $storageOption;
                $cart[$itemId]['storage_price'] = $storagePrice;
                session(['cart' => $cart]);

                // Update the current cart items display
                $this->cartItems[$itemIndex]['selected_storage'] = $storageOption;
                $this->cartItems[$itemIndex]['storage_price'] = $storagePrice;
                $this->cartItems[$itemIndex]['price'] = $storagePrice;
                $this->cartItems[$itemIndex]['subtotal'] = $storagePrice * $this->cartItems[$itemIndex]['quantity'];

                // Recalculate cart total
                $this->recalculateCartTotal();

                session()->flash('message', 'Storage option updated successfully!');
            }
        }
    }

    private function recalculateCartTotal()
    {
        $this->cartTotal = 0;
        foreach ($this->cartItems as $item) {
            $this->cartTotal += $item['subtotal'];
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
            // Collect product details from cart items
            $productIds = [];
            $totalQuantity = 0;
            $orderDetails = [];

            foreach ($this->cartItems as $item) {
                $productIds[] = $item['id'];
                $totalQuantity += $item['quantity'];

                // Build detailed order information including storage selection
                $itemDetails = [
                    'id' => $item['id'],
                    'type' => $item['type'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal']
                ];

                // Add storage and color selections if available
                if (!empty($item['selected_storage'])) {
                    $itemDetails['selected_storage'] = $item['selected_storage'];
                }
                if (!empty($item['storage_price'])) {
                    $itemDetails['storage_price'] = $item['storage_price'];
                }
                if (!empty($item['selected_color'])) {
                    $itemDetails['selected_color'] = $item['selected_color'];
                }

                $orderDetails[] = $itemDetails;
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
                'payment_status' => Sales::PAYMENT_PENDING,
                'order_details' => $orderDetails // Store detailed order information including storage selections
            ]);

            Log::info('Sale created successfully', [
                'sale_id' => $sale->id,
                'order_id' => $sale->order_id,
                'username' => $sale->username,
                'total_amount' => $this->cartTotal,
                'product_count' => count($productIds),
                'order_details' => $orderDetails
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
