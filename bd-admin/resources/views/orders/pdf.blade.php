<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order #{{ $order->id }} Invoice</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            color:#000; 
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 100px;
            margin-bottom: 10px;
        }
        h2 {
            margin: 0;
            font-size: 18px;
        }
        p {
            margin: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #999;
        }
        th, td {
            padding: 6px 8px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-right { text-align: right; }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <!-- Logo & Invoice Title -->
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo">
        <h2>Order Invoice #{{ $order->id }}</h2>
        <p><small>Date: {{ $order->created_at->format('d M Y, h:i A') }}</small></p>
    </div>

    <!-- Customer Info -->
    <div>
        <p><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
        <p><strong>Phone:</strong> {{ $order->phone }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Address:</strong> {{ $order->address }}, {{ $order->city }}, {{ $order->district }}, {{ $order->postcode }}</p>
        <p><strong>Payment:</strong> {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Paid' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    </div>

    <!-- Order Items Table -->
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Size</th>
                <th>Color</th>
                <th>Qty</th>
                <th>Barcode</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                @php
                    // Base64 product image (PNG only)
                    $imageFile = public_path('storage/products/'.$item->image ?? '');
                    $imageSrc = '';
                    if(file_exists($imageFile)) {
                        $ext = strtolower(pathinfo($imageFile, PATHINFO_EXTENSION));
                        if($ext === 'webp') {
                            $imageFile = str_replace('.webp', '.png', $imageFile);
                        }
                        if(file_exists($imageFile)) {
                            $imageBase64 = base64_encode(file_get_contents($imageFile));
                            $imageSrc = 'data:image/png;base64,'.$imageBase64;
                        }
                    }
                @endphp
                <tr>
                    <td>
                        {{ $item->product_name }}
                        @if($imageSrc)
                            <br>
                            <img src="{{ $imageSrc }}" style="width:50px; height:auto;">
                        @endif
                    </td>
                    <td>{{ $item->size ?? '-' }}</td>
                    <td>{{ $item->color ?? '-' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->barcode ?? '-' }}</td>
                    <td>৳ {{ number_format($item->price, 2) }}</td>
                    <td>৳ {{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right"><strong>Subtotal</strong></td>
                <td>৳ {{ number_format($order->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td colspan="6" class="text-right"><strong>Delivery Charge</strong></td>
                <td>৳ {{ number_format($order->delivery_charge, 2) }}</td>
            </tr>
            <tr>
                <td colspan="6" class="text-right"><strong>Total</strong></td>
                <td><strong>৳ {{ number_format($order->total, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Thank you for shopping with <strong>Khut.shop</strong></p>
        <p><small>This is a computer-generated invoice. No signature required.</small></p>
    </div>
</body>
</html>
