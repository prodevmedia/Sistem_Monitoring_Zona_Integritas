@extends('master')
@section('rencanakerjaactive','active')
@section('title',"Create Rencana Kerja")
@section('content')
<div class="container">
  <div class="card col-sm-6">
    <div class="card-body col-12">
      <div class="row">
        <div class="col-12">
          <form action="{{route('rencanakerja.store')}}" method="post">
            @csrf
            <label for="">Periode</label><br>
            <div class="input-group">
              <select name="periode_id" id="select-periode" class="form-control">
                <option disabled selected>Pilih</option>
                {{ $select = old('periode_id') }}
                @foreach ($periode as $item)
                <option value="{{$item->id}}" {{ $item->id == $select ? 'selected' : '' }}>{{$item->tahun}}</option>
                @endforeach
              </select>
            </div><br>

            <label for="">Master Unit Kerja</label><br>
            <div class="input-group">
              <select name="master_unit_kerja_id" id="select-master-unit-kerja" class="form-control">
                <option disabled selected>Pilih</option>
                {{ $select = old('master_unit_kerja_id') }}
                @foreach ($masterUnitKerja as $item)
                <option value="{{$item->id}}" {{ $item->id == $select ? 'selected' : '' }}>{{$item->name}}</option>
                @endforeach
              </select>
            </div><br>

            <label for="">Target Waktu</label><br>
            <div class="input-group">
              <input type="date" name="tanggal_waktu" id="target-waktu" class="form-control">
            </div><br>
            <label for="">Rencana Aksi</label><br>
            <div class="input-group">
              <textarea name="rencana_aksi" id="" cols="30" rows="10" class="form-control"></textarea>
            </div><br>
            <button class="btn btn-success">Submit</button>
            <a href="{{route('rencanakerja.index')}}" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@push('scriptjs')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/6-beta7/js/jQuery-provider.min.js"
  integrity="sha512-Do537NU11AoTRCD6WMWxbj9Yk7tynez4w6bNiZDvbAM1DopkCW5Isms86VXqHfjlwHoOKuGswSrsWxKrF7x4+A=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/6-beta7/js/tempus-dominus.min.js"
  integrity="sha512-1MtgrObV4IwMeselXJJXz4OkAd7107zzlykK2WRnWW75ItZvs5Wl1ESneWWCPB72Md5SAGjffvEtBcDkV5w8ZQ=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  $('#select-periode').change(function () {
      var periode_id = $(this).val();
      
      axios.post("{{route('periode.range')}}", {          
            "_token":"{{csrf_token()}}",
            "id" : periode_id
          })
          .then(function (response) {  
            
            if (response.data.status == 200) {
              var start = response.data.data.start;
              var end = response.data.data.end;

              $('#target-waktu').attr('min', start);
              $('#target-waktu').attr('max', end);
            }
          })
    });
</script>
@endpush
@endsection