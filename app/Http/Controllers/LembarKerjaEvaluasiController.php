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

    public function evaluasi(Request $request) {
        // $validate = $this->validate($request,[
        //     'rencana_kerja_id' => 'required|exists:rencana_kerjas,id',
        //     'status' => 'required',
        //     'nilai' => 'required',
        //     'keterangan' => 'required',
        // ],[
        //     'required'=>':attribute tidak boleh kosong'
        // ]);
        
        $rencana = RencanaKerja::find($request->rencana_kerja_id);
        $rencana->status = $request->status;
        $rencana->nilai = $request->nilai;
        $rencana->keterangan = $request->keterangan;
        $rencana->save();

        return redirect()->route('lembarKerjaEvaluasi.index')->with('success','Rencana Kerja Berhasil dievaluasi');
    }
}
