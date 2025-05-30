<div class="max-w-2xl mx-auto p-6 bg-white dark:bg-gray-800 shadow rounded mt-10">
    <h1 class="text-2xl font-bold text-center mb-4 text-gray-900 dark:text-gray-100">🎉 Thank You for Your Order!</h1>
    <p class="text-center text-gray-600 dark:text-gray-300 mb-6">Here’s a summary of your recent orders:</p>

    @if($orders->isEmpty())
    <p class="text-center text-red-500">No recent orders found.</p>
    @else
    <div class="space-y-4">
        @foreach($orders as $order)
        <div class="border border-gray-300 dark:border-gray-700 rounded p-4 shadow-sm bg-gray-50 dark:bg-gray-700">
            <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100">Order #{{ $order->id }}</h2>
            <p class="text-gray-700 dark:text-gray-300"><span class="font-medium">Total Price:</span> ₱{{
                number_format($order->total_price, 2) }}</p>
            <p class="text-gray-700 dark:text-gray-300"><span class="font-medium">Quantity:</span> {{ $order->quantity
                }}</p>
            <p class="text-gray-700 dark:text-gray-300"><span class="font-medium">Shipping Method:</span> {{
                ucfirst($order->shipping_method) }}</p>
            <p class="text-gray-700 dark:text-gray-300"><span class="font-medium">Status:</span> {{
                ucfirst($order->status) }}</p>
        </div>
        @endforeach
    </div>
    @endif

    <div class="text-center mt-6">
        <a href="{{ route('shop') }}"
            class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            Continue Shopping
        </a>
    </div>
</div>
