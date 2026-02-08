@extends('layout.app')

@section('title', 'My Cart')
@section('content')
<style>
    .is-invalid {
        border-color: #dc3545 !important;
    }
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: #dc3545;
    }
</style>
<!-- ===== Checkout Section ===== -->
<div class="container">
    <div class="row">
        <div class="container py-5">
            <!-- Tabs -->
            <ul class="nav new-nav-tabs" id="checkoutTabs" role="tablist">
                <li><a class="nav-link active" id="billing-tab" data-toggle="tab" href="#billing" role="tab" data-step="1">Billing</a></li>
                <li><a class="nav-link disabled" id="shipping-tab" data-toggle="tab" href="#shipping" role="tab" data-step="2" style="pointer-events: none; opacity: 0.6;">Shipping</a></li>
                <li><a class="nav-link disabled" id="review-tab" data-toggle="tab" href="#review" role="tab" data-step="3" style="pointer-events: none; opacity: 0.6;">Order Review</a></li>
                <li><a class="nav-link disabled" id="payment-tab" data-toggle="tab" href="#payment" role="tab" data-step="4" style="pointer-events: none; opacity: 0.6;">Payment</a></li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content checkoutTabLebel pt-3" id="checkoutTabContent">

                <!-- Billing Tab -->
                <div class="tab-pane fade show active" id="billing" role="tabpanel">
                    <div class="titel"><h2>Billing details</h2></div>
                    <form id="billingForm">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>First Name *</label>
                                <input type="text" class="form-control billing-field" id="billingFirstName" placeholder="First Name" required>
                                <div class="invalid-feedback" id="errorFirstName" style="display: none;"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Last Name *</label>
                                <input type="text" class="form-control billing-field" id="billingLastName" placeholder="Last Name" required>
                                <div class="invalid-feedback" id="errorLastName" style="display: none;"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Country *</label>
                            <select class="form-control billing-field" id="billingCountry" required>
                                <option value="">Select Country...</option>
                                <option value="">Select Country...</option>
                                <option value="Bangladesh" selected>Bangladesh</option>
                                <option value="Afghanistan">Afghanistan</option>
                                <option value="Albania">Albania</option>
                                <option value="Algeria">Algeria</option>
                                <option value="Argentina">Argentina</option>
                                <option value="Australia">Australia</option>
                                <option value="Austria">Austria</option>
                                <option value="Bahrain">Bahrain</option>
                                <option value="Belgium">Belgium</option>
                                <option value="Brazil">Brazil</option>
                                <option value="Canada">Canada</option>
                                <option value="China">China</option>
                                <option value="Denmark">Denmark</option>
                                <option value="Egypt">Egypt</option>
                                <option value="Finland">Finland</option>
                                <option value="France">France</option>
                                <option value="Germany">Germany</option>
                                <option value="Greece">Greece</option>
                                <option value="Hong Kong">Hong Kong</option>
                                <option value="India">India</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Iran">Iran</option>
                                <option value="Iraq">Iraq</option>
                                <option value="Ireland">Ireland</option>
                                <option value="Israel">Israel</option>
                                <option value="Italy">Italy</option>
                                <option value="Japan">Japan</option>
                                <option value="Jordan">Jordan</option>
                                <option value="Kuwait">Kuwait</option>
                                <option value="Malaysia">Malaysia</option>
                                <option value="Maldives">Maldives</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Myanmar">Myanmar</option>
                                <option value="Nepal">Nepal</option>
                                <option value="Netherlands">Netherlands</option>
                                <option value="New Zealand">New Zealand</option>
                                <option value="Norway">Norway</option>
                                <option value="Oman">Oman</option>
                                <option value="Pakistan">Pakistan</option>
                                <option value="Philippines">Philippines</option>
                                <option value="Poland">Poland</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Qatar">Qatar</option>
                                <option value="Russia">Russia</option>
                                <option value="Saudi Arabia">Saudi Arabia</option>
                                <option value="Singapore">Singapore</option>
                                <option value="South Africa">South Africa</option>
                                <option value="South Korea">South Korea</option>
                                <option value="Spain">Spain</option>
                                <option value="Sri Lanka">Sri Lanka</option>
                                <option value="Sweden">Sweden</option>
                                <option value="Switzerland">Switzerland</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Turkey">Turkey</option>
                                <option value="United Arab Emirates">United Arab Emirates</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="United States">United States</option>
                                <option value="Vietnam">Vietnam</option>
                            </select>
                            <div class="invalid-feedback" id="errorCountry" style="display: none; color: #dc3545; font-size: 0.875rem;"></div>
                        </div>
                        <div class="form-group">
                            <label>Apartment address (optional)</label>
                            <input type="text" class="form-control" id="billingApartment" placeholder="Apartment, suite, unit etc. (optional)">
                        </div>
                        <div class="form-group">
                            <label>Street address *</label>
                            <input type="text" class="form-control billing-field" id="billingAddress" placeholder="Building No. Flat No. Street No. etc." required>
                            <div class="invalid-feedback" id="errorAddress" style="display: none; color: #dc3545; font-size: 0.875rem;"></div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Town / City *</label>
                                <input type="text" class="form-control billing-field" id="billingCity" placeholder="Town / City" required>
                                <div class="invalid-feedback" id="errorCity" style="display: none; color: #dc3545; font-size: 0.875rem;"></div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>District *</label>
                                <select class="form-control billing-field" id="billingDistrict" required>
                                    <option value="">Select your district...</option>
                                    <option value="Bagerhat">Bagerhat</option>
                                    <option value="Bandarban">Bandarban</option>
                                    <option value="Barguna">Barguna</option>
                                    <option value="Barisal">Barisal</option>
                                    <option value="Bhola">Bhola</option>
                                    <option value="Bogra">Bogra</option>
                                    <option value="Brahmanbaria">Brahmanbaria</option>
                                    <option value="Chandpur">Chandpur</option>
                                    <option value="Chapainawabganj">Chapainawabganj</option>
                                    <option value="Chittagong">Chittagong</option>
                                    <option value="Chuadanga">Chuadanga</option>
                                    <option value="Comilla">Comilla</option>
                                    <option value="Cox's Bazar">Cox's Bazar</option>
                                    <option value="Dhaka" selected>Dhaka</option>
                                    <option value="Dinajpur">Dinajpur</option>
                                    <option value="Faridpur">Faridpur</option>
                                    <option value="Feni">Feni</option>
                                    <option value="Gaibandha">Gaibandha</option>
                                    <option value="Gazipur">Gazipur</option>
                                    <option value="Gopalganj">Gopalganj</option>
                                    <option value="Habiganj">Habiganj</option>
                                    <option value="Jamalpur">Jamalpur</option>
                                    <option value="Jessore">Jessore</option>
                                    <option value="Jhalokati">Jhalokati</option>
                                    <option value="Jhenaidah">Jhenaidah</option>
                                    <option value="Joypurhat">Joypurhat</option>
                                    <option value="Khagrachhari">Khagrachhari</option>
                                    <option value="Khulna">Khulna</option>
                                    <option value="Kishoreganj">Kishoreganj</option>
                                    <option value="Kurigram">Kurigram</option>
                                    <option value="Kushtia">Kushtia</option>
                                    <option value="Lakshmipur">Lakshmipur</option>
                                    <option value="Lalmonirhat">Lalmonirhat</option>
                                    <option value="Madaripur">Madaripur</option>
                                    <option value="Magura">Magura</option>
                                    <option value="Manikganj">Manikganj</option>
                                    <option value="Meherpur">Meherpur</option>
                                    <option value="Moulvibazar">Moulvibazar</option>
                                    <option value="Munshiganj">Munshiganj</option>
                                    <option value="Mymensingh">Mymensingh</option>
                                    <option value="Naogaon">Naogaon</option>
                                    <option value="Narail">Narail</option>
                                    <option value="Narayanganj">Narayanganj</option>
                                    <option value="Narsingdi">Narsingdi</option>
                                    <option value="Natore">Natore</option>
                                    <option value="Netrokona">Netrokona</option>
                                    <option value="Nilphamari">Nilphamari</option>
                                    <option value="Noakhali">Noakhali</option>
                                    <option value="Pabna">Pabna</option>
                                    <option value="Panchagarh">Panchagarh</option>
                                    <option value="Patuakhali">Patuakhali</option>
                                    <option value="Pirojpur">Pirojpur</option>
                                    <option value="Rajbari">Rajbari</option>
                                    <option value="Rajshahi">Rajshahi</option>
                                    <option value="Rangamati">Rangamati</option>
                                    <option value="Rangpur">Rangpur</option>
                                    <option value="Satkhira">Satkhira</option>
                                    <option value="Shariatpur">Shariatpur</option>
                                    <option value="Sherpur">Sherpur</option>
                                    <option value="Sirajganj">Sirajganj</option>
                                    <option value="Sunamganj">Sunamganj</option>
                                    <option value="Sylhet">Sylhet</option>
                                    <option value="Tangail">Tangail</option>
                                        <option value="Thakurgaon">Thakurgaon</option>
                                </select>
                                <div class="invalid-feedback" id="errorDistrict" style="display: none;"></div>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Postcode/ZIP *</label>
                                <input type="text" class="form-control billing-field" id="billingPostcode" placeholder="4-digit Number" required>
                                <div class="invalid-feedback" id="errorPostcode" style="display: none; color: #dc3545; font-size: 0.875rem;"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Phone *</label>
                                <input type="text" class="form-control billing-field" id="billingPhone" placeholder="11-digit Number ei. 01xxxxxxxxx" required>
                                <div class="invalid-feedback" id="errorPhone" style="display: none; color: #dc3545; font-size: 0.875rem;"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email address *</label>
                                <input type="email" class="form-control billing-field" id="billingEmail" placeholder="example@email.com" required>
                                <div class="invalid-feedback" id="errorEmail" style="display: none; color: #dc3545; font-size: 0.875rem;"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Additional Note (Optional)</label>
                            <textarea class="form-control" rows="5" placeholder="Additional Note (Optional)"></textarea>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">Create an account?</label>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('customer.login') }}" class="btn btn-outline-primary mr-2">Login</a>
                            <button type="button" class="btn btn-dark" onclick="validateAndNext('billing', 'shipping-tab')">Next</button>
                        </div>
                    </form>
                </div>

                <!-- Shipping Tab -->
                <div class="tab-pane fade" id="shipping" role="tabpanel">
                    <div class="titel">
                        <h2><input type="checkbox" id="shipDifferent"> Ship to a different address?</h2>
                    </div>
                    <form id="shippingForm">
                        <div class="shippingHidden">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>First Name *</label>
                                    <input type="text" class="form-control" placeholder="First Name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Last Name *</label>
                                    <input type="text" class="form-control" placeholder="Last Name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <h6>Country *</h6>
                                    <h6>Bangladesh *</h6>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Apartment address (optional)</label>
                                <input type="text" class="form-control" placeholder="Apartment, suite, unit etc. (optional)">
                            </div>
                            <div class="form-group">
                                <label>Street address *</label>
                                <input type="text" class="form-control" placeholder="Building No. Flat No. Street No. etc." required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Town / City *</label>
                                    <input type="text" class="form-control" placeholder="Town / City" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>District *</label>
                                    <select class="form-control" required>
                                        <option value="">Select your district...</option>
                                        <option value="Bagerhat">Bagerhat</option>
                                        <option value="Bandarban">Bandarban</option>
                                        <option value="Barguna">Barguna</option>
                                        <option value="Barisal">Barisal</option>
                                        <option value="Bhola">Bhola</option>
                                        <option value="Bogra">Bogra</option>
                                        <option value="Brahmanbaria">Brahmanbaria</option>
                                        <option value="Chandpur">Chandpur</option>
                                        <option value="Chapainawabganj">Chapainawabganj</option>
                                        <option value="Chittagong">Chittagong</option>
                                        <option value="Chuadanga">Chuadanga</option>
                                        <option value="Comilla">Comilla</option>
                                        <option value="Cox's Bazar">Cox's Bazar</option>
                                        <option value="Dhaka">Dhaka</option>
                                        <option value="Dinajpur">Dinajpur</option>
                                        <option value="Faridpur">Faridpur</option>
                                        <option value="Feni">Feni</option>
                                        <option value="Gaibandha">Gaibandha</option>
                                        <option value="Gazipur">Gazipur</option>
                                        <option value="Gopalganj">Gopalganj</option>
                                        <option value="Habiganj">Habiganj</option>
                                        <option value="Jamalpur">Jamalpur</option>
                                        <option value="Jessore">Jessore</option>
                                        <option value="Jhalokati">Jhalokati</option>
                                        <option value="Jhenaidah">Jhenaidah</option>
                                        <option value="Joypurhat">Joypurhat</option>
                                        <option value="Khagrachhari">Khagrachhari</option>
                                        <option value="Khulna">Khulna</option>
                                        <option value="Kishoreganj">Kishoreganj</option>
                                        <option value="Kurigram">Kurigram</option>
                                        <option value="Kushtia">Kushtia</option>
                                        <option value="Lakshmipur">Lakshmipur</option>
                                        <option value="Lalmonirhat">Lalmonirhat</option>
                                        <option value="Madaripur">Madaripur</option>
                                        <option value="Magura">Magura</option>
                                        <option value="Manikganj">Manikganj</option>
                                        <option value="Meherpur">Meherpur</option>
                                        <option value="Moulvibazar">Moulvibazar</option>
                                        <option value="Munshiganj">Munshiganj</option>
                                        <option value="Mymensingh">Mymensingh</option>
                                        <option value="Naogaon">Naogaon</option>
                                        <option value="Narail">Narail</option>
                                        <option value="Narayanganj">Narayanganj</option>
                                        <option value="Narsingdi">Narsingdi</option>
                                        <option value="Natore">Natore</option>
                                        <option value="Netrokona">Netrokona</option>
                                        <option value="Nilphamari">Nilphamari</option>
                                        <option value="Noakhali">Noakhali</option>
                                        <option value="Pabna">Pabna</option>
                                        <option value="Panchagarh">Panchagarh</option>
                                        <option value="Patuakhali">Patuakhali</option>
                                        <option value="Pirojpur">Pirojpur</option>
                                        <option value="Rajbari">Rajbari</option>
                                        <option value="Rajshahi">Rajshahi</option>
                                        <option value="Rangamati">Rangamati</option>
                                        <option value="Rangpur">Rangpur</option>
                                        <option value="Satkhira">Satkhira</option>
                                        <option value="Shariatpur">Shariatpur</option>
                                        <option value="Sherpur">Sherpur</option>
                                        <option value="Sirajganj">Sirajganj</option>
                                        <option value="Sunamganj">Sunamganj</option>
                                        <option value="Sylhet">Sylhet</option>
                                        <option value="Tangail">Tangail</option>
                                        <option value="Thakurgaon">Thakurgaon</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Postcode/ZIP *</label>
                                    <input type="text" class="form-control" placeholder="4-digit Number" required>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                        <button class="btn btn-secondary" type="button" onclick="nextTab('billing-tab')">Back</button>
                            <button class="btn btn-dark" type="button" onclick="validateAndNext('shipping', 'review-tab')">Next</button>
                        </div>
                    </form>
                </div>

                <!-- Order Review Tab -->
                <div class="tab-pane fade" id="review" role="tabpanel">
                    <div id="orderSummary"></div>
                    <div class="text-right mt-3">
                    <button class="btn btn-secondary" type="button" onclick="nextTab('shipping-tab')">Back</button>
                        <button class="btn btn-dark" type="button" onclick="validateAndNext('review', 'payment-tab')">Next</button>
                    </div>
                </div>

                <!-- Payment Tab -->
                <div class="tab-pane fade" id="payment" role="tabpanel">
                    <div class="form-group">
                        <label><strong>Select Payment Method:</strong></label><br>
                        <div class="form-check mt-3" id="codPaymentOption" style="display: none;">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="paymentMethod" value="cod">
                            Cash on Delivery</label>
                        </div>
                        <div class="form-check mt-2">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="paymentMethod" value="card" checked>
                            Card/Mobile Banking</label>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-secondary" type="button" onclick="nextTab('review-tab')">Back</button>
                        <button class="btn btn-success">Place Order</button>
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
    // Track completed steps
    const completedSteps = {
        billing: false,
        shipping: false,
        review: false
    };

    function nextTab(tabId) {
        const tab = $('#' + tabId);
        if (!tab.hasClass('disabled')) {
            tab.tab('show');
        }
    }

    function enableTab(tabId) {
        const tab = $('#' + tabId);
        tab.removeClass('disabled');
        tab.css({'pointer-events': 'auto', 'opacity': '1'});
    }

    // Helper functions to show/hide error messages
    function showError(fieldId, message) {
        const errorDiv = $('#error' + fieldId);
        if (errorDiv.length) {
            errorDiv.text(message).css('display', 'block');
            const inputField = $('#billing' + fieldId);
            if (inputField.length) {
                inputField.addClass('is-invalid');
            } else {
                // Fallback: try to find by placeholder or other selector
                const fallbackField = $('#billing input, #billing select').filter(function() {
                    return $(this).attr('id') && $(this).attr('id').includes(fieldId.toLowerCase());
                });
                if (fallbackField.length) {
                    fallbackField.addClass('is-invalid');
                }
            }
        }
    }

    function hideError(fieldId) {
        const errorDiv = $('#error' + fieldId);
        if (errorDiv.length) {
            errorDiv.hide();
            const inputField = $('#billing' + fieldId);
            if (inputField.length) {
                inputField.removeClass('is-invalid');
            }
        }
    }

    function clearAllErrors() {
        $('.invalid-feedback').hide();
        $('.is-invalid').removeClass('is-invalid');
    }

    function validateBilling() {
        clearAllErrors();
        let isValid = true;

        // Get values using IDs
        const firstName = $("#billingFirstName").val() || '';
        const lastName = $("#billingLastName").val() || '';
        const email = $("#billingEmail").val() || '';
        const phone = $("#billingPhone").val() || '';
        const address = $("#billingAddress").val() || '';
        const country = $("#billingCountry").val() || '';
        const district = $("#billingDistrict").val() || '';
        const city = $("#billingCity").val() || '';
        const postcode = $("#billingPostcode").val() || '';

        // Validate First Name
        if (!firstName.trim()) {
            showError('FirstName', 'First name is required.');
            isValid = false;
        }

        // Validate Last Name
        if (!lastName.trim()) {
            showError('LastName', 'Last name is required.');
            isValid = false;
        }

        // Validate Email
        if (!email.trim()) {
            showError('Email', 'Email address is required.');
            isValid = false;
        } else {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.trim())) {
                showError('Email', 'Please enter a valid email address.');
                isValid = false;
            }
        }

        // Validate Phone
        if (!phone.trim()) {
            showError('Phone', 'Phone number is required.');
            isValid = false;
        } else {
            const phoneClean = phone.replace(/\s/g, '');
            if (!/^01\d{9}$/.test(phoneClean)) {
                showError('Phone', 'Please enter a valid 11-digit phone number starting with 01.');
                isValid = false;
            }
        }

        // Validate Address
        if (!address.trim()) {
            showError('Address', 'Street address is required.');
            isValid = false;
        }

        // Validate Country
        if (!country || country === 'Select Country...') {
            showError('Country', 'Please select a country.');
            isValid = false;
        }

        // Validate District
        if (!district || district === 'Select your district...') {
            showError('District', 'Please select a district.');
            isValid = false;
        }

        // Validate City
        if (!city.trim()) {
            showError('City', 'Town/City is required.');
            isValid = false;
        }

        // Validate Postcode
        if (!postcode.trim()) {
            showError('Postcode', 'Postcode is required.');
            isValid = false;
        } else {
            if (!/^\d{4}$/.test(postcode.trim())) {
                showError('Postcode', 'Please enter a valid 4-digit postcode.');
                isValid = false;
            }
        }

        return isValid;
    }

    function validateShipping() {
        // If "Ship to different address" is not checked, shipping is automatically valid
        if (!$("#shipDifferent").is(":checked")) {
            return true;
        }

        // If checked, validate shipping fields using HTML5 validation
        const shippingForm = document.getElementById("shippingForm");
        if (shippingForm.checkValidity()) {
            return true;
        } else {
            // Show HTML5 validation messages
            shippingForm.reportValidity();
            return false;
        }
    }

    function validateReview() {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        if (cart.length === 0) {
            // Show error in order summary area
            const orderSummary = document.getElementById("orderSummary");
            if (orderSummary) {
                orderSummary.innerHTML = '<div class="alert alert-danger">Your cart is empty! Please add items to your cart before proceeding.</div>';
            }
            return false;
        }
        return true;
    }

    function validateAndNext(currentStep, nextTabId) {
        let isValid = false;

        switch(currentStep) {
            case 'billing':
                isValid = validateBilling();
                if (isValid) {
                    completedSteps.billing = true;
                    enableTab('shipping-tab');
                }
                break;
            case 'shipping':
                isValid = validateShipping();
                if (isValid) {
                    completedSteps.shipping = true;
                    enableTab('review-tab');
                }
                break;
            case 'review':
                isValid = validateReview();
                if (isValid) {
                    completedSteps.review = true;
                    enableTab('payment-tab');
                }
                break;
        }

        if (isValid) {
            nextTab(nextTabId);
        }
    }

    // Check if postcode is in the special range (1000, 1100, 1203-1236)
    function isPostcodeInSpecialRange(postcode) {
        const postcodeNum = parseInt(postcode);
        // If postcode is 1000, 1100, or between 1203-1236
        return (postcodeNum == 1000 || postcodeNum == 1100 || (postcodeNum >= 1203 && postcodeNum <= 1236));
    }

    // Calculate delivery charge based on postcode
    function calculateDeliveryCharge(postcode) {
        // If postcode is in special range, delivery charge is 80
        if (isPostcodeInSpecialRange(postcode)) {
            return 80;
        }
        return 150;
    }

    // Update payment method options based on postcode
    function updatePaymentMethods() {
        const postcode = $("#billingPostcode").length ? $("#billingPostcode").val() : $("#billing input[placeholder='4-digit Number']").val() || '';
        
        if (postcode && /^\d{4}$/.test(postcode.trim())) {
            const isInSpecialRange = isPostcodeInSpecialRange(postcode);
            const codOption = $("#codPaymentOption");
            const cardRadio = $("input[name='paymentMethod'][value='card']");
            const codRadio = $("input[name='paymentMethod'][value='cod']");
            
            if (isInSpecialRange) {
                // Postcode is 1000, 1100, or 1203-1236 - Show COD option
                codOption.show();
                // If card is selected, switch to COD as default for these postcodes
                if (cardRadio.is(':checked')) {
                    codRadio.prop('checked', true);
                }
            } else {
                // Postcode is outside range - Hide COD, show only Card
                codOption.hide();
                // Ensure card is selected if COD was selected
                if (codRadio.is(':checked')) {
                    cardRadio.prop('checked', true);
                }
            }
        } else {
            // Postcode not entered or invalid - Hide COD by default
            $("#codPaymentOption").hide();
            if (!$("input[name='paymentMethod']:checked").length) {
                $("input[name='paymentMethod'][value='card']").prop('checked', true);
            }
        }
    }

    function loadOrderSummary() {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        let subtotal = 0;
        
        // Get postcode from billing form to calculate delivery charge
        const postcode = $("#billing input[placeholder='4-digit Number']").val() || '';
        const deliveryCharge = calculateDeliveryCharge(postcode);
        
        let html = `
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Remove</th>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Qty</th>
                        <th>Barcord</th>
                        <th>Price</th>
                        
                    </tr>
                </thead>
                <tbody>
        `;

        cart.forEach(item => {
            subtotal += item.qty * item.price;
            html += `
            <tr>
                <td><button class="btn btn-sm btn-danger removeItem" data-id="${item.id}">×</button></td>
                <td><img src="${item.img}" alt="${item.name}" width="50"></td>
                <td>${item.name}</td>
                <td>${item.size || '-'}</td>
                <td>${item.color || '-'}</td>
                <td>${item.qty}</td>
                <td>${item.barcode}</td>
                <td>৳ ${item.qty * item.price}</td>
              
            </tr>`;
        });

        html += `
                </tbody>
                <tfoot>
                    
                    <tr><td></td><td colspan="6">Subtotal</td><td>৳ ${subtotal}</td></tr>
                    <tr><td></td><td colspan="6">Delivery ${postcode ? `(Postcode: ${postcode})` : ''}</td><td>৳ ${deliveryCharge}</td></tr>
                    <tr><td></td><td colspan="6"><strong>Total</strong></td><td><strong>৳ ${subtotal + deliveryCharge}</strong></td></tr>
                </tfoot>
            </table>
        </div>`;

        document.getElementById("orderSummary").innerHTML = html;

        document.querySelectorAll(".removeItem").forEach(btn => {
            btn.addEventListener("click", e => {
                const id = e.target.dataset.id;
                let cart = JSON.parse(localStorage.getItem("cart")) || [];
                cart = cart.filter(item => item.id != id);
                localStorage.setItem("cart", JSON.stringify(cart));
                loadOrderSummary();
                if(typeof renderCart === "function") renderCart();
                if(typeof updateCartCounts === "function") updateCartCounts();
            });
        });
    }

    $(document).ready(function() {
        // Prevent clicking on disabled tabs
        $('a[data-toggle="tab"].disabled').on('click', function(e) {
            e.preventDefault();
            return false;
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            if(e.target.id === 'review-tab') {
                loadOrderSummary();
            }
            if(e.target.id === 'payment-tab') {
                updatePaymentMethods();
            }
        });
        
        // Update payment methods and order summary when postcode changes
        $('#billingPostcode, #billing input[placeholder="4-digit Number"]').on('change blur input', function() {
            updatePaymentMethods();
            if($('#review-tab').hasClass('active')) {
                loadOrderSummary();
            }
        });

        // Shipping toggle
        $(".shippingHidden").hide();
        $("#shipDifferent").on("change", function() {
            if($(this).is(":checked")) {
                $(".shippingHidden").slideDown();
            } else {
                $(".shippingHidden").slideUp();
            }
        });

        // Silently check if billing is complete (without alerts) to enable next tab
        $('.billing-field, #billingCountry').on('change blur', function() {
            // Only check silently, don't show alerts
            const firstName = $("#billing input[placeholder='First Name']").val() || '';
            const lastName = $("#billing input[placeholder='Last Name']").val() || '';
            const email = $("#billing input[placeholder='example@email.com']").val() || '';
            const phone = $("#billing input[placeholder*='01']").val() || '';
            const address = $("#billing input[placeholder*='Building']").val() || '';
            const country = $("#billingCountry").val() || '';
            const district = $("#billing select.form-control.billing-field").val() || '';
            const city = $("#billing input[placeholder='Town / City']").val() || '';
            const postcode = $("#billing input[placeholder='4-digit Number']").val() || '';
            
            // Check if all fields are filled (silent check)
            if (firstName.trim() && lastName.trim() && email.trim() && phone.trim() && 
                address.trim() && country && country !== 'Select Country...' &&
                district && district !== 'Select your district...' && 
                city.trim() && postcode.trim()) {
                // Validate formats silently
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const phoneClean = phone.replace(/\s/g, '');
                if (emailRegex.test(email.trim()) && /^01\d{9}$/.test(phoneClean) && /^\d{4}$/.test(postcode.trim())) {
                    if (!completedSteps.billing) {
                        completedSteps.billing = true;
                        enableTab('shipping-tab');
                    }
                }
            }
        });
    });

//--------place order-----
 $(document).on("click", ".btn-success", function() {
    const cart = localStorage.getItem("cart");
    if (!cart || JSON.parse(cart).length === 0) {
        // Show error in payment section
        $('#payment').prepend('<div class="alert alert-danger alert-dismissible fade show" role="alert">Your cart is empty! Please add items to your cart before placing an order.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
        return;
    }

    const paymentMethod = $("input[name='paymentMethod']:checked").val();
    const form = {
        first_name: $("#billing input[placeholder='First Name']").val(),
        last_name: $("#billing input[placeholder='Last Name']").val(),
        email: $("#billing input[placeholder='example@email.com']").val(),
        phone: $("#billing input[placeholder*='01']").val(),
        address: $("#billing input[placeholder*='Building']").val(),
        apartment: $("#billing input[placeholder*='Apartment']").val() || '',
        country: $("#billingCountry").val() || 'Bangladesh',
        district: $("#billing select.form-control.billing-field").val(),
        city: $("#billing input[placeholder='Town / City']").val(),
        postcode: $("#billing input[placeholder='4-digit Number']").val(),
        note: $("#billing textarea").val() || '',
        payment_method: paymentMethod,
        cart: cart
    };

    // Validate required fields - use the same validation function
    if (!validateBilling()) {
        // Scroll to first error
        const firstError = $('.is-invalid').first();
        if (firstError.length) {
            $('html, body').animate({
                scrollTop: firstError.offset().top - 100
            }, 500);
        }
        // Switch to billing tab to show errors
        nextTab('billing-tab');
        return;
    }

    // If Card payment, create a form and submit directly (not via AJAX)
    if (paymentMethod === 'card') {
        // Create a hidden form and submit it
        // Note: CSRF is excluded for this route in middleware
        const paymentForm = document.createElement('form');
        paymentForm.method = 'POST';
        paymentForm.action = "{{ route('checkout.pay') }}";
        paymentForm.style.display = 'none';
        
        // Add CSRF token (even though route is excluded, include it for safety)
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        paymentForm.appendChild(csrfInput);
        
        // Add all form fields
        Object.keys(form).forEach(key => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = form[key];
            paymentForm.appendChild(input);
        });
        
        // Append to body and submit
        document.body.appendChild(paymentForm);
        
        // Add a small delay to ensure form is properly added to DOM
        setTimeout(function() {
            paymentForm.submit();
        }, 100);
        return;
            } else {
        // For COD and bKash, use existing order.store route
        // The route now redirects to success page, so we need to submit as form
        const orderForm = document.createElement('form');
        orderForm.method = 'POST';
        orderForm.action = "{{ route('order.store') }}";
        orderForm.style.display = 'none';
        
        // Add CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        orderForm.appendChild(csrfInput);
        
        // Add all form fields
        Object.keys(form).forEach(key => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = form[key];
            orderForm.appendChild(input);
        });
        
        // Append to body and submit
        document.body.appendChild(orderForm);
        
        // Add a small delay to ensure form is properly added to DOM
        setTimeout(function() {
            orderForm.submit();
        }, 100);
    }
});
</script>
@endsection
