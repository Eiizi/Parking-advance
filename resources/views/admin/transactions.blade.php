@extends('admin.layout')

@section('title', 'Riwayat Transaksi')
@section('header_title', 'Semua Riwayat Transaksi')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col">
    
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-slate-800">Database Tiket Parkir</h3>
        <div class="flex gap-2">
            <input type="text" placeholder="Cari Pelat Nomor..." class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500 text-sm">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all">Cari</button>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider border-y border-slate-200">
                    <th class="py-4 px-4 font-semibold">Kode Tiket</th>
                    <th class="py-4 px-4 font-semibold">Pelat Nomor</th>
                    <th class="py-4 px-4 font-semibold text-center">Kendaraan</th>
                    <th class="py-4 px-4 font-semibold">Waktu Masuk</th>
                    <th class="py-4 px-4 font-semibold">Waktu Keluar</th>
                    <th class="py-4 px-4 font-semibold">Status</th>
                    <th class="py-4 px-4 font-semibold text-right">Tarif (Rp)</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-700">
                @forelse($transactions as $trx)
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-all">
                    <td class="py-4 px-4 font-mono text-slate-500">{{ $trx->ticket_code }}</td>
                    <td class="py-4 px-4 font-bold text-slate-800">{{ $trx->plate_number }}</td>
                    <td class="py-4 px-4 text-center text-xl">{{ $trx->vehicle_type == 'Mobil' ? '🚗' : '🏍️' }}</td>
                    <td class="py-4 px-4">{{ \Carbon\Carbon::parse($trx->entry_time)->format('d/m/Y H:i') }}</td>
                    <td class="py-4 px-4">
                        {{ $trx->exit_time ? \Carbon\Carbon::parse($trx->exit_time)->format('d/m/Y H:i') : '-' }}
                    </td>
                    <td class="py-4 px-4">
                        @if($trx->status == 'active')
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">PARKIR</span>
                        @else
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">SELESAI</span>
                        @endif
                    </td>
                    <td class="py-4 px-4 text-right font-bold {{ $trx->total_price ? 'text-green-600' : 'text-slate-400' }}">
                        {{ $trx->total_price ? number_format($trx->total_price, 0, ',', '.') : '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-8 text-center text-slate-400">Belum ada data transaksi tersimpan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $transactions->links() }}
    </div>

</div>
@endsection