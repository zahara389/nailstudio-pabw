@extends('layouts.app-admin') 

@section('content')
<main>
    <div class="head-title">
        <div class="left">
            <h1>Analytics</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Analytics</a></li>
            </ul>
        </div>
    </div>


    <div class="analytics-container">
        <div class="chart-grid">
            
            <div class="chart-card">
                <div class="chart-header">
                    <h3>Sales Performance</h3>
                    <form action="{{ route('analytics.index') }}" method="GET">
                        <select name="filter" onchange="this.form.submit()" class="filter-select-small">
                            <option value="weeks" {{ $filter == 'weeks' ? 'selected' : '' }}>7 Days</option>
                            <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Month</option>
                            <option value="year" {{ $filter == 'year' ? 'selected' : '' }}>Year</option>
                        </select>
                    </form>
                </div>
                <div class="canvas-wrapper-small">
                    <canvas id="salesChart"></canvas> 
                </div>
            </div>

            <div class="chart-card">
                <h3>Visitors (Last 7 Days)</h3>
                <div class="canvas-wrapper-small">
                    <canvas id="visitorChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3>Top 5 Products</h3>
                <div class="canvas-wrapper-small">
                    <canvas id="productChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3>Order Status</h3>
                <div class="canvas-wrapper-small">
                    <canvas id="orderChart"></canvas>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.color = '#444';
    Chart.defaults.font.family = 'Poppins, sans-serif';

    // 1. Sales Chart
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: @json($bulan),
            datasets: [{
                label: 'Revenue',
                data: @json($penjualan),
                borderColor: '#8B1D3B',
                backgroundColor: 'rgba(139, 29, 59, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // 2. Visitor Chart
    new Chart(document.getElementById('visitorChart'), {
        type: 'bar',
        data: {
            labels: @json($visitor_day),
            datasets: [{
                label: 'Visitors',
                data: @json($visitor_count),
                backgroundColor: '#fbc02d'
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // 3. Product Chart
    new Chart(document.getElementById('productChart'), {
        type: 'doughnut',
        data: {
            labels: @json($product_label),
            datasets: [{
                data: @json($product_qty),
                backgroundColor: ['#881337', '#be185d', '#e11d48', '#f472b6', '#fb7185']
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            plugins: { legend: { position: 'bottom' } } 
        }
    });

    // 4. Order Status Chart
    new Chart(document.getElementById('orderChart'), {
        type: 'pie',
        data: {
            labels: @json($all_status),
            datasets: [{
                data: @json($status_count),
                backgroundColor: ['#2e7d32', '#fbc02d', '#1565c0', '#7b1fa2', '#c62828']
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            plugins: { legend: { position: 'bottom' } } 
        }
    });
</script>
@endsection

@section('styles')
<style>
    /* Hanya Grid Grafik */
    .analytics-container { margin-top: 30px; }
    
    .chart-grid { 
        display: grid; 
        grid-template-columns: repeat(2, 1fr); 
        gap: 25px; 
    }

    .chart-card { 
        background: #fff; 
        padding: 25px; 
        border-radius: 20px; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
    }

    .chart-header { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-bottom: 20px; 
    }

    .chart-card h3 { 
        font-size: 18px; 
        font-weight: 700; 
        color: #333; 
        margin: 0; 
    }
    
    .canvas-wrapper-small { 
        position: relative; 
        height: 300px; 
        width: 100%; 
    }

    .filter-select-small { 
        padding: 6px 12px; 
        border-radius: 8px; 
        border: 1px solid #eee; 
        font-size: 13px; 
        background: #f9f9f9;
        font-weight: 600; 
        cursor: pointer; 
    }

    /* Responsif */
    @media (max-width: 1024px) {
        .chart-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection