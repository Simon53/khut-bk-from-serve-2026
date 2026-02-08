<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
   public function store(Request $request){
    $cart = json_decode($request->cart, true);

    if(!$cart || count($cart) === 0){
        return response()->json(['success'=>false, 'message'=>'Cart is empty!']);
    }

    // Calculate subtotal
    $subtotal = 0;
    foreach($cart as $item){
        $subtotal += $item['qty'] * $item['price'];
    }

    // Determine delivery charge based on postcode
    $postcode = (int)$request->postcode;
    $delivery = 150; // Default delivery charge
    
    // If postcode is 1000, 1100, or between 1203-1236, delivery charge is 80
    if ($postcode == 1000 || $postcode == 1100 || ($postcode >= 1203 && $postcode <= 1236)) {
        $delivery = 80;
    }

    // Determine order status - COD orders are pending until payment is received
    $status = 'Pending';

    // ✅ Set delivery status for new orders
    $deliveryStatus = 'pending';

    // Create Order
    $order = Order::create([
        'first_name' => $request->first_name,
        'last_name'  => $request->last_name,
        'email'      => $request->email,
        'phone'      => $request->phone,
        'address'    => $request->address,
        'apartment'  => $request->apartment ?? null,
        'district'   => $request->district,
        'city'       => $request->city,
        'postcode'   => $request->postcode,
        'country'    => $request->country ?? 'Bangladesh',
        'notes'      => $request->note ?? null,
        'payment_method' => $request->payment_method,
        'subtotal'   => $subtotal,
        'delivery_charge' => $delivery,
        'total'      => $subtotal + $delivery,
        'status'     => $status,
        'delivery_status' => $deliveryStatus, 
    ]);

    // Insert Order Items
    foreach($cart as $item){
        $order->items()->create([
            'product_id'   => $item['id'] ?? null,
            'product_name' => $item['name'],
            'size'         => $item['size'] ?? null,
            'color'        => $item['color'] ?? null,
            'quantity'     => $item['qty'],
            'price'        => $item['price'],
            'subtotal'     => $item['qty'] * $item['price'],
            'barcode'      => $item['barcode'] ?? null,
        ]);
    }

    // Store order in session for success page
    $request->session()->put('order', $order);
    
    // Clear cart from localStorage will be done on success page
    // Redirect to success page with order ID
    return redirect()->route('payment.success', ['order_id' => $order->id]);
}

}


