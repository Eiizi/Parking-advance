<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes pulse-fast {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .animate-pulse-fast { animation: pulse-fast 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 h-screen overflow-hidden flex">

    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col h-screen transition-all border-r border-slate-800 shadow-2xl z-20 shrink-0">
        
        <div class="h-20 border-b border-slate-800/80 flex items-center px-6 bg-slate-900/50 backdrop-blur-sm">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-2.5 rounded-xl font-black text-xl shadow-lg shadow-blue-500/30">PE</div>
            <div class="ml-3">
                <h1 class="text-xl font-bold text-white tracking-wide leading-tight">South <span class="text-blue-400">Gate</span></h1>
                <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Terminal Kasir</p>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto py-6 px-4 flex flex-col gap-8">
            
            <nav class="space-y-2">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 px-2">Menu Utama</p>
                <div class="bg-blue-600/10 border border-blue-500/30 text-blue-400 px-4 py-3 rounded-xl flex items-center gap-3 shadow-inner">
                    <span class="text-xl">🎛️</span>
                    <span class="font-bold tracking-wide">Gate Control</span>
                </div>
            </nav>

            <div class="space-y-4">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest px-2">Informasi Shift</p>
                
                <div class="flex items-center gap-3 text-sm text-emerald-400 font-medium bg-slate-800/40 p-3.5 rounded-xl border border-slate-700/50 shadow-sm">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse-fast shadow-[0_0_8px_rgba(16,185,129,0.8)]"></div>
                    Sistem Online & Sinkron
                </div>

                <div class="bg-gradient-to-b from-slate-800 to-slate-800/40 p-5 rounded-2xl border border-slate-700/50 relative overflow-hidden shadow-lg group">
                    <div class="absolute -right-4 -top-4 text-7xl opacity-5 transform rotate-12 group-hover:scale-110 transition-transform duration-500">💰</div>
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-blue-500"></div>
                    
                    <p class="text-slate-400 text-xs font-semibold mb-1 z-10 relative">Pendapatan Hari Ini</p>
                    <h3 class="text-emerald-400 font-black text-2xl tracking-wide z-10 relative mb-4">
                        <span class="text-sm text-emerald-500/80 mr-1">Rp</span>{{ number_format($todayRevenue ?? 0, 0, ',', '.') }}
                    </h3>
                    
                    <div class="flex items-center justify-between border-t border-slate-700/80 pt-3 z-10 relative">
                        <span class="text-slate-400 text-[11px] font-semibold uppercase tracking-wider">Tiket Selesai</span>
                        <span class="text-white font-bold text-xs bg-slate-700/80 px-2 py-1 rounded border border-slate-600 shadow-inner">
                            {{ $completedTickets ?? 0 }} Unit
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 border-t border-slate-800 bg-slate-900 mt-auto">
            <div class="flex items-center gap-3 px-2 mb-4">
                <div class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center text-blue-400 border border-slate-700 font-black text-sm shadow-inner">
                    {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-200 truncate w-32">{{ auth()->user()->name ?? 'Petugas' }}</p>
                    <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-wider">Kasir Aktif</p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 px-4 py-3.5 rounded-xl transition-all duration-300 text-sm font-bold border border-slate-700 hover:border-rose-500/30 group">
                    <span class="text-lg group-hover:scale-110 transition-transform">🚪</span> 
                    Akhiri Shift (Keluar)
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <header class="h-20 bg-white/80 backdrop-blur-md shadow-sm px-8 flex justify-between items-center z-10 border-b border-slate-200">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Terminal Gerbang Utama</h2>
                <div class="flex items-center gap-2 text-sm font-medium text-slate-500 mt-0.5">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    Shift Aktif: <span class="text-blue-600 font-bold">{{ auth()->user()->name ?? 'Petugas' }}</span>
                </div>
            </div>
            <div class="text-right bg-slate-50 border border-slate-100 px-5 py-2.5 rounded-xl shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-0.5">Waktu Server</p>
                <p class="font-mono text-xl font-bold text-slate-700" id="realtime-clock">00:00:00</p>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-6 lg:p-8">
            
            @if(session('success'))
                <div class="bg-emerald-500 text-white p-4 rounded-xl mb-6 shadow-lg shadow-emerald-500/20 flex items-center justify-between border border-emerald-400">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">✅</span>
                        <p class="font-bold tracking-wide">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.style.display='none'" class="text-white/70 hover:text-white font-bold px-2">✕</button>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-500 text-white p-4 rounded-xl mb-6 shadow-lg shadow-rose-500/20 flex items-center gap-3 border border-rose-400">
                    <span class="text-2xl">⚠️</span>
                    <p class="font-bold tracking-wide">{{ session('error') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
                
                <div class="bg-white rounded-2xl shadow-sm border-t-4 border-t-blue-500 border-x border-b border-slate-200 p-6 flex flex-col relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 text-6xl">📥</div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Gate IN (Kendaraan Masuk)</h3>
                    <p class="text-sm text-slate-500 mb-6">Input pelat nomor untuk mencetak tiket baru.</p>
                    
                    <form action="{{ route('parking.checkin') }}" method="POST" class="flex-1 flex flex-col">
                        @csrf
                        <div class="mb-5 relative">
                            <input type="text" name="plate_number" autofocus required autocomplete="off" placeholder="L 1234 ABC" 
                                class="w-full text-4xl font-black text-center uppercase tracking-widest p-4 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all outline-none text-slate-800 shadow-inner">
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <label class="cursor-pointer relative">
                                <input type="radio" name="vehicle_type" value="Motor" class="peer sr-only" required checked>
                                <div class="p-4 border-2 border-slate-200 rounded-xl text-center peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all hover:bg-slate-50">
                                    <span class="block text-3xl mb-1">🏍️</span>
                                    <span class="font-bold text-slate-700">Motor</span>
                                </div>
                            </label>
                            <label class="cursor-pointer relative">
                                <input type="radio" name="vehicle_type" value="Mobil" class="peer sr-only" required>
                                <div class="p-4 border-2 border-slate-200 rounded-xl text-center peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all hover:bg-slate-50">
                                    <span class="block text-3xl mb-1">🚗</span>
                                    <span class="font-bold text-slate-700">Mobil</span>
                                </div>
                            </label>
                        </div>
                        
                        <button type="submit" class="mt-auto w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 px-8 rounded-xl text-lg shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-1 active:translate-y-0 flex justify-center items-center gap-2">
                            <span>CETAK TIKET MASUK</span>
                        </button>
                    </form>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border-t-4 border-t-rose-500 border-x border-b border-slate-200 p-6 flex flex-col relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 text-6xl">📤</div>
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 mb-1">Gate OUT (Kendaraan Keluar)</h3>
                            <p class="text-sm text-slate-500">Scan barcode tiket atau pilih dari monitor.</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('parking.checkout') }}" method="POST" class="flex flex-col gap-4 mt-auto">
                        @csrf
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-2xl">📷</div>
                            <input type="text" name="ticket_code" placeholder="Scan Tiket / Ketik Pelat..." required autocomplete="off"
                            class="w-full pl-12 pr-4 py-5 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-rose-500 focus:ring-4 focus:ring-rose-500/20 outline-none text-xl font-mono font-bold text-slate-700 transition-all shadow-inner">
                        </div>
                        <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-black py-4 px-6 rounded-xl text-lg shadow-lg shadow-slate-800/20 transition-all transform hover:-translate-y-1 active:translate-y-0">
                            PROSES CHECK-OUT
                        </button>
                    </form>
                </div>
            </div>

        

            @php
                //min max car and motorcyle and location
                $activeCars = isset($activeTickets) ? $activeTickets->where('vehicle_type', 'Mobil')->values() : collect([]);
                $activeMotors = isset($activeTickets) ? $activeTickets->where('vehicle_type', 'Motor')->values() : collect([]);
                
                //min max car and motocyle
                $maxCars = 24;
                $maxMotors = 15;
            @endphp

            <div class="flex flex-col gap-8">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-orange-500 animate-pulse-fast shadow-lg shadow-orange-500/50"></div>
                            <h3 class="text-lg font-bold text-slate-800 tracking-wide">ZONA A: Parkir Mobil</h3>
                        </div>
                        <div class="bg-orange-50 text-orange-700 px-3 py-1 rounded-lg text-sm font-bold border border-orange-200">
                            Terisi: {{ $activeCars->count() }} / {{ $maxCars }}
                        </div>
                    </div>

                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3">
                        @for($i = 0; $i < $maxCars; $i++)
                            @if(isset($activeCars[$i]))
                                <div class="group relative bg-white border-2 border-orange-300 hover:border-orange-500 rounded-xl p-3 flex flex-col items-center justify-center text-center transition-all hover:shadow-md overflow-hidden min-h-[110px]">
                                    <div class="absolute inset-x-0 top-0 h-1.5 bg-orange-400"></div>
                                    <div class="text-3xl mb-1 transform group-hover:scale-110 transition-transform duration-300">🚗</div>
                                    <h4 class="text-[11px] font-black text-slate-800 tracking-wider mb-1">{{ $activeCars[$i]->plate_number }}</h4>
                                    <div class="bg-slate-100 border border-slate-200 rounded px-1.5 py-0.5 text-[9px] font-mono font-bold text-slate-500 w-full truncate">
                                        {{ $activeCars[$i]->ticket_code }}
                                    </div>

                                    <div class="absolute inset-0 bg-slate-900/90 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center p-2">
                                        <form action="{{ route('parking.checkout') }}" method="POST" class="w-full">
                                            @csrf
                                            <input type="hidden" name="ticket_code" value="{{ $activeCars[$i]->ticket_code }}">
                                            <button type="submit" class="w-full bg-rose-500 hover:bg-rose-600 text-white text-xs font-bold py-2 rounded-lg shadow-lg">
                                                Keluar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="border-2 border-dashed border-slate-200 bg-slate-50/50 rounded-xl p-3 flex flex-col items-center justify-center text-center min-h-[110px] opacity-70">
                                    <span class="text-2xl opacity-20 mb-1 filter grayscale">🚗</span>
                                    <span class="text-xs font-black text-slate-400">A-{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="text-[9px] font-bold text-emerald-500 mt-1 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">KOSONG</span>
                                </div>
                            @endif
                        @endfor
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-blue-500 animate-pulse-fast shadow-lg shadow-blue-500/50"></div>
                            <h3 class="text-lg font-bold text-slate-800 tracking-wide">ZONA B: Parkir Motor</h3>
                        </div>
                        <div class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg text-sm font-bold border border-blue-200">
                            Terisi: {{ $activeMotors->count() }} / {{ $maxMotors }}
                        </div>
                    </div>

                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-8 gap-3">
                        @for($i = 0; $i < $maxMotors; $i++)
                            @if(isset($activeMotors[$i]))
                                <div class="group relative bg-white border-2 border-blue-300 hover:border-blue-500 rounded-xl p-3 flex flex-col items-center justify-center text-center transition-all hover:shadow-md overflow-hidden min-h-[110px]">
                                    <div class="absolute inset-x-0 top-0 h-1.5 bg-blue-400"></div>
                                    <div class="text-3xl mb-1 transform group-hover:scale-110 transition-transform duration-300">🏍️</div>
                                    <h4 class="text-[11px] font-black text-slate-800 tracking-wider mb-1">{{ $activeMotors[$i]->plate_number }}</h4>
                                    <div class="bg-slate-100 border border-slate-200 rounded px-1.5 py-0.5 text-[9px] font-mono font-bold text-slate-500 w-full truncate">
                                        {{ $activeMotors[$i]->ticket_code }}
                                    </div>

                                    <div class="absolute inset-0 bg-slate-900/90 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center p-2">
                                        <form action="{{ route('parking.checkout') }}" method="POST" class="w-full">
                                            @csrf
                                            <input type="hidden" name="ticket_code" value="{{ $activeMotors[$i]->ticket_code }}">
                                            <button type="submit" class="w-full bg-rose-500 hover:bg-rose-600 text-white text-xs font-bold py-2 rounded-lg shadow-lg">
                                                Keluar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="border-2 border-dashed border-slate-200 bg-slate-50/50 rounded-xl p-3 flex flex-col items-center justify-center text-center min-h-[110px] opacity-70">
                                    <span class="text-2xl opacity-20 mb-1 filter grayscale">🏍️</span>
                                    <span class="text-xs font-black text-slate-400">B-{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="text-[9px] font-bold text-emerald-500 mt-1 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">KOSONG</span>
                                </div>
                            @endif
                        @endfor
                    </div>
                </div>

            </div>

        </div>
    </main>

    <script>
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            document.getElementById('realtime-clock').innerText = timeString;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>