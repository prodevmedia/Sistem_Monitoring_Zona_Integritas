<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use App\Models\UserUnitKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        if(auth()->guard('unitkerja')->user()){
            $fileLaporan = FileUpload::whereMonth('created_at',Carbon::now('Asia/Jakarta')->format('m'))->count();
            $fileCheck = FileUpload::all();           
            $countingNotEvaluasi = 0;
            $countingNotEvaluasi = 0;
            $doneEvaluasi = 0;

            return view('contents.dashboard',compact('doneEvaluasi','countingNotEvaluasi','fileLaporan'));
        }
        else if (auth()->guard('web')->user()->role == "admin" || auth()->guard('web')->user()->role == "eksekutif") {
            $unitKerja = UserUnitKerja::count();
            $fileLaporan = FileUpload::whereMonth('created_at',Carbon::now('Asia/Jakarta')->format('m'))->count();
            $fileCheck = FileUpload::all();           
            $countingNotEvaluasi = 0;
            $doneEvaluasi = 0;
            
            return view('contents.dashboardadmin',compact('doneEvaluasi','countingNotEvaluasi','fileLaporan','unitKerja'));
        }
    }
}
