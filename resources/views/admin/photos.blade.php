@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <h4 class="card-title text-center mb-4">📸 Statistik Foto per Bulan</h4>
            <div class="p-3">
                <canvas id="photoChart" style="max-height: 500px; height: 400px;"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('photoChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($months) !!},  // Data label bulan
            datasets: [{
                label: 'Jumlah Foto',  // Label dataset
                data: {!! json_encode($photoCounts) !!},  // Data jumlah foto per bulan
                borderColor: '#9b59b6',  // Warna garis (ungu)
                backgroundColor: 'rgba(155, 89, 182, 0.2)',  // Warna latar belakang (ungu transparan)
                pointBackgroundColor: '#9b59b6',  // Warna titik-titik pada grafik
                fill: true,
                tension: 0.4,  // Kelengkungan garis
                borderWidth: 2,  // Menebalkan garis
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
                        text: 'Jumlah Foto'
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
                    text: 'Grafik Jumlah Foto per Bulan',
                    font: {
                        size: 18  // Ukuran font judul lebih besar
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
