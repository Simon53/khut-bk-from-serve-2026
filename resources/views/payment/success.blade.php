@extends('layout.app')

@section('title', 'Payment Successful')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#28a745" stroke-width="2" fill="none"/>
                            <path d="M8 12l2 2 4-4" stroke="#28a745" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    @if(isset($order) && $order->payment_method == 'cod')
                        <h2 class="text-success mb-3">Order Placed Successfully!</h2>
                        <p class="text-muted mb-4">Your order has been placed successfully. You will pay cash on delivery. Thank you for your purchase!</p>
                    @else
                        <h2 class="text-success mb-3">Payment Successful!</h2>
                        <p class="text-muted mb-4">Your order has been placed successfully. Thank you for your purchase!</p>
                    @endif
                    
                    @if(isset($order))
                    <div class="alert alert-info text-left">
                        <h5>Order Details:</h5>
                        <p class="mb-1"><strong>Order ID:</strong> #{{ $order->id }}</p>
                        @if($order->transaction_id)
                        <p class="mb-1"><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
                        @endif
                        <p class="mb-1"><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                        <p class="mb-1"><strong>Total Amount:</strong> ৳{{ number_format($order->total, 2) }}</p>
                        @php
                            $status = strtolower($order->status ?? 'pending');
                            $badgeClass = 'badge-secondary';
                            $badgeColor = '#6c757d';
                            if ($status == 'paid') {
                                $badgeClass = 'badge-success';
                                $badgeColor = '#28a745';
                            } elseif ($status == 'pending') {
                                $badgeClass = 'badge-warning';
                                $badgeColor = '#ffc107';
                            } elseif (in_array($status, ['failed', 'canceled', 'cancelled'])) {
                                $badgeClass = 'badge-danger';
                                $badgeColor = '#dc3545';
                            }
                        @endphp
                        <p class="mb-0"><strong>Status:</strong> 
                            <span class="badge {{ $badgeClass }}" style="background-color: {{ $badgeColor }}; color: white; padding: 0.25em 0.6em; border-radius: 0.25rem;">
                                {{ ucfirst($order->status ?? 'Pending') }}
                            </span>
                        </p>
                    </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary mr-2">Continue Shopping</a>
                        @if(isset($order))
                        <a href="{{ route('customer.order.details', $order->id) }}" class="btn btn-outline-secondary">View Order Details</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Clear cart on success
    if (typeof(Storage) !== "undefined") {
        localStorage.removeItem("cart");
        if(typeof updateCartCounts === "function") updateCartCounts();
    }
</script>
@endsection


