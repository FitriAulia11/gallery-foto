@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <h4 class="card-title text-center mb-4">📊 Statistik Komentar Per Bulan</h4>
            <div class="p-3">
                <canvas id="commentsChart" style="max-height: 500px; height: 400px;"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Setup Chart.js
const ctx = document.getElementById('commentsChart').getContext('2d');

// Membuat chart komentar berdasarkan data yang dikirim dari controller
new Chart(ctx, {
    type: 'line',  // Jenis grafik
    data: {
        labels: {!! json_encode($months) !!},  // Label bulan
        datasets: [{
            label: 'Jumlah Komentar',  // Label untuk dataset
            data: {!! json_encode($commentCounts) !!},  // Data jumlah komentar per bulan
            borderColor: '#3498db',  // Warna garis grafik (biru)
            backgroundColor: 'rgba(52, 152, 219, 0.2)',  // Warna latar belakang grafik (biru muda)
            pointBackgroundColor: '#3498db',  // Warna titik grafik
            fill: true,  // Isi area grafik
            tension: 0.4,  // Pengaturan kelengkungan garis
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
                    text: 'Jumlah Komentar'
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
                text: 'Grafik Jumlah Komentar per Bulan',
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
