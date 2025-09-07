<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $sale->order_id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">INVOICE</h1>
                <p class="text-gray-600 mt-2">Invoice #{{ $sale->order_id }}</p>
                <p class="text-gray-600">Date: {{ $sale->created_at->format('F j, Y') }}</p>
            </div>
            <div class="text-right">
                <h2 class="text-2xl font-bold text-blue-600">Gadget Store</h2>
                <p class="text-gray-600">Premium Electronics & Gadgets</p>
                <p class="text-gray-600">Lagos, Nigeria</p>
                <p class="text-gray-600">Phone: 1-800-GADGETS</p>
                <p class="text-gray-600">Email: support@gadgetstore.ng</p>
            </div>
        </div>

        <!-- Customer Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Bill To:</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="font-medium text-gray-900">{{ $sale->username }}</p>
                    <p class="text-gray-600">{{ $sale->emailaddress }}</p>
                    @if($sale->phonenumber)
                        <p class="text-gray-600">{{ $sale->phonenumber }}</p>
                    @endif
                    @if($sale->address)
                        <p class="text-gray-600 mt-2">{{ $sale->address }}</p>
                    @endif
                    @if($sale->city || $sale->state)
                        <p class="text-gray-600">{{ $sale->city }}{{ $sale->city && $sale->state ? ', ' : '' }}{{ $sale->state }}</p>
                    @endif
                </div>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Order Details:</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Order Type:</span>
                        <span class="font-medium capitalize">{{ $sale->order_type }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Payment Status:</span>
                        <span class="font-medium capitalize
                            @if($sale->payment_status === 'completed') text-green-600
                            @elseif($sale->payment_status === 'pending') text-yellow-600
                            @else text-red-600 @endif">
                            {{ ucfirst($sale->payment_status) }}
                        </span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Order Status:</span>
                        <span class="font-medium {{ $sale->order_status ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ $sale->order_status ? 'Completed' : 'Pending' }}
                        </span>
                    </div>
                    @if($sale->payment_method)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Method:</span>
                            <span class="font-medium capitalize">{{ $sale->payment_method }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Items:</h3>
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Item</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Qty</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Unit Price</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $orderDetails = $sale->order_details ?? [];
                            $subtotal = 0;
                        @endphp

                        @if(is_array($orderDetails) && count($orderDetails) > 0)
                            @foreach($orderDetails as $item)
                                @php
                                    $itemPrice = $item['price'] ?? 0;
                                    $itemQuantity = $item['quantity'] ?? 1;
                                    $itemSubtotal = $item['subtotal'] ?? ($itemPrice * $itemQuantity);
                                    $subtotal += $itemSubtotal;
                                @endphp
                                <tr>
                                    <td class="px-4 py-3 border-b">
                                        <div class="font-medium text-gray-900">{{ $item['name'] ?? 'Product' }}</div>
                                        @if(!empty($item['selected_storage']))
                                            <div class="text-sm text-gray-600">Storage: {{ $item['selected_storage'] }}</div>
                                        @endif
                                        @if(!empty($item['selected_color']))
                                            <div class="text-sm text-gray-600">Color: {{ $item['selected_color'] }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center border-b">{{ $itemQuantity }}</td>
                                    <td class="px-4 py-3 text-right border-b">₦{{ number_format($itemPrice, 2) }}</td>
                                    <td class="px-4 py-3 text-right border-b font-medium">₦{{ number_format($itemSubtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <!-- Fallback: if order_details is empty, try to get products from product_ids -->
                            @php
                                $productIds = $sale->product_ids ?? [];
                            @endphp
                            @if(is_array($productIds) && count($productIds) > 0)
                                @foreach($productIds as $productId)
                                    @php
                                        $product = \App\Models\Product::find($productId) ?? \App\Models\Deal::find($productId);
                                        if ($product) {
                                            $itemPrice = $product->display_price ?? $product->price ?? 0;
                                            $itemQuantity = 1; // Default quantity since we don't have this info
                                            $itemTotal = $itemPrice * $itemQuantity;
                                            $subtotal += $itemTotal;
                                        }
                                    @endphp
                                    @if($product)
                                        <tr>
                                            <td class="px-4 py-3 border-b">
                                                <div class="font-medium text-gray-900">{{ $product->product_name ?? 'Product' }}</div>
                                            </td>
                                            <td class="px-4 py-3 text-center border-b">{{ $itemQuantity }}</td>
                                            <td class="px-4 py-3 text-right border-b">₦{{ number_format($itemPrice, 2) }}</td>
                                            <td class="px-4 py-3 text-right border-b font-medium">₦{{ number_format($itemTotal, 2) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                        No order items found
                                    </td>
                                </tr>
                            @endif
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Totals -->
        <div class="flex justify-end mb-8">
            <div class="w-full md:w-1/3">
                <div class="bg-gray-50 p-4 rounded-lg">
                    @php
                        // Use the same calculation as SalesManager getOrderTotal method
                        $calculatedTotal = 0;
                        if (!empty($sale->order_details) && is_array($sale->order_details)) {
                            foreach ($sale->order_details as $item) {
                                $calculatedTotal += $item['subtotal'] ?? 0;
                            }
                        } else if (!empty($sale->product_ids) && is_array($sale->product_ids)) {
                            foreach ($sale->product_ids as $productId) {
                                $product = \App\Models\Product::find($productId) ?? \App\Models\Deal::find($productId);
                                if ($product) {
                                    $calculatedTotal += $product->display_price ?? $product->price ?? 0;
                                }
                            }
                        }

                        // Use the calculated subtotal if we have order details, otherwise use the fallback
                        $finalSubtotal = !empty($sale->order_details) ? $subtotal : $calculatedTotal;
                    @endphp

                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-medium">₦{{ number_format($finalSubtotal, 2) }}</span>
                    </div>
                    @if(!empty($sale->delivery_fee) && $sale->delivery_fee > 0)
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Delivery Fee:</span>
                            <span class="font-medium">₦{{ number_format($sale->delivery_fee, 2) }}</span>
                        </div>
                    @endif
                    <div class="border-t border-gray-200 pt-2 mt-2">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-gray-900">Total:</span>
                            <span class="text-lg font-bold text-blue-600">₦{{ number_format($finalSubtotal + ($sale->delivery_fee ?? 0), 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="border-t border-gray-200 pt-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h4 class="font-semibold text-gray-900 mb-2">Payment Information:</h4>
                    @if($sale->payment_status === 'completed')
                        <p class="text-green-600 font-medium">✓ Payment Completed</p>
                        @if($sale->payment_approved_at)
                            <p class="text-sm text-gray-600">Approved on: {{ $sale->payment_approved_at->format('F j, Y g:i A') }}</p>
                        @endif
                        @if($sale->approved_by_admin)
                            <p class="text-sm text-gray-600">Approved by: {{ $sale->approved_by_admin }}</p>
                        @endif
                    @else
                        <p class="text-yellow-600 font-medium">⏳ Payment Pending</p>
                    @endif
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-2">Order Status:</h4>
                    @if($sale->order_status)
                        <p class="text-green-600 font-medium">✓ Order Completed</p>
                        @if($sale->completed_at)
                            <p class="text-sm text-gray-600">Completed on: {{ $sale->completed_at->format('F j, Y g:i A') }}</p>
                        @endif
                    @else
                        <p class="text-yellow-600 font-medium">⏳ Order Processing</p>
                    @endif
                </div>
            </div>

            <div class="mt-6 text-center text-sm text-gray-600">
                <p>Thank you for your business!</p>
                <p>For questions about this invoice, contact us at support@gadgetstore.ng</p>
            </div>
        </div>

        <!-- Print Button -->
        <div class="no-print mt-8 text-center">
            <button onclick="window.print()" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Invoice
            </button>
            <a href="{{ route('admin.sales') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors ml-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Sales
            </a>
        </div>
    </div>
</body>
</html>
