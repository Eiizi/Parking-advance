<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanParkirExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    // Mengatur Judul Kolom di Excel agar terlihat Profesional
    public function headings(): array
    {
        return [
            'Tanggal Keluar',
            'Pelat Nomor',
            'Jenis Kendaraan',
            'Durasi (Jam)',
            'Total Bayar (Rp)',
        ];
    }

    // Memetakan data dari MongoDB ke Kolom Excel
    public function map($ticket): array
    {
        return [
            $ticket->exit_time->format('d-m-Y H:i'),
            $ticket->plate_number,
            $ticket->vehicle_type,
            $ticket->duration_hours . ' Jam',
            'Rp ' . number_format($ticket->total_price, 0, ',', '.'),
        ];
    }
}