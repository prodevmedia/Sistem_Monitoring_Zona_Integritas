@extends('master')
@section('title',"Dashboard")
@section('dashboardactive','active')
@section('content')
<div class="container-fluid py-4">
    {{-- {{dd(auth()->user())}} --}}
    <h1>WELCOME {{auth()->user() ? auth()->user()->name : auth()->guard('unitkerja')->user()->name}}</h1>    <br>
    <div class="row">
      <div class="col-md-3">
        <div class="card">                    
          <p class="p-3" style="font-size: 14px;">          
            Laporan Yang Belum di Evaluasi
          </p>
          <h1 class="d-flex justify-content-center align-items-center" style="font-size: 100px">
            {{$countingNotEvaluasi}}
          </h1>          
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">                    
          <p class="p-3" style="font-size: 14px;">          
            Laporan Yang Sudah di Evaluasi
          </p>
          <h1 class="d-flex justify-content-center align-items-center" style="font-size: 100px">
            {{$doneEvaluasi}}
          </h1>          
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">                    
          <p class="p-3" style="font-size: 14px;">          
            Laporan Bulan Ini
          </p>
          <h1 class="d-flex justify-content-center align-items-center" style="font-size: 100px">
            {{$fileLaporan}}
          </h1>          
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">                    
          <p class="p-3" style="font-size: 14px;">          
            Banyak User
          </p>
          <h1 class="d-flex justify-content-center align-items-center" style="font-size: 100px">
            {{$unitKerja}}
          </h1>          
        </div>
      </div>
    </div>
</div>
@push('scriptjs')
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
@endpush
@endsection