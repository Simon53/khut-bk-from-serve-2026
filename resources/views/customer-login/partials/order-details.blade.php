@extends('layout.app')

@section('title', 'Order Details')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <!-- Header Section -->
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="#007bff" stroke-width="2" fill="none"/>
                                <path d="M9 12l2 2 4-4" stroke="#007bff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h2 class="text-primary mb-2">Order Details</h2>
                        <p class="text-muted">Order #{{ $order->id }}</p>
                    </div>

                    <!-- Order Information -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="alert alert-light border">
                                <h6 class="text-muted mb-2">Order Information</h6>
                                <p class="mb-1"><strong>Order ID:</strong> #{{ $order->id }}</p>
                                <p class="mb-1"><strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                                <p class="mb-1"><strong>Status:</strong> 
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
                                    <span class="badge {{ $badgeClass }}" style="background-color: {{ $badgeColor }}; color: white; padding: 0.25em 0.6em; border-radius: 0.25rem;">
                                        {{ ucfirst($order->status ?? 'Pending') }}
                                    </span>
                                </p>
                                @if($order->transaction_id)
                                <p class="mb-0"><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="alert alert-light border">
                                <h6 class="text-muted mb-2">Payment & Delivery</h6>
                                <p class="mb-1"><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                                <p class="mb-1"><strong>Delivery Status:</strong> 
                                    @php
                                        $deliveryStatus = strtolower($order->delivery_status ?? 'pending');
                                        $deliveryBadgeClass = 'badge-info';
                                        $deliveryBadgeColor = '#17a2b8';
                                        if ($deliveryStatus == 'delivered') {
                                            $deliveryBadgeClass = 'badge-success';
                                            $deliveryBadgeColor = '#28a745';
                                        } elseif ($deliveryStatus == 'shipped') {
                                            $deliveryBadgeClass = 'badge-primary';
                                            $deliveryBadgeColor = '#007bff';
                                        } elseif (in_array($deliveryStatus, ['cancelled', 'returned'])) {
                                            $deliveryBadgeClass = 'badge-danger';
                                            $deliveryBadgeColor = '#dc3545';
                                        }
                                    @endphp
                                    <span class="badge {{ $deliveryBadgeClass }}" style="background-color: {{ $deliveryBadgeColor }}; color: white; padding: 0.25em 0.6em; border-radius: 0.25rem;">
                                        {{ ucfirst($order->delivery_status ?? 'Pending') }}
                                    </span>
                                    </p>
                                @if($order->delivery_charge > 0 && $order->payment_method == 'card')
                                <p class="mb-1"><strong>Delivery Charge:</strong> ৳{{ number_format($order->delivery_charge, 2) }}</p>
                                @endif
                                <p class="mb-0"><strong>Total Amount:</strong> <span class="h5 text-primary">৳{{ number_format($order->total, 2) }}</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    @if($order->first_name || $order->email)
                    <div class="alert alert-info mb-4">
                        <h6 class="mb-3">Customer Information</h6>
                        <div class="row">
                            @if($order->first_name)
                            <div class="col-md-6 mb-2">
                                <strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}
                            </div>
                            @endif
                            @if($order->email)
                            <div class="col-md-6 mb-2">
                                <strong>Email:</strong> {{ $order->email }}
                            </div>
                            @endif
                            @if($order->phone)
                            <div class="col-md-6 mb-2">
                                <strong>Phone:</strong> {{ $order->phone }}
                            </div>
                            @endif
                            @if($order->address)
                            <div class="col-md-12 mb-2">
                                <strong>Address:</strong> {{ $order->address }}{{ $order->apartment ? ', ' . $order->apartment : '' }}, {{ $order->city }}{{ $order->district ? ', ' . $order->district : '' }}{{ $order->postcode ? ' - ' . $order->postcode : '' }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Order Items -->
                    <div class="mb-4">
                        <h5 class="mb-3">Order Items</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Price</th>
                                        <th class="text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>
                                                <strong>{{ $item->product_name }}</strong>
                                                @if($item->barcode)
                                                <br><small class="text-muted">Barcode: {{ $item->barcode }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $item->size ?? '-' }}</td>
                                            <td>{{ $item->color ?? '-' }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-right">৳{{ number_format($item->price, 2) }}</td>
                                            <td class="text-right"><strong>৳{{ number_format($item->subtotal, 2) }}</strong></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-right"><strong>Subtotal:</strong></td>
                                        <td class="text-right"><strong>৳{{ number_format($order->subtotal, 2) }}</strong></td>
                                    </tr>
                                    @if($order->delivery_charge > 0)
                                    <tr>
                                        <td colspan="5" class="text-right"><strong>Delivery Charge:</strong></td>
                                        <td class="text-right"><strong>৳{{ number_format($order->delivery_charge, 2) }}</strong></td>
                                    </tr>
                                    @endif
                                    <tr class="table-primary">
                                        <td colspan="5" class="text-right"><strong>Total:</strong></td>
                                        <td class="text-right"><strong class="h5">৳{{ number_format($order->total, 2) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($order->notes)
                    <div class="alert alert-secondary">
                        <h6 class="mb-2">Order Notes:</h6>
                        <p class="mb-0">{{ $order->notes }}</p>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary mr-2">Continue Shopping</a>
                        @auth('customer')
                        <a href="{{ route('customer.profile') }}" class="btn btn-outline-secondary">My Account</a>
                        @else
                        <a href="{{ route('customer.login') }}" class="btn btn-outline-secondary">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
