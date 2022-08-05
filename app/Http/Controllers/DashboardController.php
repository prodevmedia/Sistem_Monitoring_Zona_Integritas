<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use App\Models\RencanaKerja;
use App\Models\UserUnitKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        if(auth()->guard('unitkerja')->user()){
            $master_unit_kerja_id = auth()->guard('unitkerja')->user()->master_unit_kerja_id;

            $fileLaporan = RencanaKerja::where('master_unit_kerja_id', $master_unit_kerja_id)->count();
            $countingNotEvaluasi = RencanaKerja::where('master_unit_kerja_id', $master_unit_kerja_id)->where('status','!=','Sudah Evaluasi')->count();
            $doneEvaluasi = RencanaKerja::where('master_unit_kerja_id', $master_unit_kerja_id)->where('status','=','Sudah Evaluasi')->count();
            $revisi = RencanaKerja::where('status','Revisi')->count();;

            return view('contents.dashboard',compact('doneEvaluasi','countingNotEvaluasi','fileLaporan', 'revisi'));
        }
        else if (auth()->guard('web')->user()->role == "admin" || auth()->guard('web')->user()->role == "eksekutif") {
            $unitKerja = UserUnitKerja::count();
            $fileLaporan = RencanaKerja::count();
            $countingNotEvaluasi = RencanaKerja::where('status','!=','Sudah Evaluasi')->count();
            $doneEvaluasi = RencanaKerja::where('status','=','Sudah Evaluasi')->count();
            $revisi = RencanaKerja::where('status','Revisi')->count();
            
            return view('contents.dashboardadmin',compact('doneEvaluasi','countingNotEvaluasi','fileLaporan' , 'revisi','unitKerja'));
        }
    }
}
