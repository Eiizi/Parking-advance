@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('header_title', 'Ringkasan Hari Ini')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-2xl">
            🅿️
        </div>
        <div>
            <p class="text-sm text-slate-500 font-medium">Kendaraan Sedang Parkir</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $activeTickets }} <span class="text-sm font-normal text-slate-400">unit</span></h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="w-14 h-14 rounded-full bg-green-50 flex items-center justify-center text-green-600 text-2xl">
            🎫
        </div>
        <div>
            <p class="text-sm text-slate-500 font-medium">Total Tiket Hari Ini</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $todayTickets }} <span class="text-sm font-normal text-slate-400">tiket</span></h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="w-14 h-14 rounded-full bg-orange-50 flex items-center justify-center text-orange-600 text-2xl">
            💰
        </div>
        <div>
            <p class="text-sm text-slate-500 font-medium">Pendapatan Hari Ini</p>
            <h3 class="text-3xl font-bold text-slate-800">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Tren Pendapatan (7 Hari Terakhir)</h3>
        <div class="relative h-72 w-full">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-slate-800">Selesai Terakhir</h3>
            <a href="{{ route('admin.reports') }}" class="text-sm text-blue-600 hover:underline font-medium">Lihat Semua</a>
        </div>
        
        <div class="flex-1">
            @if(isset($recentTransactions) && $recentTransactions->count() > 0)
                <div class="space-y-4">
                    @foreach($recentTransactions as $trx)
                        <div class="flex items-center justify-between p-3 hover:bg-slate-50 rounded-xl transition-all border border-transparent hover:border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg {{ $trx->vehicle_type == 'Mobil' ? 'bg-orange-100 text-orange-600' : 'bg-blue-100 text-blue-600' }} flex items-center justify-center text-lg">
                                    {{ $trx->vehicle_type == 'Mobil' ? '🚗' : '🏍️' }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-sm tracking-wide">{{ $trx->plate_number }}</p>
                                    <p class="text-xs text-slate-500">
                                        {{ $trx->exit_time ? \Carbon\Carbon::parse($trx->exit_time)->format('H:i') : '-' }} WIB
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-green-600 text-sm">+ Rp {{ number_format($trx->total_price, 0, ',', '.') }}</p>
                                <p class="text-xs text-slate-400">{{ $trx->duration_hours }} Jam</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="h-full py-10 flex flex-col items-center justify-center text-slate-400 space-y-2">
                    <span class="text-4xl">📭</span>
                    <p class="text-sm">Belum ada transaksi selesai.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        // Membuat efek gradient pada chart
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

        // Mengambil data dinamis dari Laravel Controller
        const labels = @json($chartLabels);
        const dataUang = @json($chartData);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: dataUang,
                    borderColor: '#3b82f6',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Pendapatan: Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9', drawBorder: false },
                        ticks: {
                            callback: function(value) { 
                                return 'Rp ' + value.toLocaleString('id-ID'); 
                            }
                        }
                    },
                    x: { grid: { display: false, drawBorder: false } }
                }
            }
        });
    });
</script>
@endsection