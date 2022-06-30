<?php

namespace App\Http\Controllers;

use App\Models\AreaPerubahan;
use App\Models\RencanaKerja;
use Illuminate\Http\Request;

class RencanaKerjaController extends Controller
{
    //
    public function index(){ 
        $rencana = RencanaKerja::with('areaperubahan')->orderBy('id',"desc")->get();
        return view('contents.rencanakerja.index',compact('rencana'));
    }

    public function create(){
        $area = AreaPerubahan::all();
        return view('contents.rencanakerja.create',compact('area'));
    }

    public function edit($id){
        $rencana = RencanaKerja::with('areaperubahan')->find($id);
        $area = AreaPerubahan::all();
        return view('contents.rencanakerja.edit',compact('rencana','area'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'area_perubahan' => 'required',
            'tanggal_waktu' => 'required',
            'realisasi' => 'required',
            'rencana_aksi' => 'required',
        ],[
            'required'=>':attribute tidak boleh kosong'
        ]);
        $rk = new RencanaKerja();
        $rk->area_perubahan_id = $request->area_perubahan;
        $rk->tanggal_waktu = $request->tanggal_waktu;
        $rk->realisasi = $request->realisasi;
        $rk->rencana_aksi = $request->rencana_aksi;
        $rk->save();

        return redirect()->route('rencanakerja.index')->with('success','Rencana Kerja Berhasil di simpan');
    }

    public function update(Request $request, $id){
        $this->validate($request,[
            'area_perubahan' => 'required',
            'tanggal_waktu' => 'required',
            'realisasi' => 'required',
            'rencana_aksi' => 'required',
        ],[
            'required'=>':attribute tidak boleh kosong'
        ]);
        $rk = RencanaKerja::with('areaperubahan')->find($id);        
        $rk->area_perubahan_id = $request->area_perubahan;
        $rk->realisasi = $request->realisasi;
        $rk->rencana_aksi = $request->rencana_aksi;
        $rk->save();

        return redirect()->route('rencanakerja.index')->with('success','Rencana Kerja Berhasil di update');
    }

    public function delete(Request $request){
        $rk = RencanaKerja::with('areaperubahan')->find($request->id);        
        $rk->delete();
        return redirect()->route('rencanakerja.index')->with('success','Rencana Kerja Berhasil di hapus');
    }
}
