<?php

namespace App\Exports;

use App\Exports\Sheets\RencanaAksiPerMonthSheet;
use App\Models\RencanaKerja;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RencanaAksiExport implements WithMultipleSheets
{
    public $periode_id;

    public function __construct($periode_id)
    {
        $this->periode_id = $periode_id;
    }

    public function sheets(): array
    {
        $sheets = [];

        if ($this->periode_id == 'all') {
            $data = RencanaKerja::all();
        } else {
            $data = RencanaKerja::where('periode_id', $this->periode_id)->get();
        }
        $sheets[] = new RencanaAksiPerMonthSheet("Rekap", $data);

        for ($month = 1; $month <= 12; $month++) {
            $name = Carbon::create()->day(1)->month($month)->format('F');
            if ($this->periode_id == 'all') {
                $data = RencanaKerja::whereMonth('tanggal_waktu', $month)->get();
            } else {
                $data = RencanaKerja::where('periode_id', $this->periode_id)->whereMonth('tanggal_waktu', $month)->get();
            }
            $sheets[] = new RencanaAksiPerMonthSheet($name, $data);
        }

        return $sheets;
    }
    
    // public function view(): View
    // {
        // $rencana = RencanaKerja::where('periode_id', $this->periode_id)->get();

        // return view('exports.rencana_aksi', compact('rencana'));
    // }
}
