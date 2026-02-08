<table class="table table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>#ID</th>
            <th>Customer</th>
            <th>Phone</th>
            <th>Total</th>
            <th>Status</th>
            <th>Payment</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr id="orderRow{{ $order->id }}">
            <td>{{ $order->id }}</td>
            <td>{{ $order->first_name }} {{ $order->last_name }}</td>
            <td>{{ $order->phone }}</td>
            <td>৳ {{ $order->total }}</td>
            <td>{{ ucfirst($order->status) }}</td>
            <td>{{ strtoupper($order->payment_method) }}</td>
            <td>
                <button class="btn btn-sm btn-danger deleteOrder" data-id="{{ $order->id }}">Delete</button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>