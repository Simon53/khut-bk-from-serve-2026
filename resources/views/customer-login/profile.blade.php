@extends('layout.app')

@section('title', 'Customer Profile')

@section('content')
<!-- ===== Profile Section ===== -->

<style>
    .card{
        background-color:transparent!important;
    }
    .order-list-item {
        border-bottom: 1px solid #ddd;
        padding: 12px 0;
    }
    .order-list-item:last-child {
        border-bottom: none;
    }
    .modal-content{
        background-color: #bdb8b8;
    }
    
</style>

<div class="container py-5">
    <div class="col-md-12 p-4">
        <h4>Update Profile</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <!-- Left Sidebar (Vertical Tabs) -->
        <div class="col-md-3 p-4 border-right">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                <a class="nav-link active" id="profile-tab" data-toggle="pill" href="#profile" role="tab">Profile</a>
                <a class="nav-link" id="order-tab" data-toggle="pill" href="#order" role="tab">Orders</a>
            </div>

            <form action="{{ route('customer.logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-danger w-100">Logout</button>
            </form>
        </div>

        <!-- Right Content -->
        <div class="col-md-9 p-4">
            <div class="tab-content" id="v-pills-tabContent">
                <!-- ===== Profile Tab ===== -->
                <div class="tab-pane fade show active custom-link-btn" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form action="{{ route('customer.profile.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>First Name *</label>
                                <input type="text" name="first_name" class="form-control" value="{{ $customer->first_name }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Last Name *</label>
                                <input type="text" name="last_name" class="form-control" value="{{ $customer->last_name }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Display Name *</label>
                            <input type="text" name="display_name" class="form-control" value="{{ $customer->display_name }}" required>
                        </div>

                        <div class="form-group">
                            <label>Email Address *</label>
                            <input type="email" name="email" class="form-control" value="{{ $customer->email }}" required>
                        </div>

                        <h5 class="mt-4">Make Your Password</h5>
                        @if(is_null($customer->password))
                            <div class="alert alert-info" style="display:none">You don’t have a password yet. Please create one below.</div>
                        @endif

                        <div class="form-group" style="display:none">
                            <label>Current Password (leave blank if setting first time)</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="new_password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Save Profile</button>
                    </form>
                </div>

                <!-- ===== Orders Tab ===== -->
                <div class="tab-pane fade" id="order" role="tabpanel" aria-labelledby="order-tab">
                    <h5 class="mb-4">Your Orders</h5>
                    @if($orders->count() > 0)
                        <div class="list-group">
                            @foreach($orders as $order)
                                <div class="order-list-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>Order #{{ $order->id }}</strong><br>
                                            <small>Date: {{ $order->created_at->format('d M Y, h:i A') }}</small><br>
                                            <small>Status: <span class="badge badge-secondary">{{ ucfirst($order->status) }}</span></small>
                                        </div>
                                        <div class="text-right">
                                            <strong>৳{{ number_format($order->total, 2) }}</strong><br>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-primary mt-1 view-order-btn"
                                                    data-id="{{ $order->id }}">
                                                View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            You have no orders yet.
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ===== Order Details Modal ===== -->
<!-- ===== Order Details Modal ===== -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>  <!-- fixed -->
                </button>
            </div>
            <div class="modal-body" id="order-details-content">
                <p class="text-center text-muted">Loading...</p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('/js/popper.js') }}"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/js/custom.js') }}"></script>
<script>
$(document).ready(function(){
    $('.view-order-btn').click(function(){
        const orderId = $(this).data('id');
        $('#order-details-content').html('<p class="text-center text-muted">Loading...</p>');
        $('#orderDetailsModal').modal('show');

        $.get(`/customer/order-details/${orderId}`, function(response){
            $('#order-details-content').html(response);
        }).fail(function(){
            $('#order-details-content').html('<div class="alert alert-danger">Failed to load order details.</div>');
        });
    });
});
</script>
@endsection
