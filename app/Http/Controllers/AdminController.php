<?php

namespace App\Http\Controllers;

use App\Models\ParkingTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Exports\LaporanParkirExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index()
{
    
    $activeTickets = ParkingTicket::where('status', 'active')->count();
    $todayTickets = ParkingTicket::where('created_at', '>=', Carbon::today())->count();
    $todayRevenue = ParkingTicket::where('status', 'completed')
                    ->where('exit_time', '>=', Carbon::today())
                    ->sum('total_price');

    
    $recentTransactions = ParkingTicket::where('status', 'completed')
                        ->orderBy('exit_time', 'desc')
                        ->take(3)
                        ->get();

    
    $chartData = [];
    $chartLabels = [];

    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::today()->subDays($i);
        $revenue = ParkingTicket::where('status', 'completed')
                    ->whereDate('exit_time', $date)
                    ->sum('total_price');
        
        $chartLabels[] = $date->translatedFormat('D'); // Nama Hari (Sen, Sel, dst)
        $chartData[] = $revenue;
    }

    return view('admin.dashboard', compact(
        'activeTickets', 
        'todayTickets', 
        'todayRevenue', 
        'recentTransactions',
        'chartData',
        'chartLabels'
    ));
}

    public function transactions()
    {
        //get all transaction
        $transactions = ParkingTicket::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.transactions', compact('transactions'));
    }

    // dashboard money gained
    public function reports(Request $request)
{
  
    $selectedMonth = $request->get('month', date('Y-m'));

    
    $startOfMonth = \Carbon\Carbon::parse($selectedMonth)->startOfMonth();
    $endOfMonth = \Carbon\Carbon::parse($selectedMonth)->endOfMonth();

 
    $reports = ParkingTicket::where('status', 'completed')
                ->whereBetween('exit_time', [$startOfMonth, $endOfMonth])
                ->orderBy('exit_time', 'desc')
                ->get();


    $totalRevenue = $reports->sum('total_price');
    $totalTickets = $reports->count();

    return view('admin.reports', compact('reports', 'totalRevenue', 'totalTickets', 'selectedMonth'));
}

    // dashboard cashier
    public function employees()
    {
        
        $employees = User::where('role', 'pegawai')->get();
        return view('admin.employees', compact('employees'));
    }

    //CRUD ADMIN EMPLOYEE
    public function createEmployee()
    {
        return view('admin.employees_create');
    }

  
    public function storeEmployee(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ], [
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'password.min' => 'Kata sandi minimal harus 6 karakter.'
        ]);

        // savee into database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pegawai' // role always user
        ]);

        // back
        return redirect()->route('admin.employees')->with('success', 'Akun pegawai berhasil ditambahkan!');
    }


    public function destroyEmployee($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role === 'pegawai') {
            $user->delete();
            return redirect()->route('admin.employees')->with('success', 'Akun pegawai berhasil dihapus!');
        }

        return redirect()->route('admin.employees')->with('error', 'Gagal menghapus data.');
    }

    public function exportExcel(Request $request) 
{
    $month = $request->get('month', date('Y-m'));
    $start = \Carbon\Carbon::parse($month)->startOfMonth();
    $end = \Carbon\Carbon::parse($month)->endOfMonth();

    // Ambil data yang sudah selesai (completed) pada bulan tersebut
    $data = \App\Models\ParkingTicket::where('status', 'completed')
            ->whereBetween('exit_time', [$start, $end])
            ->get();

    if ($data->isEmpty()) {
        return back()->with('error', 'Tidak ada data untuk diexport pada bulan ini.');
    }

    return Excel::download(new LaporanParkirExport($data), "Laporan-Parkir-{$month}.xlsx");
}

    
}