<?php

namespace App\Http\Controllers;

use App\Models\AreaPerubahan;
use App\Models\MasterUnitKerja;
use App\Models\RencanaKerja;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UnitKerja;
class RencanaKerjaController extends Controller
{
    //
    public function index(){ 
        $rencana = RencanaKerja::orderBy('id',"desc")->get();
        return view('contents.rencanakerja.index',compact('rencana'));
    }

    public function create(){
        $masterUnitKerja = MasterUnitKerja::all();
        $user = User::all();

        return view('contents.rencanakerja.create',compact('masterUnitKerja'));
    }

    public function edit($id){
        $rencana = RencanaKerja::find($id);
        $masterUnitKerja = MasterUnitKerja::all();
        $userUnitKerja = UnitKerja::where('unit_kerja_id', $rencana->master_unit_kerja_id)->get();

        return view('contents.rencanakerja.edit',compact('rencana','masterUnitKerja', 'userUnitKerja'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'master_unit_kerja_id' => 'required',
            'tanggal_waktu' => 'required',
            'realisasi' => 'required',
            'rencana_aksi' => 'required',
            'unit_kerja_id' => 'required',
        ],[
            'required'=>':attribute tidak boleh kosong'
        ]);

        $rk = new RencanaKerja();
        $rk->master_unit_kerja_id = $request->master_unit_kerja_id;
        $rk->tanggal_waktu = $request->tanggal_waktu;
        $rk->realisasi = $request->realisasi;
        $rk->rencana_aksi = $request->rencana_aksi;
        $rk->unit_kerja_id = $request->unit_kerja_id;
        $rk->save();

        return redirect()->route('rencanakerja.index')->with('success','Rencana Kerja Berhasil di simpan');
    }

    public function update(Request $request, $id){
        $this->validate($request,[
            'master_unit_kerja_id' => 'required',
            'tanggal_waktu' => 'required',
            'realisasi' => 'required',
            'rencana_aksi' => 'required',
            'unit_kerja_id' => 'required',
        ],[
            'required'=>':attribute tidak boleh kosong'
        ]);
        $rk = RencanaKerja::with('areaperubahan')->find($id);        
        $rk->master_unit_kerja_id = $request->master_unit_kerja_id;
        $rk->realisasi = $request->realisasi;
        $rk->rencana_aksi = $request->rencana_aksi;
        $rk->unit_kerja_id = $request->unit_kerja_id;
        $rk->save();

        return redirect()->route('rencanakerja.index')->with('success','Rencana Kerja Berhasil di update');
    }

    public function delete(Request $request){
        $rk = RencanaKerja::with('areaperubahan')->find($request->id);        
        $rk->delete();
        return redirect()->route('rencanakerja.index')->with('success','Rencana Kerja Berhasil di hapus');
    }
}
