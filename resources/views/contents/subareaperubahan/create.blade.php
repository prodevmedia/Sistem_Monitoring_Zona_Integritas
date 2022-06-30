@extends('master')
@section('subareaperubahanactive','active')
@section('title',"Create Sub Area Perubahan")
@section('content')
<div class="container">
  <div class="card">
    <div class="card-header">

    </div>
    <div class="card-body">
      <form action="{{route('subareaperubahan.store')}}" method="post">
        @csrf      
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            Pilih Area Perubahan <br><br>
            <select name="area_perubahan" id="" class="form-control">
              <option disabled selected>Pilih</option>
              @foreach ($area as $item)
                <option value="{{$item->id}}">{{$item->nama_area_perubahan}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              Nama Sub Area Perubahan<br><br>
              <input type="text" name="name_sub_area_perubahan" id="" class="form-control">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              Penjelasan <br><br>
              <textarea name="penjelasan" id="" cols="30" rows="10" class="form-control"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              Pilihan Jawaban <br><br>
              <input type="text" name="pilihan_jawaban" id="" class="form-control" placeholder="Contoh : A/B/C atau Yes/No">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <button class="btn btn-success btn-sm">Submit</button>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection