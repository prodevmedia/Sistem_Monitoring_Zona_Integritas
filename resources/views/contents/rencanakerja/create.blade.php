@extends('master')
@section('rencanakerjaactive','active')
@section('title',"Create Rencana Kerja")
@section('content')
<div class="container">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-6">
          <form action="{{route('rencanakerja.store')}}" method="post">
            @csrf
            <label for="">Master Unit Kerja</label><br>
            <div class="input-group">
              <select name="master_unit_kerja_id" id="select-master-unit-kerja" class="form-control">
                <option disabled selected>Pilih</option>
                @foreach ($masterUnitKerja as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
              </select>
            </div><br>
                        
            <label for="">Target Waktu</label><br>
            <div class="input-group">      
              <input type="datetime-local" name="tanggal_waktu" id="" class="form-control">
            </div><br>
            <label for="">Rencana Realisasi</label><br>
            <input type="text" name="realisasi" id="" class="form-control"><br>
            <label for="">Rencana Aksi</label><br>
            <div class="input-group">
              <textarea name="rencana_aksi" id="" cols="30" rows="10" class="form-control"></textarea>
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