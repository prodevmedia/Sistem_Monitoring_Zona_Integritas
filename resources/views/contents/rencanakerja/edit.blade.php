@extends('master')
@section('rencanakerjaactive','active')
@section('title',"Create Rencana Kerja")
@section('content')
<div class="container">
  @if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <div class="d-flex justify-content-between">
        <div class="d-flex justify-content-start">
        <ul style="color:white">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        </div>        
      </div>
    </div>
  @endif
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-6">
          <form action="{{route('rencanakerja.update',$rencana->id)}}" method="post">
            @csrf
            @method("PUT")
            <label for="">Unit Kerja</label><br>
            <div class="input-group">
              <select name="master_unit_kerja_id" id="select-master-unit-kerja" class="form-control">
                <option disabled selected>Pilih</option>
                @foreach ($masterUnitKerja as $item)
                    <option @if ($rencana->master_unit_kerja_id == $item->id)
                        selected
                    @endif value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
              </select>
            </div><br>                   
            <label for="">Target Waktu</label><br>
            <div class="input-group">                    
              <input type="datetime-local" value="{{\Carbon\Carbon::parse($rencana->tanggal_waktu)->format('Y-m-d')."T".\Carbon\Carbon::parse($rencana->tanggal_waktu)->format('h:m:s')}}" name="tanggal_waktu" id="" class="form-control">
            </div><br>
            <label for="">Rencana Realisasi</label><br>
            <input type="text" name="realisasi" id="" value="{{$rencana->realisasi}}" class="form-control"><br>
            <label for="">Rencana Aksi</label><br>
            <div class="input-group">
              <textarea name="rencana_aksi" id="" cols="30" rows="10" class="form-control">{{$rencana->rencana_aksi}}</textarea>
            </div><br>
            <button class="btn btn-success">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@push('scriptjs')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/6-beta7/js/jQuery-provider.min.js" integrity="sha512-Do537NU11AoTRCD6WMWxbj9Yk7tynez4w6bNiZDvbAM1DopkCW5Isms86VXqHfjlwHoOKuGswSrsWxKrF7x4+A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/6-beta7/js/tempus-dominus.min.js" integrity="sha512-1MtgrObV4IwMeselXJJXz4OkAd7107zzlykK2WRnWW75ItZvs5Wl1ESneWWCPB72Md5SAGjffvEtBcDkV5w8ZQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
@endsection