<?php

namespace App\Exports\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class RencanaAksiPerMonthSheet implements FromView, WithTitle, ShouldAutoSize
{
    private $name;
    private $data;

    public function __construct($name, $data)
    {
        $this->name = $name;
        $this->data = $data;
    }

    /**
     * @return Builder
     */
    public function view(): View
    {
        $rencana = $this->data;

        return view('exports.rencana_aksi', compact('rencana'));
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->name;
    }
    
}