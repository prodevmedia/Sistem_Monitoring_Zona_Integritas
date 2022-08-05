<?php

namespace App\Http\Controllers;

use App\Mail\SendAccountEmail;
use App\Models\MasterUnitKerja;
use App\Models\UnitKerja;
use App\Models\UserUnitKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserUnitKerjaController extends Controller
{
    public function index()
    {
        $users = UserUnitKerja::get();

        return view('contents.user-unit-kerja.index', compact('users'));
    }

    public function create()
    {
        $masterunitkerja = MasterUnitKerja::all();
        return view('contents.user-unit-kerja.create', compact('masterunitkerja'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:unit_kerjas,email',
            'password' => 'required|min:6',
            'master_unit_kerja_id' => 'required'
        ], [
            'required' => ":attribute tidak boleh kosong",
            'unique' => ':attribute sudah ada',
            'email' => ':attribute harus berbentuk email',
            'min' => ':attribute minimal :min',
        ]);


        $data = (object) [
            "name" => $request->email,
            "message" => "Halo " . $request->name . " selamat datang di Aplikasi kami, agar kamu dapat memakai aplikasi kami silahkan untuk login menggunakan akun ini <br> Email : " . $request->email . "<br> Password: " . $request->password,
        ];


        Mail::to($request->email)->send(new SendAccountEmail($data));

        UserUnitKerja::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'master_unit_kerja_id' => $request->input('master_unit_kerja_id'),
        ]);

        return redirect(route('userUnitKerja.index'))->with('success', 'User Unit Kerja berhasil di buat, silahkan untuk konfirmasi untuk mengecek email agar bisa login');
    }

    public function edit($id)
    {

        $unitkerja = UserUnitKerja::whereId($id)->with('masterunitkerja')->first();
        $masterunitkerja = MasterUnitKerja::all();
        return view('contents.user-unit-kerja.edit', compact('unitkerja', 'masterunitkerja'));
    }

    public function update(Request $request, $id)
    {
        $user = UserUnitKerja::find($id);
        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->master_unit_kerja_id = $request->input('master_unit_kerja_id');
        $user->save();
        return redirect()->route('userUnitKerja.index')->with('success', 'Data Berhasil di update');
    }

    public function delete(Request $request)
    {
        UserUnitKerja::where('id', $request->id)->update([
            'deleted_at' => Carbon::now('Asia/Jakarta')
        ]);

        return redirect()->route('userUnitKerja.index');
    }

    public function getAllUnitKerja()
    {
        $unitKerja = UserUnitKerja::all();
        return response()->json($unitKerja);
    }
}
