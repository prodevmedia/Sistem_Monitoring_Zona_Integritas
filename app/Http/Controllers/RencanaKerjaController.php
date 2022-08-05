<?php

namespace App\Http\Controllers;

use App\Exports\RencanaAksiExport;
use App\Models\MasterUnitKerja;
use App\Models\Periode;
use App\Models\RencanaKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RencanaKerjaController extends Controller
{
    //
    public function index(){ 
        $rencana = RencanaKerja::orderBy('id',"desc")->get();
        $periode = Periode::orderBy('tahun',"desc")->get();

        return view('contents.rencanakerja.index',compact('rencana', 'periode'));
    }

    public function create(){
        $masterUnitKerja = MasterUnitKerja::all();
        $user = User::all();
        $periode = Periode::where('is_active', 1)->get();

        if ($periode == null) {
            return redirect()->back()->with('error','Silahkan tambah periode terlebih dahulu');
        }

        return view('contents.rencanakerja.create',compact('masterUnitKerja', 'periode'));
    }

    public function edit($id){
        $rencana = RencanaKerja::find($id);
        $masterUnitKerja = MasterUnitKerja::all();
        $periode = Periode::where('is_active', 1)->get();

        return view('contents.rencanakerja.edit',compact('rencana','masterUnitKerja', 'periode'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'master_unit_kerja_id' => 'required',
            'tanggal_waktu' => 'required',
            'rencana_aksi' => 'required',
            'periode_id' => 'required'
        ],[
            'required'=>':attribute tidak boleh kosong'
        ]);

        $rk = new RencanaKerja();
        $rk->master_unit_kerja_id = $request->master_unit_kerja_id;
        $rk->tanggal_waktu = $request->tanggal_waktu;
        $rk->rencana_aksi = $request->rencana_aksi;
        $rk->periode_id = $request->periode_id;
        $rk->save();

        return redirect()->route('rencanakerja.index')->with('success','Rencana Kerja Berhasil di simpan');
    }

    public function update(Request $request, $id){
        $this->validate($request,[
            'master_unit_kerja_id' => 'required',
            'tanggal_waktu' => 'required',
            'rencana_aksi' => 'required',
            'periode_id' => 'required'
        ],[
            'required'=>':attribute tidak boleh kosong'
        ]);

        $rk = RencanaKerja::find($id);        
        $rk->master_unit_kerja_id = $request->master_unit_kerja_id;
        $rk->tanggal_waktu = $request->tanggal_waktu;
        $rk->rencana_aksi = $request->rencana_aksi;
        $rk->periode_id = $request->periode_id;
        $rk->save();

        return redirect()->route('rencanakerja.index')->with('success','Rencana Kerja Berhasil di update');
    }

    public function delete(Request $request){
        $rk = RencanaKerja::find($request->id);
        // cek apakah id master unit kerja tersebut ada
        if ($rk) {
            // cek apakah master unit kerja mempunyai user
            // jika iya tidak dapat dihapus
            if ($rk->fileuploads->count() > 0) {
                return response()->json([
                    "status" => 400,
                    "message" => "Tidak bisa di hapus karena sudah ada file upload"
                ]);    
            } else {
                $rk->delete();
                return response()->json([
                    "status" => 200,
                    "message" => "Rencana kerja berhasil di hapus"
                ]);    
            }
        } else {
            return response()->json([
                "status" => 400,
                "message" => "Rencana kerja tidak ditemukan"
            ]);    
        }
        $rk->delete();
        return redirect()->route('rencanakerja.index')->with('success','Rencana Kerja Berhasil di hapus');
    }

    public function print(Request $request)
    {
        $periode_id = $request->periode_id;

        if ($periode_id == 'all') {
            $tahun = 'Semua';
        } else {
            $periode = Periode::find($periode_id);
            if ($periode == null) {
                return redirect()->back()->with('error','Periode tidak ditemukan');
            }
            
            $tahun = $periode->tahun;
        }

        return Excel::download(new RencanaAksiExport($periode_id), 'Rencana Aksi ' . $tahun . '.xlsx');
    }
}
