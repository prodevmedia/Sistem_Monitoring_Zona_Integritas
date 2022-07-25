<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\FileUpload;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    //
    public function index(){
        $area = Auth::guard('unitkerja')->user()->unit_kerja_id;
        $file = FileUpload::with('point')->get();
        // dd($file);
        return view('contents.uploads.index',compact('file'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'upload' => "required|file|mimes:pdf",
        ],[
            'required' => ":attribute tidak Boleh kosong",
            'mimes' => ":attribute Harus Berformat PDF"
        ]);

        $file = $request->file('upload');

        $folderUpload = "upload";

        $path = url("/")."/upload"."/".auth()->guard('unitkerja')->user()->name."_".auth()->guard('unitkerja')->user()->id."_".$file->getClientOriginalName();

        $name = auth()->guard('unitkerja')->user()->name."_".auth()->guard('unitkerja')->user()->id."_".Carbon::now('Asia/Jakarta')->format('Ymdhis').$file->getClientOriginalName();
        
        $file->move($folderUpload,$name);

        FileUpload::create([
            'user_id' => auth()->guard('unitkerja')->user()->id,
            "name_file" => $name,
            "path_file" => $path
        ]);

        return redirect()->back()->with('success','Upload File Berhasil mohon tunggu untuk di evaluasi admin');

    }

    public function delete(Request $request){
        $cek = FileUpload::find($request->id);
        $cek->deleted_at = Carbon::now('Asia/Jakarta');
        $cek->save();

        return redirect()->back()->with('success','Upload File Berhasil di hapus');
    }
}
