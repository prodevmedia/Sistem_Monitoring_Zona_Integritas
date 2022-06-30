<?php

namespace App\Http\Controllers;

use App\Models\AreaPerubahan;
use App\Models\SubAreaPerubahan;
use Illuminate\Http\Request;

class SubAreaPerubahanController extends Controller
{
    //
    public function index(){
        $sub = SubAreaPerubahan::with('areaperubahan')->get();        
        return view('contents.subareaperubahan.index',compact('sub'));
    }

    public function create(){
        $area = AreaPerubahan::all();
        return view('contents.subareaperubahan.create',compact('area'));
    }

    public function store(Request $request){
        // dd($request->all());
        $sub = SubAreaPerubahan::create([
            'area_perubahan_id' => $request->area_perubahan,
            'name_sub_area_perubahan' => $request->name_sub_area_perubahan,
            'penjelasan' => $request->penjelasan,
            'pilihan_jawaban' => $request->pilihan_jawaban
        ]);
        return redirect()->route('subareaperubahan.index')->with('success','Sub Area Berhasil ditambahkan');
    }

    public function edit($id){
        $area = AreaPerubahan::all();
        $sub = SubAreaPerubahan::where('id',$id)->with('areaperubahan')->first();
        return view('contents.subareaperubahan.edit',compact('area','sub'));
    }

    public function update(Request $request, $id){
        $sub = SubAreaPerubahan::where('id',$id)->update([
            'area_perubahan_id' => $request->area_perubahan,
            'name_sub_area_perubahan' => $request->name_sub_area_perubahan,
            'penjelasan' => $request->penjelasan,
            'pilihan_jawaban' => $request->pilihan_jawaban
        ]);
        return redirect()->route('subareaperubahan.index')->with('success','Sub Area Berhasil diperbaharui');
    }
}
