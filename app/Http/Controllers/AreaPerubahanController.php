<?php

namespace App\Http\Controllers;

use App\Models\AreaPerubahan;
use App\Models\MasterUnitKerja;
use App\Models\RencanaKerja;
use App\Models\SubAreaPerubahan;
use Illuminate\Http\Request;

class AreaPerubahanController extends Controller
{
    //
    public function index(){
        $area = AreaPerubahan::with('subarea')->get();
        $unit = MasterUnitKerja::all();
        return view('contents.areaperubahan.index',compact('area','unit'));
    }

    public function create(){
        $unit = MasterUnitKerja::all();
        return view('contents.areaperubahan.create',compact('unit'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'nama_area_perubahan' => 'required',
            'unit_kerja' => 'required',
        ],[
            'required'=>':attribute tidak boleh kosong'
        ]);

        // dd($request->all());        
        $area = AreaPerubahan::create([
            'nama_area_perubahan' => $request->nama_area_perubahan,            
            'master_unit_kerja_id' => $request->unit_kerja
        ]);

        return redirect()->route('areaperubahan.index')->with('success','Area Perubahan berhasil di tambahkan');

    }

    public function edit($id){
        $area = AreaPerubahan::with('subarea')->where('id',$id)->first();
        return view('contents.areaperubahan.edit',compact('area'));
    }

    public function update(Request $request,$id){
        $area = AreaPerubahan::with('subarea')->where('id',$id)->first();
        $area->nama_area_perubahan = $request->nama_area_perubahan;
        $area->save();
        
        return redirect()->back()->with('success','Area Perubahan berhasil di update');
    }

    public function delete(Request $request){
        $cek = SubAreaPerubahan::where('area_perubahan_id',$request->id)->first();
        $rencana = RencanaKerja::where('area_perubahan_id',$request->id)->first();        
        if ($cek) {
            return redirect()->back()->with('error','Area Perubahan tidak bisa di hapus karena sudah terpakai di sub area atau di rencana kerja');
        }else if($rencana){            
            return redirect()->back()->with('error','Area Perubahan tidak bisa di hapus karena sudah terpakai di sub area atau di rencana kerja');
        }
        AreaPerubahan::where('id',$request->id)->delete();
        return redirect()->back()->with('success','Area Perubahan berhasil di hapus');        

    }
}
