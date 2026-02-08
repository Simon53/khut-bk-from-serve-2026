@extends('layout.app')
@section('title', 'Khut::Dashboard')


@section('content')
<div class="container-fluid">

    {{-- Dashboard Stats --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card bg-primary text-white p-3">
                <h5>Product Categories</h5>
                <h3 id="productCategories">{{ $productCategories }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-success text-white p-3">
                <h5>Total Products</h5>
                <h3 id="totalProducts">{{ $totalProducts }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-danger text-white p-3">
                <h5>Sold Out</h5>
                <h3 id="soldOutProducts">{{ $soldOutProducts }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-warning text-dark p-3">
                <h5>New Orders</h5>
                <h3 id="newOrders">{{ $newOrders }}</h3>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card bg-info text-white p-3">
                <h5>Delivered Orders</h5>
                <h3 id="deliveredOrders">{{ $deliveredOrders }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card  text-white p-3" style="background-color:#6a3434;">
                <h5>Pending Delivery</h5>
                <h3 id="deliveryPending">{{ $deliveryPending }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-dark text-white p-3">
                <h5>Registered Customers</h5>
                <h3 id="registeredCustomer">{{ $registeredCustomer }}</h3>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="row mb-4 p-5" style="background-color:#FFF;">
        <div class="col-xl-12" >
            <h5>Weekly Sale</h5>
            <canvas id="weeklyChart" height="100"></canvas>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-6 p-5" style="background-color:#FFF;">
            <h5>Monthly Sale</h5>
            <canvas id="monthlyChart" height="100"></canvas>
        </div>
        <div class="col-xl-6 p-5" style="background-color:#FFF;">
            <h5>Yearly Sale</h5>
            <canvas id="yearlyChart" height="100"></canvas>
        </div>
    </div>
</div>

{{-- Custom CSS for colorful cards --}}
<style>
    .stat-card {
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.2s, box-shadow 0.2s;
        text-align: center;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    .stat-card h5 {
        font-weight: 600;
        margin-bottom: 10px;
    }
    .stat-card h3 {
        font-size: 2rem;
        font-weight: bold;
    }
</style>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Weekly Chart
    const weeklyLabels = {!! json_encode($weekly->pluck('date')) !!};
    const weeklyData   = {!! json_encode($weekly->pluck('total')) !!};

    new Chart(document.getElementById('weeklyChart'), {
        type: 'bar',
        data: {
            labels: weeklyLabels,
            datasets: [{
                label: 'Weekly Sale',
                data: weeklyData,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    // Monthly Chart
    const monthlyLabels = {!! json_encode($monthly->map(fn($m) => $m->year . '-' . str_pad($m->month, 2, '0', STR_PAD_LEFT))) !!};
    const monthlyData   = {!! json_encode($monthly->pluck('total')) !!};

    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Monthly Sale',
                data: monthlyData,
                fill: true,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                tension: 0.1
            }]
        },
        options: { responsive: true }
    });

    // Yearly Chart
    const yearlyLabels = {!! json_encode($yearly->pluck('year')) !!};
    const yearlyData   = {!! json_encode($yearly->pluck('total')) !!};

    new Chart(document.getElementById('yearlyChart'), {
        type: 'line',
        data: {
            labels: yearlyLabels,
            datasets: [{
                label: 'Yearly Sale',
                data: yearlyData,
                fill: true,
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                tension: 0.1
            }]
        },
        options: { responsive: true }
    });
</script>

<script>
    
function loadDashboardStats() {
    fetch('/dashboard/stats')
        .then(res => res.json())
        .then(data => {
            document.getElementById('productCategories').innerText = data.productCategories;
            document.getElementById('totalProducts').innerText = data.totalProducts;
            document.getElementById('soldOutProducts').innerText = data.soldOutProducts;
            document.getElementById('newOrders').innerText = data.newOrders;
            document.getElementById('deliveredOrders').innerText = data.deliveredOrders;
            document.getElementById('deliveryPending').innerText = data.deliveryPending;
            document.getElementById('registeredCustomer').innerText = data.registeredCustomer;
        });
}

setInterval(loadDashboardStats, 5000);
</script>

<script>
let lastUpdate = localStorage.getItem('dashboard_refresh');

setInterval(() => {
    let current = localStorage.getItem('dashboard_refresh');
    if (current && current !== lastUpdate) {
        lastUpdate = current;
        loadDashboardStats(); // 🚀 auto reload stats
    }
}, 1000);
</script>
@endsection
