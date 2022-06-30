<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use App\Models\ScoringPengungkit;
use App\Models\UnitKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        if(auth()->guard('unitkerja')->user()){
            return view('contents.dashboard');
        }
        else if (auth()->guard('web')->user()->role == "admin" || auth()->guard('web')->user()->role == "eksekutif") {
            $unitKerja = UnitKerja::count();
            $fileLaporan = FileUpload::whereMonth('created_at',Carbon::now('Asia/Jakarta')->format('m'))->count();
            $fileCheck = FileUpload::all();           
            $countingNotEvaluasi = 0;
            foreach ($fileCheck as $key => $value) {
                $cek = ScoringPengungkit::where('unit_kerja_id',$value->user_id)->where('file_id',$value->id);
                if ($cek->count() != 0) {                    
                    if (!$cek) {
                        $countingNotEvaluasi += 1;
                    }
                }
            } 
            $doneEvaluasi = ScoringPengungkit::count();
            
            return view('contents.dashboardadmin',compact('doneEvaluasi','countingNotEvaluasi','fileLaporan','unitKerja'));
        }
    }
}
