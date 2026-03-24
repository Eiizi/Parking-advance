@extends('admin.layout')

@section('title', 'Tambah Pegawai')
@section('header_title', 'Registrasi Pegawai Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.employees') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-600 transition-all shadow-sm">
            <span>←</span>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Form Identitas Kasir</h2>
            <p class="text-sm text-slate-500">Buat akun agar petugas dapat masuk ke sistem parkir</p>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm border border-red-100">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
        <form action="{{ route('admin.employees.store') }}" method="POST" class="flex flex-col gap-6">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap Petugas</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 outline-none transition-all">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Email (Untuk Username Login)</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="Contoh: budi@elmer.com"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 outline-none transition-all">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi Akses</label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 outline-none transition-all">
            </div>

            <div class="bg-blue-50 border border-blue-100 p-4 rounded-xl flex gap-3 mt-2">
                <span class="text-xl">ℹ️</span>
                <p class="text-sm text-blue-800">Akun ini akan otomatis ditetapkan sebagai <strong>Pegawai (Kasir)</strong> dan tidak dapat mengakses halaman Admin ini.</p>
            </div>

            <hr class="border-slate-100 my-2">

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.employees') }}" class="px-6 py-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-100 transition-all">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-md transform hover:-translate-y-0.5">
                    Simpan Pegawai
                </button>
            </div>
        </form>
    </div>
</div>
@endsection