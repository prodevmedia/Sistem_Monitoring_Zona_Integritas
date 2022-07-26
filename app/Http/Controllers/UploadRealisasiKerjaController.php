<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use App\Models\RencanaKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadRealisasiKerjaController extends Controller
{
        //
        public function index(){
            $master_unit_kerja_id = Auth::guard('unitkerja')->user()->master_unit_kerja_id;
            $rencana = RencanaKerja::where('master_unit_kerja_id', $master_unit_kerja_id)->orderBy('id',"desc")->get();

            return view('contents.uploadrealisasikerja.index',compact('rencana'));    
        }
    
        public function upload(Request $request){
            $validate = $this->validate($request,[
                'upload' => "required|file|mimes:pdf",
                'rencana_kerja_id' => "required"
            ],[
                'required' => ":attribute tidak Boleh kosong",
                'mimes' => ":attribute Harus Berformat PDF"
            ]);
    
            $file = $request->file('upload');
    
            $folderUpload = "upload";
    
            $path = url("/")."/upload"."/".auth()->guard('unitkerja')->user()->name."_".auth()->guard('unitkerja')->user()->id."_".$file->getClientOriginalName();
    
            $name = auth()->guard('unitkerja')->user()->name."_".auth()->guard('unitkerja')->user()->id."_".Carbon::now('Asia/Jakarta')->format('Ymdhis').$file->getClientOriginalName();
            
            $file->move($folderUpload,$name);
    
            $file = FileUpload::create([
                'user_id' => auth()->guard('unitkerja')->user()->id,
                "name_file" => $name,
                "path_file" => $path,
                "rencana_kerja_id" => $request->rencana_kerja_id
            ]);
    
            return redirect()->back()->with('success','Upload File Berhasil mohon tunggu untuk di evaluasi admin');
    
        }

        public function delete(Request $request){
            $file = FileUpload::find($request->id);
            $file->delete();
    
            return redirect()->back()->with('success','File Berhasil di hapus');
        }
}
