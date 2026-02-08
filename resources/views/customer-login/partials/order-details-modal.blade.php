<div>
    <div class="mb-3">
        <h5 class="mb-3">Order #{{ $order->id }}</h5>
        <div class="row mb-3">
            <div class="col-md-6">
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
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                <p class="mb-1"><strong>Total:</strong> <strong class="text-primary">৳{{ number_format($order->total, 2) }}</strong></p>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="thead-light">
                <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th class="text-center">Qty</th>
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
                    <td class="text-right"><strong>৳{{ number_format($order->total, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    @if($order->address)
    <div class="mt-3">
        <h6>Delivery Address:</h6>
        <p class="mb-0">{{ $order->address }}{{ $order->apartment ? ', ' . $order->apartment : '' }}, {{ $order->city }}{{ $order->district ? ', ' . $order->district : '' }}{{ $order->postcode ? ' - ' . $order->postcode : '' }}</p>
    </div>
    @endif

    @if($order->notes)
    <div class="mt-3">
        <h6>Notes:</h6>
        <p class="mb-0">{{ $order->notes }}</p>
    </div>
    @endif
</div>

