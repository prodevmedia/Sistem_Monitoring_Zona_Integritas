<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
        //
        public function index(){ 
            $periode = Periode::orderBy('tahun',"desc")->get();

            return view('contents.periode.index',compact('periode'));
        }
    
        public function create(){    
            return view('contents.periode.create');
        }
    
        public function edit($id){
            $periode = Periode::find($id);
    
            return view('contents.periode.edit',compact('periode'));
        }
    
        public function store(Request $request){
            $this->validate($request,[
                'tahun' => 'required|numeric|min:2000|max:3000',
            ],[
                'required'=>':attribute tidak boleh kosong'
            ]);

            $first = Periode::count() == 0;
    
            $rk = new Periode();
            $rk->tahun = $request->tahun;
            $rk->is_active = $first ? true : false;
            $rk->save();
    
            return redirect()->route('periode.index')->with('success','Periode Kerja Berhasil di simpan');
        }
    
        public function update(Request $request, $id){
            $this->validate($request,[
                'tahun' => 'required|numeric',
            ],[
                'required'=>':attribute tidak boleh kosong'
            ]);
            $rk = Periode::find($id);        
            $rk->tahun = $request->tahun;
            $rk->save();
    
            return redirect()->route('periode.index')->with('success','Periode Kerja Berhasil di update');
        }
    
        public function delete(Request $request){
            $periode = Periode::find($request->id);
            // cek apakah id master unit kerja tersebut ada
            if ($periode) {
                // cek apakah master unit kerja mempunyai user
                // jika iya tidak dapat dihapus
                if ($periode->rencanaKerja->count() > 0) {
                    return response()->json([
                        "status" => 400,
                        "message" => "Tidak bisa di hapus karena sudah ada Rencana Kerja"
                    ]);    
                } else {
                    $periode->delete();
                    return response()->json([
                        "status" => 200,
                        "message" => "Periode kerja berhasil di hapus"
                    ]);    
                }
            } else {
                return response()->json([
                    "status" => 400,
                    "message" => "Periode kerja tidak ditemukan"
                ]);    
            }
            $periode->delete();
            return redirect()->route('periode.index')->with('success','Periode Kerja Berhasil di hapus');
        }

        public function change(Request $request){
            // $periode = Periode::find($request->id);
            // // cek apakah id master unit kerja tersebut ada
            // if ($periode) {
            //     // cek apakah master unit kerja mempunyai user
            //     // jika iya tidak dapat dihapus
            //     $periodes = Periode::where('is_active',true)->get();
            //     foreach ($periodes as $period) {
            //         $period->is_active = false;
            //         $period->save();
            //     }

            //     $periode->is_active = true;
            //     $periode->save();

            // }

            return redirect()->route('periode.index')->with('success','Periode Kerja Berhasil di ubah');
        }

        public function toggleActive(Request $request){
            $periode = Periode::find($request->id);
            // cek apakah id master unit kerja tersebut ada
            if ($periode) {
                // cek apakah master unit kerja mempunyai user
                // jika iya tidak dapat dihapus
                $periode->is_active = !$periode->is_active;
                $periode->save();

                return response()->json([
                    "status" => 200,
                    "data" => $periode
                ]);    
            }

            return redirect()->route('periode.index')->with('success','Periode Kerja Berhasil di ubah');
        }

        public function range(Request $request) {
            $periode = Periode::find($request->id);
            // cek apakah id master unit kerja tersebut ada
            if ($periode) {
                return response()->json([
                    "status" => 200,
                    "data" => [
                        'start' => Carbon::createFromFormat('Y', $periode->tahun)->startOfYear()->format('Y-m-d'),
                        'end' => Carbon::createFromFormat('Y', $periode->tahun)->endOfYear()->format('Y-m-d')
                    ]
                ]);
            }
            return redirect()->route('periode.index')->with('success','Periode Kerja Berhasil di ubah');
        }
}
