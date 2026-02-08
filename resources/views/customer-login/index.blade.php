@extends('layout.app')
@section('title', 'Customer Login / Registration')
@section('content')
<!-- ===== Checkout Section ===== -->
<div class="container">
    <div class="row">
        <div class="container py-5">

            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <!-- Tabs -->
                        <ul class="nav new-nav-tabs" id="checkoutTabs" role="tablist">
                            <li><a class="nav-link active" id="billing-tab" data-toggle="tab" href="#loginID" role="tab">Login</a></li>
                            <li><a class="nav-link" id="shipping-tab" data-toggle="tab" href="#registrationID" role="tab">Registration</a></li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content checkoutTabLebel pt-3" id="login">

                            <!-- Billing Tab -->
                            <div class="tab-pane fade show active" id="loginID" role="registration">
                                
                               <form action="{{ route('customer.login.submit') }}" method="POST">
                                    @csrf  
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                        <label>Email *</label>
                                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                                        </div>
                                        <div class="form-group col-md-12">
                                        <label>Password *</label>
                                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                                        </div>
                                    </div>
                                    <div class="custom-link-btn"><button type="submit" class="btn">Login</button></div>
                                </form>
                            </div>

                            <!-- Shipping Tab -->
                            <div class="tab-pane fade" id="registrationID" role="tabpanel">
                               <form action="{{ route('customer.register') }}" method="POST">
                                    @csrf   
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                        <label>Email *</label>
                                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                                        </div>
                                    </div>
                                    <div class="custom-link-btn"><button type="submit" class="btn">Registration</button></div>    
                                </form>
                                <div class="col-md-12 mt-4">
                                    <p>A link to set a new password will be sent to your email address.</p>

                                    <p>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our privacy policy.</p>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- ===== End Checkout Section ===== -->
@endsection

@section('script')
<script src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('/js/popper.js') }}"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/js/custom.js') }}"></script>

<script>
    function nextTab(tabId) {
        $('a[href="#' + tabId.replace('-tab','') + '"]').tab('show');
    }
</script>
@endsection
