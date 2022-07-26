<?php

namespace App\Http\Controllers;

use App\Models\RencanaKerja;
use Illuminate\Http\Request;

class LembarKerjaEvaluasiController extends Controller
{
    public function index(Request $request)
    {
        $rencana = RencanaKerja::orderBy('id',"desc")->get();

        return view('contents.lembarkerjaevaluasi.index', compact('rencana'));    
    }
}
