@extends('layout.app')
@section('title', 'Khut::Order List')
@section('content')

@section('content')

<style>
    .table-hover tbody tr:hover{
        background-color: #dfd8d8;
    }
</style>
<div class="container-fluid">


    <div class="row">
        <div class="card p-4 col-md-12" style="color:#333">
             <h4>Order List</h4>

    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>SL</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Total</th>
                <th>Status</th>
                <th>Delivery Status</th>
                <th>Payment By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
       @foreach($orders as $order)
        <tr id="orderRow{{ $order->id }}">
            <td>{{ $loop->iteration }}</td>
            <td>
                <a href="{{ route('orders.show', $order->id) }}">
                    {{ $order->first_name }} {{ $order->last_name }}
                </a>
            </td>
            <td>{{ $order->phone }}</td>
            <td>৳ {{ $order->total }}</td>
            <td>{{ ucfirst($order->status) }}</td>
            <td>
                <select class="form-control delivery-status" data-id="{{ $order->id }}">
                    <option value="pending" {{ $order->delivery_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="delivered" {{ $order->delivery_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                </select>
            </td>  
            <td>{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Paid' }}</td> 
            <td>
                <button class="btn btn-sm btn-danger deleteOrder" data-id="{{ $order->id }}">Delete</button>
            </td>
        </tr>
    @endforeach

        </tbody>
    </table>

    <div>{{ $orders->links() }}</div>
        </div>
    </div>
</div>

@section('script')
    <script>
        $(document).on("click", ".deleteOrder", function() {
            if(!confirm("Are you sure to delete this order?")) return;

            let id = $(this).data("id");
            $.ajax({
                url: `/admin/orders/${id}`,
                type: "DELETE",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function(res){
                    if(res.success){
                        $("#orderRow"+id).remove();
                        alert(res.message);
                    }
                }
            });
        });


    document.querySelectorAll('.delivery-status').forEach(select => {
        select.addEventListener('change', function () {
            let orderId = this.dataset.id;
            let status  = this.value;

            fetch(`/admin/orders/${orderId}/delivery-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ delivery_status: status })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // 🔔 dashboard notify
                    localStorage.setItem('dashboard_refresh', Date.now());
                    
                }
            });
        });
    });
    </script>
    @endsection
    
@endsection
