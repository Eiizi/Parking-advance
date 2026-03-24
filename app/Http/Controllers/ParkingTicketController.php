<?php

namespace App\Http\Controllers;

use App\Models\ParkingTicket;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ParkingTicketController extends Controller
{
    // dashboard
  public function index()
    {
        
        $activeTickets = ParkingTicket::where('status', 'active')->orderBy('created_at', 'desc')->get();
        
       
        $today = Carbon::today();
        
        $todayRevenue = ParkingTicket::where('status', 'completed')
            ->where('exit_time', '>=', $today)
            ->sum('total_price') ?? 0;
            
        $completedTickets = ParkingTicket::where('status', 'completed')
            ->where('exit_time', '>=', $today)
            ->count();

        return view('parking.index', compact('activeTickets', 'todayRevenue', 'completedTickets'));
    }

    // In vehicle
    public function checkIn(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string|max:15',
            'vehicle_type' => 'required|in:Motor,Mobil'
        ]);

        // Generate kode tiket unik 
        $ticketCode = 'PRK-' . date('ymd') . '-' . strtoupper(Str::random(4));

        ParkingTicket::create([
            'ticket_code' => $ticketCode,
            'plate_number' => strtoupper($request->plate_number),
            'vehicle_type' => $request->vehicle_type,
            'status' => 'active',
            'entry_time' => Carbon::now(),
            'history' => [
                'check_in_by' => 'Admin' 
            ]
        ]);

        return redirect()->back()->with('success', 'Tiket berhasil dicetak: ' . $ticketCode);
    }

    // GTFO vehicle
    public function checkOut(Request $request)
    {
       
        $inputData = $request->ticket_code;

       //search car number
        $ticket = ParkingTicket::where('status', 'active')
            ->where(function($query) use ($inputData) {
                $query->where('ticket_code', $inputData)
                      ->orWhere('plate_number', strtoupper($inputData)); // Ubah input jadi huruf besar
            })
            ->first();

        if (!$ticket) {
            return redirect()->back()->with('error', 'Kendaraan tidak ditemukan atau sudah keluar.');
        }

        // tariff
        $exitTime = Carbon::now();
        $entryTime = Carbon::parse($ticket->entry_time);
        
        // counting paymennt
        $durationHours = ceil($entryTime->diffInMinutes($exitTime) / 60);
        $durationHours = $durationHours > 0 ? $durationHours : 1; // Minimal 1 jam

        $ratePerHour = $ticket->vehicle_type == 'Mobil' ? 5000 : 2000;
        $totalPrice = $durationHours * $ratePerHour;

        // Update DB
        $ticket->update([
            'status' => 'completed',
            'exit_time' => $exitTime,
            'duration_hours' => $durationHours,
            'total_price' => $totalPrice
        ]);

        return redirect()->back()->with('success', "Kendaraan keluar. Total Tarif: Rp " . number_format($totalPrice, 0, ',', '.'));
    }
}