@extends('layout.app')

@section('title', 'Payment Failed')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#dc3545" stroke-width="2" fill="none"/>
                            <path d="M15 9l-6 6M9 9l6 6" stroke="#dc3545" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h2 class="text-danger mb-3">Payment Failed!</h2>
                    <p class="text-muted mb-4">{{ $message ?? 'Your payment could not be processed. Please try again.' }}</p>
                    
                    @if(isset($order))
                    <div class="alert alert-warning text-left">
                        <h5>Order Information:</h5>
                        <p class="mb-1"><strong>Order ID:</strong> #{{ $order->id }}</p>
                        @if($order->transaction_id)
                        <p class="mb-1"><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
                        @endif
                        <p class="mb-0"><strong>Status:</strong> <span class="badge badge-danger">{{ ucfirst($order->status) }}</span></p>
                    </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary mr-2">Try Again</a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


