<?php

namespace App\Http\Controllers;

use App\Models\MasterUnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterUnitKerjaController extends Controller
{
    //
    public function index(){
        $masterunitkerja = MasterUnitKerja::orderBy('id','desc')->get();
        return view('contents.masterunitkerja.index',compact('masterunitkerja'));
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                "message" => "Nama unit kerja tidak boleh kosong"
            ]);
        } 

        MasterUnitKerja::create([
            'name' => $request->name
        ]);

        return response()->json([
            "status" => 200,
            "message" => "Data unit kerja berhasil di buat"
        ]);
    }

    public function data(){
        $masterunitkerja = MasterUnitKerja::all();
        $arr = [];
        foreach ($masterunitkerja as $key => $value) {
            $obj = new \stdClass;
            $obj->no = $key+1;
            $obj->name = $value->name;
            $obj->action = "";
            array_push($arr,$obj);
        }
        dd($arr);
        return response()->json(["data"=>$arr]);   
    }

    public function create(){

    }

    public function edit($id){
        
    }

    public function update(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                "message" => "Nama unit kerja tidak boleh kosong"
            ]);
        } 

        MasterUnitKerja::where('id',$id)->update([
            'name' => $request->name
        ]);

        return response()->json([
            "status" => 200,
            "message" => "Data unit kerja berhasil di buat"
        ]);
    }

    public function delete(Request $request){
        $id = $request->id;

        // cek apakah id master unit kerja tersebut ada
        $masterunitkerja = MasterUnitKerja::find($id);
        if ($masterunitkerja) {
            // cek apakah master unit kerja mempunyai user
            // jika iya tidak dapat dihapus
            if ($masterunitkerja->userunitkerja->count() > 0) {
                return response()->json([
                    "status" => 400,
                    "message" => "Tidak bisa di hapus karena sudah di miliki user"
                ]);    
            } else {
                MasterUnitKerja::where('id',$id)->delete();
                return response()->json([
                    "status" => 200,
                    "message" => "Data unit kerja berhasil di hapus"
                ]);    
            }
        } else {
            return response()->json([
                "status" => 400,
                "message" => "Data unit kerja tidak ditemukan"
            ]);    
        }
    }

    // not crud
    public function getUserUnitKerja(Request $request, $id){
        $userUnitKerja = MasterUnitKerja::where('unit_kerja_id', $id)->get();

        return response()->json($userUnitKerja);
    }
}
