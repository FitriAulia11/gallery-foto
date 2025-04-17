@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <h4 class="card-title text-center mb-4">📈 Statistik Like Per Bulan</h4>
            <div class="p-3">
                <canvas id="likeChart" style="max-height: 500px; height: 400px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- CDN Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Setup Chart.js
const ctx = document.getElementById('likeChart').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($months) !!}, // Misalnya: ["Jan", "Feb", "Mar", ...]
        datasets: [{
            label: 'Jumlah Like',
            data: {!! json_encode($likeCounts) !!}, // Misalnya: [10, 20, 15, ...]
            borderColor: '#e74c3c',
            backgroundColor: 'rgba(231, 76, 60, 0.2)',
            pointBackgroundColor: '#e74c3c',
            fill: true,
            tension: 0.4,
            borderWidth: 2, // Menebalkan garis
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                },
                title: {
                    display: true,
                    text: 'Jumlah Like'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Bulan'
                }
            }
        },
        plugins: {
            title: {
                display: true,
                text: 'Grafik Jumlah Like per Bulan',
                font: {
                    size: 18 // Membuat judul lebih besar
                }
            },
            tooltip: {
                mode: 'index',
                intersect: false
            },
            legend: {
                display: true,
                position: 'top',
                labels: {
                    color: '#333'
                }
            }
        }
    }
});
</script>
@endsection
