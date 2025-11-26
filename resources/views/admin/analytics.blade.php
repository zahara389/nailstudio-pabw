@extends('layouts.app-admin') 

@section('content')
<main>
    <div class="head-title">
        <div class="left">
            <h1>Analytics</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="{{ route('analytics.index') }}">Analytics</a></li>
            </ul>
        </div>
    </div>

    <div class="analytics">
        <div class="chart-container">
            <div class="chart-card">
                <h3>Sales Analytics</h3>
                <div class="sales-analytics-scroll">
                    {{-- Canvas dipanggil langsung --}}
                    <canvas id="salesChart"></canvas> 
                </div>
            </div>
            <div class="chart-card">
                <h3>Visitor Statistics</h3>
                <canvas id="visitorChart"></canvas>
            </div>
        </div>
        <div class="chart-container">
            <div class="chart-card">
                <h3>Product Performance</h3>
                <canvas id="productChart"></canvas>
            </div>
            <div class="chart-card">
                <h3>Order Status</h3>
                <canvas id="orderChart"></canvas>
            </div>
        </div>
    </div>
</main>
@endsection

{{-- Pindahkan Chart.js logic ke scripts section --}}
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// --- Sales Analytics (Line Chart) ---
// Data dikirim langsung dari Controller
const labelsSales = @json($bulan);
const dataSales = @json($penjualan);
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: labelsSales,
        datasets: [{
            label: 'Sales ',
            data: dataSales,
            borderColor: '#8B1D3B',
            backgroundColor: 'rgba(139,29,59,0.08)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {scales: {y: {beginAtZero: true}}}
});

// --- Visitor Statistics (Bar Chart) ---
const labelsVisitor = @json($visitor_day);
const dataVisitor = @json($visitor_count);
new Chart(document.getElementById('visitorChart'), {
    type: 'bar',
    data: {
        labels: labelsVisitor,
        datasets: [{
            label: 'Visitors',
            data: dataVisitor,
            backgroundColor: 'rgba(139,29,59,0.2)',
            borderColor: '#8B1D3B',
            borderWidth: 2
        }]
    },
    options: {scales: {y: {beginAtZero: true}}}
});

// --- Product Performance (Doughnut Chart) ---
const productLabel = @json($product_label);
const productQty = @json($product_qty);
const productColors = [
    '#881337', 
    '#be185d', 
    '#e11d48', 
    '#f472b6' 
];
new Chart(document.getElementById('productChart'), {
    type: 'doughnut',
    data: {
        labels: productLabel,
        datasets: [{
            label: 'Product Performance',
            data: productQty,
            backgroundColor: productColors,
            borderWidth: 0
        }]
    },
    options: {
        cutout: '60%',
        plugins: {
            legend: { position: 'right' }
        }
    }
});

// --- Order Status (Pie Chart) ---
const orderStatus = @json($all_status); // Menggunakan all_status dari Controller
const statusCount = @json($status_count);
const statusColors = [
    '#4CAF50', 
    '#FFEB3B', 
    '#2196F3', 
    '#FF5252' 
];
new Chart(document.getElementById('orderChart'), {
    type: 'pie',
    data: {
        labels: orderStatus,
        datasets: [{
            label: 'Order Status',
            data: statusCount,
            backgroundColor: statusColors,
            borderWidth: 0
        }]
    },
    options: {
        plugins: {
            legend: { position: 'right' }
        }
    }
});
</script>
@endsection

{{-- Pindahkan CSS tambahan ke styles section --}}
@section('styles')
<style>
/* Styles for the horizontal scroll in Sales Analytics (Pastikan CSS ini ada di style2.css atau di sini) */
.sales-analytics-scroll {
    width: 100%;
    overflow-x: auto;
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.sales-analytics-scroll canvas {
    width: 250px; /* Set canvas width to allow scrolling */
    height: 250px; /* Set height */
    flex-shrink: 0;
    margin: 0 10px; 
}
/* Tambahkan styles untuk .analytics, .chart-container, .chart-card jika ada */
</style>
@endsection