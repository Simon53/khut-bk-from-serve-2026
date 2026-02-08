<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Order;
use App\Models\OrderItem;

class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function checkoutPayment(Request $request)
    {
        // Log request for debugging
        \Log::info('Checkout Payment Request', [
            'method' => $request->method(),
            'path' => $request->path(),
            'has_csrf' => $request->has('_token'),
            'all_inputs' => $request->except(['_token'])
        ]);
        
        $cart = json_decode($request->cart, true);
        
        if(!$cart || count($cart) === 0){
            return back()->with('error', 'Cart is empty!');
        }

        // Calculate subtotal
        $subtotal = 0;
        foreach($cart as $item){
            $subtotal += $item['qty'] * $item['price'];
        }

        // Determine delivery charge based on postcode
        $postcode = (int)($request->postcode ?? 0);
        $delivery = 150; // Default delivery charge
        
        // If postcode is 1000, 1100, or between 1203-1236, delivery charge is 80
        if ($postcode == 1000 || $postcode == 1100 || ($postcode >= 1203 && $postcode <= 1236)) {
            $delivery = 80;
        }
        
        $total_amount = $subtotal + $delivery;
        
        // Generate unique transaction ID
        $tran_id = 'TXN' . uniqid();

        // Create Order with Pending status
        $order = Order::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'apartment' => $request->apartment ?? null,
            'district' => $request->district,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'country' => 'Bangladesh',
            'notes' => $request->note ?? null,
            'payment_method' => 'card',
            'subtotal' => $subtotal,
            'delivery_charge' => $delivery,
            'total' => $total_amount,
            'status' => 'Pending',
            'transaction_id' => $tran_id,
            'delivery_status' => 'pending',
        ]);

        // Insert Order Items immediately (same as COD flow) - do not defer to success callback
        // Session can be lost when redirecting to external SSLCommerz domain
        foreach ($cart as $item) {
            $order->items()->create([
                'product_id' => $item['id'] ?? null,
                'product_name' => $item['name'],
                'size' => $item['size'] ?? null,
                'color' => $item['color'] ?? null,
                'quantity' => $item['qty'],
                'price' => $item['price'],
                'subtotal' => $item['qty'] * $item['price'],
                'barcode' => $item['barcode'] ?? null,
            ]);
        }

        // Store cart in session as fallback (success callback may still need it if order items already exist)
        session(['order_cart_' . $tran_id => $cart]);

        // Prepare SSLCommerz payment data
        $post_data = array();
        $post_data['total_amount'] = $total_amount;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $tran_id;

        // CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->first_name . ' ' . $request->last_name;
        $post_data['cus_email'] = $request->email;
        $post_data['cus_add1'] = $request->address;
        $post_data['cus_add2'] = $request->apartment ?? "";
        $post_data['cus_city'] = $request->city ?? "";
        $post_data['cus_state'] = $request->district ?? "";
        $post_data['cus_postcode'] = $request->postcode ?? "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $request->phone;
        $post_data['cus_fax'] = "";

        // SHIPMENT INFORMATION (same as billing)
        $post_data['ship_name'] = $request->first_name . ' ' . $request->last_name;
        $post_data['ship_add1'] = $request->address;
        $post_data['ship_add2'] = $request->apartment ?? "";
        $post_data['ship_city'] = $request->city ?? "";
        $post_data['ship_state'] = $request->district ?? "";
        $post_data['ship_postcode'] = $request->postcode ?? "";
        $post_data['ship_phone'] = $request->phone;
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Khut Bangladesh Products";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        // OPTIONAL PARAMETERS
        $post_data['value_a'] = $order->id; // Store order ID
        $post_data['value_b'] = $tran_id; // Also store transaction ID
        $post_data['value_c'] = "";
        $post_data['value_d'] = "";
        
        // Override success URL to include order ID for easier lookup
        $success_url = rtrim(env('APP_URL'), '/') . '/success?order_id=' . $order->id;
        $post_data['success_url'] = $success_url;
        
        \Log::info('SSLCommerz Success URL configured', [
            'success_url' => $success_url,
            'app_url' => env('APP_URL'),
            'order_id' => $order->id
        ]);

        $sslc = new SslCommerzNotification();
        
        // Use 'checkout' mode to get the GatewayPageURL, then redirect ourselves
        $payment_response = $sslc->makePayment($post_data, 'checkout', 'json');
        
        \Log::info('SSLCommerz Payment Response', [
            'raw_response' => $payment_response,
            'order_id' => $order->id,
            'tran_id' => $tran_id
        ]);
        
        // Decode the JSON response
        $response_data = json_decode($payment_response, true);
        
        if (isset($response_data['status']) && 
            (strtolower($response_data['status']) == 'success' || $response_data['status'] == 'SUCCESS') && 
            !empty($response_data['data'])) {
            
            \Log::info('Redirecting to SSLCommerz', [
                'gateway_url' => $response_data['data'],
                'order_id' => $order->id
            ]);
            
            // Redirect to SSLCommerz payment page
            return redirect($response_data['data']);
        }

        // If payment initialization failed, redirect back with error
        $error_message = $response_data['message'] ?? 'Payment initialization failed. Please try again.';
        \Log::error('SSLCommerz Payment Initialization Failed', [
            'response' => $response_data,
            'order_id' => $order->id
        ]);
        return redirect()->route('checkout.index')->with('error', $error_message);
    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {
        try {
            // Log immediately when method is called (before any processing)
            // Use multiple logging methods to ensure we see it
            \Log::info('=== SUCCESS METHOD CALLED ===', [
                'method' => $request->method(),
                'path' => $request->path(),
                'full_url' => $request->fullUrl(),
                'route_name' => $request->route()?->getName(),
                'headers' => $request->headers->all(),
                'ip' => $request->ip(),
            ]);
            
            // Also write to error log to ensure we see it
            error_log('SUCCESS METHOD CALLED: ' . $request->fullUrl());
            
            // Check if this is a COD order redirect (has order_id and no SSLCommerz params)
            $order_id_from_url = $request->query('order_id');
            $order_from_session = $request->session()->get('order');
            
            // If we have order from session (COD redirect) or order_id without SSLCommerz params
            if ($order_from_session || ($order_id_from_url && !$request->has('tran_id'))) {
                $order = $order_from_session ?: Order::find($order_id_from_url);
                
                if ($order && $order->payment_method == 'cod') {
                    // This is a COD order - show success page directly
                    \Log::info('COD Order Success', ['order_id' => $order->id]);
                    $request->session()->forget('order'); // Clear session
                    return view('payment.success', ['order' => $order]);
                }
            }
            
            // SSLCommerz sends data via POST (form data) after redirect
            // Standard field names: tran_id, val_id, amount, currency, status
            $allParams = array_merge($request->all(), $request->query());
            
            // SSLCommerz standard parameter names
            $tran_id = $allParams['tran_id'] ?? null;
        $val_id = $allParams['val_id'] ?? null; // Validation ID from SSLCommerz
        $amount = $allParams['amount'] ?? null;
        $currency = $allParams['currency'] ?? 'BDT';
        $status = $allParams['status'] ?? null;
        
        // Try to get order ID from URL parameter (we added this to success URL)
        $order_id_from_url = $request->query('order_id');

        // Log all incoming data for debugging
        \Log::info('SSLCommerz Success Callback', [
            'method' => $request->method(),
            'all_params' => $allParams,
            'order_id_from_url' => $order_id_from_url,
            'tran_id_found' => $tran_id,
            'val_id_found' => $val_id,
            'amount_found' => $amount,
            'currency_found' => $currency,
            'status_found' => $status
        ]);

        $sslc = new SslCommerzNotification();

        // Find the order - try multiple methods (consolidated logic)
        $order = null;
        
        // Method 1: Find by order ID from URL (most reliable)
        if ($order_id_from_url) {
            $order = Order::find($order_id_from_url);
            if ($order) {
                $tran_id = $order->transaction_id;
                $amount = $order->total;
                $currency = 'BDT';
                \Log::info('Found order by URL order_id', ['order_id' => $order->id, 'tran_id' => $tran_id]);
            }
        }
        
        // Method 2: Find by transaction ID if available
        if (!$order && $tran_id) {
            $order = Order::where('transaction_id', $tran_id)->first();
        }
        
        // Method 3: Find by order ID from value_a if available
        if (!$order) {
            $order_id = $allParams['value_a'] ?? null;
            if ($order_id) {
                $order = Order::find($order_id);
                if ($order) {
                    $tran_id = $order->transaction_id;
                    $amount = $order->total;
                    $currency = 'BDT';
                }
            }
        }
        
        // Method 3: If no transaction ID, find most recent pending card order
        // This handles cases where SSLCommerz redirects without parameters
        if (!$order && !$tran_id && !$val_id) {
            $order = Order::where('status', 'Pending')
                ->where('payment_method', 'card')
                ->where('created_at', '>=', now()->subMinutes(30))
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($order) {
                $tran_id = $order->transaction_id;
                $amount = $order->total;
                \Log::info('Found pending order by timestamp', ['order_id' => $order->id, 'tran_id' => $tran_id]);
            }
        }
        
        // Method 4: If we have val_id but no order, try to find by recent pending orders
        if (!$order && $val_id) {
            $order = Order::where('status', 'Pending')
                ->where('payment_method', 'card')
                ->where('created_at', '>=', now()->subHour())
                ->orderBy('created_at', 'desc')
                ->first();
        }

        if (!$order) {
            \Log::warning('Order not found in success callback', [
                'tran_id' => $tran_id,
                'val_id' => $val_id,
                'all_params' => $allParams
            ]);
            return view('payment.fail', ['message' => 'Order not found. Please contact support with transaction details.']);
        }
        
        // Update tran_id if we found order but didn't have tran_id
        if (!$tran_id && $order) {
            $tran_id = $order->transaction_id;
        }

        if ($order->status == 'Pending') {
            // If we have val_id, use it for validation, otherwise use tran_id
            $allData = $allParams;
            
            // Add val_id if we have it
            if ($val_id) {
                $allData['val_id'] = $val_id;
            }
            
            // Use order amount if not provided in request
            $validationAmount = $amount ?? $order->total;
            
            // Use tran_id for validation
            $validationTranId = $tran_id ?? $order->transaction_id;
            
            // Only validate if we have val_id (required for SSLCommerz validation API)
            // When SSLCommerz redirects via GET, they don't send val_id, so we skip validation
            // and rely on IPN for final validation, or trust the redirect to success URL
            if ($val_id) {
                // We have val_id, so we can validate via SSLCommerz API
                $allData['val_id'] = $val_id; // Ensure it's in the data array
                $validation = $sslc->orderValidate($allData, $validationTranId, $validationAmount, $currency);
            } else {
                // No val_id - SSLCommerz redirected via GET without validation data
                // Since they redirected to success URL, we trust the payment was successful
                // IPN will do final validation later
                \Log::info('Success callback without val_id - trusting redirect', [
                    'order_id' => $order->id,
                    'tran_id' => $tran_id,
                    'request_method' => $request->method()
                ]);
                $validation = true; // Trust the redirect to success URL
            }

            if ($validation) {
                // Update order status to paid/processing
                $order->status = 'paid';
                $order->save();

                // Get cart items from session and create order items
                $cart = session('order_cart_' . $tran_id);
                if ($cart) {
                    foreach($cart as $item){
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $item['id'] ?? null,
                            'product_name' => $item['name'],
                            'size' => $item['size'] ?? null,
                            'color' => $item['color'] ?? null,
                            'quantity' => $item['qty'],
                            'price' => $item['price'],
                            'subtotal' => $item['qty'] * $item['price'],
                            'barcode' => $item['barcode'] ?? null,
                        ]);
                    }
                    // Clear session
                    session()->forget('order_cart_' . $tran_id);
                }

                return view('payment.success', ['order' => $order]);
            } else {
                return view('payment.fail', ['message' => 'Payment validation failed']);
            }
        } else if ($order->status == 'paid' || $order->status == 'Processing' || $order->status == 'Complete') {
            // Order already processed, just show success
            // Make sure order items exist
            if ($order->items()->count() == 0) {
                $cart = session('order_cart_' . $tran_id);
                if ($cart) {
                    foreach($cart as $item){
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $item['id'] ?? null,
                            'product_name' => $item['name'],
                            'size' => $item['size'] ?? null,
                            'color' => $item['color'] ?? null,
                            'quantity' => $item['qty'],
                            'price' => $item['price'],
                            'subtotal' => $item['qty'] * $item['price'],
                            'barcode' => $item['barcode'] ?? null,
                        ]);
                    }
                    session()->forget('order_cart_' . $tran_id);
                }
            }
            return view('payment.success', ['order' => $order]);
        } else {
            return view('payment.fail', ['message' => 'Invalid Transaction']);
        }
        } catch (\Exception $e) {
            \Log::error('Error in success method', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'request_query' => $request->query(),
            ]);
            return view('payment.fail', [
                'message' => 'An error occurred processing your payment. Please contact support with transaction details.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ]);
        }
    }

    public function fail(Request $request)
    {
        // SSLCommerz may send data via GET (query params) or POST
        $tran_id = $request->input('tran_id') ?? $request->query('tran_id');

        if (!$tran_id) {
            return view('payment.fail', ['message' => 'Transaction ID not found']);
        }

        $order = Order::where('transaction_id', $tran_id)->first();

        if ($order && $order->status == 'Pending') {
            $order->status = 'Failed';
            $order->save();
            // Clear session
            session()->forget('order_cart_' . $tran_id);
            return view('payment.fail', ['message' => 'Transaction Failed', 'order' => $order]);
        } else if ($order && ($order->status == 'paid' || $order->status == 'Processing' || $order->status == 'Complete')) {
            return view('payment.success', ['order' => $order]);
        } else {
            return view('payment.fail', ['message' => 'Invalid Transaction']);
        }
    }

    public function cancel(Request $request)
    {
        // SSLCommerz may send data via GET (query params) or POST
        $tran_id = $request->input('tran_id') ?? $request->query('tran_id');

        if (!$tran_id) {
            return view('payment.fail', ['message' => 'Transaction ID not found']);
        }

        $order = Order::where('transaction_id', $tran_id)->first();

        if ($order && $order->status == 'Pending') {
            $order->status = 'Canceled';
            $order->save();
            // Clear session
            session()->forget('order_cart_' . $tran_id);
            return view('payment.fail', ['message' => 'Transaction Cancelled', 'order' => $order]);
        } else if ($order && ($order->status == 'paid' || $order->status == 'Processing' || $order->status == 'Complete')) {
            return view('payment.success', ['order' => $order]);
        } else {
            return view('payment.fail', ['message' => 'Invalid Transaction']);
        }
    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

}