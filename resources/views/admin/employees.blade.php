@extends('admin.layout')

@section('title', 'Manajemen Pegawai')
@section('header_title', 'Daftar Pegawai (Kasir)')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm rounded-r flex items-center gap-3">
        <span class="text-xl">✅</span>
        <p class="font-semibold">{{ session('success') }}</p>
    </div>
@endif

<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Akun Pegawai Terdaftar</h3>
            <p class="text-sm text-slate-500">Kelola akses masuk untuk petugas parkir</p>
        </div>
        <a href="{{ route('admin.employees.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all flex items-center gap-2 shadow-md">
            <span>+</span> Tambah Pegawai Baru
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider border-y border-slate-200">
                    <th class="py-4 px-4 font-semibold">Nama Lengkap</th>
                    <th class="py-4 px-4 font-semibold">Email (Username)</th>
                    <th class="py-4 px-4 font-semibold">Status Role</th>
                    <th class="py-4 px-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-700">
                @forelse($employees as $emp)
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-all">
                    <td class="py-4 px-4 font-bold text-slate-800 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                            {{ substr($emp->name, 0, 1) }}
                        </div>
                        {{ $emp->name }}
                    </td>
                    <td class="py-4 px-4 text-slate-500">{{ $emp->email }}</td>
                    <td class="py-4 px-4">
                        <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                            {{ $emp->role }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pegawai ini secara permanen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-400 hover:text-red-600 font-semibold px-2 transition-colors">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-8 text-center text-slate-400">Belum ada data pegawai yang ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection