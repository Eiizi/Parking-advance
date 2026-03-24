<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800 h-screen overflow-hidden flex">

    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col transition-all">
        <div class="p-6 border-b border-slate-800 flex items-center gap-3">
            <div class="bg-blue-500 text-white p-2 rounded-lg font-bold text-xl">PE</div>
            <h1 class="text-xl font-bold text-white tracking-wide">Dashboard Admin</h1>
        </div>
        
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">
                <span>📊</span> Dashboard
            </a>
            <a href="{{ route('admin.transactions') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.transactions') ? 'bg-blue-600 text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">
                <span>🚗</span> Riwayat Transaksi
            </a>
            <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.reports') ? 'bg-blue-600 text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">
                <span>📑</span> Laporan Keuangan
            </a>
            <a href="{{ route('admin.employees') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.employees') ? 'bg-blue-600 text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">
                <span>👥</span> Manajemen Pegawai
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-slate-800 hover:bg-red-600 hover:text-white px-4 py-3 rounded-xl transition-all text-sm font-semibold">
                    <span>🚪</span> Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full overflow-hidden">
        <header class="bg-white shadow-sm px-8 py-5 flex justify-between items-center z-10">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">@yield('header_title')</h2>
                <p class="text-sm text-slate-500">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-blue-600 font-semibold uppercase tracking-wider">{{ auth()->user()->role }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-slate-200 border-2 border-blue-500 flex items-center justify-center font-bold text-slate-600">
                    AD
                </div>
            </div>
        </header>

        <div class="p-8 overflow-y-auto flex-1">
            @yield('content')
        </div>
    </main>

</body>
</html>