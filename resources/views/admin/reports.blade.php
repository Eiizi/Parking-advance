@extends('admin.layout')

@section('title', 'Laporan Keuangan')
@section('header_title', 'Laporan Keuangan')

@section('content')
<div class="grid grid-cols-1 gap-6">
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex gap-4 items-end">
        <div class="flex-1">
            <label class="block text-sm font-semibold text-slate-600 mb-2">Pilih Bulan</label>
            <select class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500 text-slate-700">
                <option>Maret 2026</option>
                <option>Februari 2026</option>
                <option>Januari 2026</option>
            </select>
        </div>
        <button class="bg-slate-800 hover:bg-slate-900 text-white px-6 py-2 rounded-lg font-semibold transition-all h-fit">
            Tampilkan Data
        </button>
        <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition-all h-fit flex items-center gap-2">
            <span>⬇️</span> Export Excel
        </button>
    </div>

    <div class="bg-white p-12 rounded-2xl shadow-sm border border-slate-100 flex flex-col items-center justify-center text-slate-400">
        <span class="text-6xl mb-4">📑</span>
        <h3 class="text-xl font-bold text-slate-700 mb-2">Modul Laporan Keuangan</h3>
        <p class="text-center max-w-md">Pilih bulan pada filter di atas untuk melihat rincian pendapatan, grafik harian, dan ringkasan pajak secara mendetail.</p>
    </div>

</div>
@endsection