<?php

namespace App\Http\Controllers;

use App\Models\ParkingTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        // statistic today
        $today = Carbon::today();
        
        $activeParkings = ParkingTicket::where('status', 'active')->count();
        $todayTickets = ParkingTicket::where('created_at', '>=', $today)->count();
        $todayRevenue = ParkingTicket::where('status', 'completed')
                                     ->where('exit_time', '>=', $today)
                                     ->sum('total_price') ?? 0;

        // transaction past 5
        $recentTransactions = ParkingTicket::where('status', 'completed')
                                           ->orderBy('exit_time', 'desc')
                                           ->take(5)
                                           ->get();

        return view('admin.dashboard', compact('activeParkings', 'todayTickets', 'todayRevenue', 'recentTransactions'));
    }

    public function transactions()
    {
        //get all transaction
        $transactions = ParkingTicket::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.transactions', compact('transactions'));
    }

    // dashboard money gained
    public function reports()
    {
        return view('admin.reports');
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
}