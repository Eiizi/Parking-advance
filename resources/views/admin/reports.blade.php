@extends('admin.layout')

@section('title', 'Laporan Keuangan')
@section('header_title', 'Laporan Keuangan')

@section('content')
<div class="grid grid-cols-1 gap-6">
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <form action="{{ route('admin.reports') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
            <div class="flex-1 w-full">
                <label class="block text-sm font-semibold text-slate-600 mb-2">Pilih Periode Laporan</label>
                <select name="month" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-700 bg-slate-50/50">
                    @for ($i = 0; $i < 6; $i++)
                        @php $date = \Carbon\Carbon::now()->subMonths($i); @endphp
                        <option value="{{ $date->format('Y-m') }}" {{ $selectedMonth == $date->format('Y-m') ? 'selected' : '' }}>
                            {{ $date->translatedFormat('F Y') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <button type="submit" class="flex-1 md:flex-none bg-slate-800 hover:bg-slate-900 text-white px-8 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-slate-200 flex items-center justify-center gap-2">
                    <span>🔍</span> Tampilkan
                </button>
                
                <a href="{{ route('admin.laporan.export', ['month' => $selectedMonth]) }}" 
                class="flex-1 md:flex-none bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-emerald-100 flex items-center justify-center gap-2 text-center">
                <span>📊</span> Export Excel
                </a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center text-xl">💰</div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase">Total Pendapatan</p>
                <h4 class="text-xl font-bold text-slate-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-xl">🎫</div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase">Total Transaksi</p>
                <h4 class="text-xl font-bold text-slate-800">{{ $totalTickets }} Unit</h4>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold tracking-widest border-b border-slate-100">
                    <th class="py-4 px-6">Tanggal & Waktu</th>
                    <th class="py-4 px-6">Pelat Nomor</th>
                    <th class="py-4 px-6 text-center">Jenis</th>
                    <th class="py-4 px-6 text-center">Durasi</th>
                    <th class="py-4 px-6 text-right">Pendapatan</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-slate-50">
                @forelse($reports as $report)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="py-4 px-6 text-slate-500">
                        {{ \Carbon\Carbon::parse($report->exit_time)->format('d M Y') }}
                        <span class="text-[10px] block text-slate-400">{{ \Carbon\Carbon::parse($report->exit_time)->format('H:i') }} WIB</span>
                    </td>
                    <td class="py-4 px-6 font-bold text-slate-800">{{ $report->plate_number }}</td>
                    <td class="py-4 px-6 text-center">
                        <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase {{ $report->vehicle_type == 'Mobil' ? 'bg-orange-100 text-orange-600' : 'bg-blue-100 text-blue-600' }}">
                            {{ $report->vehicle_type }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-center font-medium">{{ $report->duration_hours }} Jam</td>
                    <td class="py-4 px-6 text-right font-black text-emerald-600">
                        Rp {{ number_format($report->total_price, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-20 text-center">
                        <div class="flex flex-col items-center justify-center text-slate-400">
                            <span class="text-5xl mb-4">🔍</span>
                            <p class="font-bold text-slate-600">Data Tidak Ditemukan</p>
                            <p class="text-xs">Tidak ada transaksi selesai pada bulan yang dipilih.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection