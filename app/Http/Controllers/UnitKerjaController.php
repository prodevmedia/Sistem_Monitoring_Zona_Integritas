<?php

namespace App\Http\Controllers;

use App\Mail\SendAccountEmail;
use App\Models\MasterUnitKerja;
use App\Models\UnitKerja;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UnitKerjaController extends Controller
{
    //
    public function index(){     
        $user = UnitKerja::with('masterunitkerja')->get();        
        $masterunitkerja = MasterUnitKerja::all();
        return view('contents.unitkerja.index',compact('user','masterunitkerja'));
    }

    public function create(){
        $masterunitkerja = MasterUnitKerja::all();
        return view('contents.unitkerja.create',compact('masterunitkerja'));
    }

    public function store(Request $request){
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:unit_kerjas,email',
            'password' => 'required|min:6',    
            'unit_kerja' => 'required'
        ],[
            'required' => ":attribute tidak boleh kosong",
            'unique' => ':attribute sudah ada',
            'email' => ':attribute harus berbentuk email',
            'min' => ':attribute minimal :min',            
        ]);


        $data = (object) [
            "name" => $request->email,
            "message" => "Halo ".$request->name." selamat datang di Aplikasi kami, agar kamu dapat memakai aplikasi kami silahkan untuk login menggunakan akun ini <br> Email : ".$request->email."<br> Password: ".$request->password,
        ];
        

        Mail::to($request->email)->send(new SendAccountEmail($data));
        
        UnitKerja::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password')),
            'unit_kerja_id'=>$request->input('unit_kerja'),
        ]);

        return redirect(route('unitkerja.index'))->with('success','User Unit Kerja berhasil di buat, silahkan untuk konfirmasi untuk mengecek email agar bisa login');
    }

    public function edit($id){
        
        $unitkerja = UnitKerja::whereId($id)->with('masterunitkerja')->first();
        $masterunitkerja = MasterUnitKerja::all();
        return view('contents.unitkerja.edit',compact('unitkerja','masterunitkerja'));
    }

    public function update(Request $request,$id){
        $user = UnitKerja::find($id);        
        if ($request->input('password')) {
            $user->password = $request->input('password');
        }
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->unit_kerja_id = $request->input('unit_kerja');
        $user->save();
        return redirect()->route('unitkerja.index')->with('success','Data Berhasil di update');
    }

    public function delete(Request $request){
        UnitKerja::where('id',$request->id)->update([
            'deleted_at' => Carbon::now('Asia/Jakarta')
        ]);
        
        return redirect()->route('unitkerja.index');
    }

    public function getAllUnitKerja(){
        $unitKerja = UnitKerja::all();
        return response()->json($unitKerja);
    }
}
