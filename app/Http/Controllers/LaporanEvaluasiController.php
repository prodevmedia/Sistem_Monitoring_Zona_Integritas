<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use App\Models\ScoringAreaPerubahan;
use App\Models\ScoringMasterUnitKerja;
use App\Models\ScoringPengungkit;
use App\Models\ScoringSubAreaPerubahan;
use App\Models\UnitKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanEvaluasiController extends Controller
{
    //
    public function index(){
        $file = FileUpload::with(['user','points'])->get();
        return view('contents.laporanevaluasi.index',compact('file'));
    }

    public function berinilai($id,$fileid){
        $user = UnitKerja::where('id',$id)->with('masterunitkerja','file','masterunitkerja.areaperubahan','masterunitkerja.areaperubahan.subarea')->whereHas('file', function($query) use($fileid){
            $query->where('id',$fileid);
        })->first();
        $tanggal = [];
        $now = (int) Carbon::now()->format('Y');
        // Prepend
        $tgl = $now;
        for ($i=0; $i < 10 ; $i++) { 
            $tgl = $tgl - 1;
            array_push($tanggal,$tgl);
        }    
        $tgl = $now;
        for ($i=0; $i < 10 ; $i++) { 
            $tgl = $tgl + 1;
            array_push($tanggal,$tgl);
        }    
        array_push($tanggal,$now);    
        sort($tanggal);
        return view('contents.laporanevaluasi.berinilai',compact('user','tanggal'));
    }
    
    public function edit($id,$fileid){
        $tanggal = [];
        $now = (int) Carbon::now()->format('Y');
        // Prepend
        $tgl = $now;
        for ($i=0; $i < 10 ; $i++) { 
            $tgl = $tgl - 1;
            array_push($tanggal,$tgl);
        }    
        $tgl = $now;
        for ($i=0; $i < 10 ; $i++) { 
            $tgl = $tgl + 1;
            array_push($tanggal,$tgl);
        }    
        array_push($tanggal,$now);    
        sort($tanggal);
        $user = UnitKerja::where('id',$id)->with('masterunitkerja','file','masterunitkerja.areaperubahan','masterunitkerja.areaperubahan.subarea')->whereHas('file', function($query) use($fileid){
            $query->where('id',$fileid);
        })->first();        
        return view('contents.laporanevaluasi.edit',compact('user','id','fileid','tanggal'));
    }

    public function show($id,$fileid){
        $user = UnitKerja::where('id',$id)->with('masterunitkerja','file','masterunitkerja.areaperubahan','masterunitkerja.areaperubahan.subarea')->whereHas('file', function($query) use($fileid){
            $query->where('id',$fileid);
        })->first(); 
        $cek = ScoringPengungkit::where('unit_kerja_id',$id)->where('file_id',$fileid)->first();
        if (!$cek) {
            return redirect()->back()->with('error','Belum diberi nilai');
        }
        return view('contents.laporanevaluasi.show',compact('user','id','fileid'));
    }

    public function store(Request $request){                        

        $sp = new ScoringPengungkit();
        $sp->type = $request->type;
        $sp->tahun = $request->tahun;
        $sp->unit_kerja_id = $request->user_id;
        $sp->file_id = $request->file_id;
        $sp->bobot = $request['pengungkit']['bobot'];
        $sp->penjelasan = $request['pengungkit']['penjelasan'];
        $sp->pilihan_jawaban = $request['pengungkit']['pilihan_jawaban'];
        $sp->jawaban = $request['pengungkit']['jawaban'];
        $sp->nilai = $request['pengungkit']['nilai'];
        $sp->presentase = $request['pengungkit']['presentase'];
        $sp->save();

        $mu = new ScoringMasterUnitKerja();
        $mu->type = $request->type;
        $mu->tahun = $request->tahun;
        $mu->unit_kerja_id = $request->user_id;
        $mu->file_id = $request->file_id;
        $mu->bobot = $request['masterunitkerja']['bobot'];
        $mu->penjelasan = $request['masterunitkerja']['penjelasan'];
        $mu->pilihan_jawaban = $request['masterunitkerja']['pilihan_jawaban'];
        $mu->jawaban = $request['masterunitkerja']['jawaban'];
        $mu->nilai = $request['masterunitkerja']['nilai'];
        $mu->presentase = $request['masterunitkerja']['presentase'];
        $mu->save();

        foreach ($request['areaperubahan']['id'] as $key => $value) {
            $a = new ScoringAreaPerubahan();
            $a->type = $request->type;
            $a->tahun = $request->tahun;
            $a->unit_kerja_id = $request->user_id;
            $a->file_id = $request->file_id;
            $a->area_perubahan_id = $value;
            $a->bobot = $request['areaperubahan']['bobot'][$key];
            $a->penjelasan = $request['areaperubahan']['penjelasan'][$key];
            $a->pilihan_jawaban = $request['areaperubahan']['pilihan_jawaban'][$key];
            $a->jawaban = $request['areaperubahan']['jawaban'][$key];
            $a->nilai = $request['areaperubahan']['nilai'][$key];
            $a->presentase = $request['areaperubahan']['presentase'][$key];
            $a->save();

            foreach ($request['subareaperubahan']['id'] as $key2 => $value2) {                
                if (array_key_exists($value,$request['subareaperubahan']['id'][$key2])) {                    
                    $s = new ScoringSubAreaPerubahan();
                    $s->type = $request->type;
                    $s->tahun = $request->tahun;
                    $s->unit_kerja_id = $request->user_id;
                    $s->file_id = $request->file_id;
                    $s->area_perubahan_id = $value;
                    $s->sub_area_perubahan_id = $request['subareaperubahan']['id'][$key2][$value];
                    $s->bobot = $request['subareaperubahan']['bobot'][$key2][$value];            
                    $s->jawaban = $request['subareaperubahan']['jawaban'][$key2][$value];
                    $s->nilai = $request['subareaperubahan']['nilai'][$key2][$value];
                    $s->presentase = $request['subareaperubahan']['presentase'][$key2][$value];               
                    $s->save();
                }
            }
        }

        return redirect()->route('laporanevaluasi.index')->with('success','Berhasil di berikan nilai');
    }
    
    public function update(Request $request){
        $sp = ScoringPengungkit::where('unit_kerja_id',$request->user_id)->where('file_id',$request->file_id)->first();
        $sp->type = $request->type;
        $sp->tahun = $request->tahun;
        $sp->unit_kerja_id = $request->user_id;
        $sp->file_id = $request->file_id;
        $sp->bobot = $request['pengungkit']['bobot'];
        $sp->penjelasan = $request['pengungkit']['penjelasan'];
        $sp->pilihan_jawaban = $request['pengungkit']['pilihan_jawaban'];
        $sp->jawaban = $request['pengungkit']['jawaban'];
        $sp->nilai = $request['pengungkit']['nilai'];
        $sp->presentase = $request['pengungkit']['presentase'];
        $sp->save();

        $mu = ScoringMasterUnitKerja::where('unit_kerja_id',$request->user_id)->where('file_id',$request->file_id)->first();
        $mu->type = $request->type;
        $mu->tahun = $request->tahun;
        $mu->unit_kerja_id = $request->user_id;
        $mu->file_id = $request->file_id;
        $mu->bobot = $request['masterunitkerja']['bobot'];
        $mu->penjelasan = $request['masterunitkerja']['penjelasan'];
        $mu->pilihan_jawaban = $request['masterunitkerja']['pilihan_jawaban'];
        $mu->jawaban = $request['masterunitkerja']['jawaban'];
        $mu->nilai = $request['masterunitkerja']['nilai'];
        $mu->presentase = $request['masterunitkerja']['presentase'];
        $mu->save();

        foreach ($request['areaperubahan']['id'] as $key => $value) {
            $a = ScoringAreaPerubahan::where('unit_kerja_id',$request->user_id)->where('area_perubahan_id',$value)->where('file_id',$request->file_id)->first();
            $a->type = $request->type;
            $a->tahun = $request->tahun;
            $a->unit_kerja_id = $request->user_id;
            $a->file_id = $request->file_id;
            $a->area_perubahan_id = $value;
            $a->bobot = $request['areaperubahan']['bobot'][$key];
            $a->penjelasan = $request['areaperubahan']['penjelasan'][$key];
            $a->pilihan_jawaban = $request['areaperubahan']['pilihan_jawaban'][$key];
            $a->jawaban = $request['areaperubahan']['jawaban'][$key];
            $a->nilai = $request['areaperubahan']['nilai'][$key];
            $a->presentase = $request['areaperubahan']['presentase'][$key];
            $a->save();

            foreach ($request['subareaperubahan']['id'] as $key2 => $value2) {                
                if (array_key_exists($value,$request['subareaperubahan']['id'][$key2])) {                    
                    $s = ScoringSubAreaPerubahan::where('unit_kerja_id',$request->user_id)->where('sub_area_perubahan_id',$value2)->where('area_perubahan_id',$value)->where('file_id',$request->file_id)->first();
                    $s->type = $request->type;
                    $s->tahun = $request->tahun;
                    $s->unit_kerja_id = $request->user_id;
                    $s->file_id = $request->file_id;
                    $s->area_perubahan_id = $value;
                    $s->sub_area_perubahan_id = $request['subareaperubahan']['id'][$key2][$value];
                    $s->bobot = $request['subareaperubahan']['bobot'][$key2][$value];            
                    $s->jawaban = $request['subareaperubahan']['jawaban'][$key2][$value];
                    $s->nilai = $request['subareaperubahan']['nilai'][$key2][$value];
                    $s->presentase = $request['subareaperubahan']['presentase'][$key2][$value];               
                    $s->save();
                }
            }
        }

        return redirect()->route('laporanevaluasi.index')->with('success','Berhasil di update nilainya');
    }

    public function destroy(Request $request){
        $sp = ScoringPengungkit::where('unit_kerja_id',$request->user_id)->where('file_id',$request->file_id)->delete();            
        $mu = ScoringMasterUnitKerja::where('unit_kerja_id',$request->user_id)->where('file_id',$request->file_id)->delete();                
        $a = ScoringAreaPerubahan::where('unit_kerja_id',$request->user_id)->where('file_id',$request->file_id)->delete();            
        $s = ScoringSubAreaPerubahan::where('unit_kerja_id',$request->user_id)->where('file_id',$request->file_id)->delete();            
        return redirect()->route('laporanevaluasi.index')->with('success','Silahkan beri nilai kembali');
    }
}
