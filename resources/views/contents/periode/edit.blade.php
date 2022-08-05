@extends('master')
@section('periodeactive','active')
@section('title',"Edit Periode")
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
  <div class="card col-6">
    <div class="card-body">
      <div class="row">
        <div class="col-12">
          <form action="{{route('periode.update',$periode->id)}}" method="post">
            @csrf
            @method("PUT")                  
            <label for="">Target Waktu</label><br>
            <div class="input-group">                    
              <input type="year" value="{{old('tahun') ?? $periode->tahun}}" name="tahun" id="" class="form-control">
            </div><br>
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="{{route('periode.index')}}" class="btn btn-secondary">Cancel</a>
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