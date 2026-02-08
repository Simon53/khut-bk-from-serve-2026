<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\MainMenu;
use App\Models\Order;
use App\Models\Customer;
use Carbon\Carbon;
use DB;

class HomeController extends Controller
{
    public function homeIndex()
{
    // 🔹 Dashboard stats
    $productCategories = MainMenu::count();
    $totalProducts = Product::count();
    $soldOutProducts = Product::where(function ($q) {
        $q->where('stock_status', 'out_of_stock')
          ->orWhere('sale_price', 'N')
          ->orWhereNull('sale_price');
    })->count();
    $newOrders = Order::whereIn('status', ['pending', 'new'])->count();
    $deliveredOrders = Order::where('delivery_status', 'delivered')->count();
    $deliveryPending = Order::where('delivery_status', 'pending')->count();
    $registeredCustomer = Customer::count();

    // 🔹 Weekly Sale (Last 7 days)
    $weekly = Order::select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('SUM(total) as total')
    )
    ->where('created_at', '>=', \Carbon\Carbon::now()->subDays(6))
    ->groupBy('date')
    ->orderBy('date')
    ->get();

    // 🔹 Monthly Sale (Last 12 months)
    $monthly = Order::select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('YEAR(created_at) as year'),
        DB::raw('SUM(total) as total')
    )
    ->where('created_at', '>=', \Carbon\Carbon::now()->subMonths(11))
    ->groupBy('year','month')
    ->orderBy('year')
    ->orderBy('month')
    ->get();

    // 🔹 Yearly Sale (Last 5 years)
    $yearly = Order::select(
        DB::raw('YEAR(created_at) as year'),
        DB::raw('SUM(total) as total')
    )
    ->where('created_at', '>=', \Carbon\Carbon::now()->subYears(4))
    ->groupBy('year')
    ->orderBy('year')
    ->get();

    // 🔹 Pass all to Blade
    return view('home.home', compact(
        'productCategories',
        'totalProducts',
        'soldOutProducts',
        'newOrders',
        'deliveredOrders',
        'deliveryPending',
        'registeredCustomer',
        'weekly',
        'monthly',
        'yearly'
    ));
}



public function dashboardStats()
{
    return response()->json([
        'productCategories' => MainMenu::count(),
        'totalProducts' => Product::count(),
        'soldOutProducts' => Product::where(function ($q) {
            $q->where('stock_status', 'out_of_stock')
              ->orWhere('sale_price', 'N')
              ->orWhereNull('sale_price');
        })->count(),
        'newOrders' => Order::whereIn('status', ['pending','new'])->count(),
        'deliveredOrders' => Order::where('delivery_status','delivered')->count(),
        'deliveryPending' => Order::where('delivery_status','pending')->count(),
        'registeredCustomer' => Customer::count(),
    ]);
}

}
