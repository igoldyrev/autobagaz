@foreach (($order->checkout_terms['notices'] ?? \App\Support\OrderCheckoutTerms::notices()) as $notice)
    <p class="order-note">{{ $notice }}</p>
@endforeach
