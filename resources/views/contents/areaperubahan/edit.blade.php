@extends('master')
@section('areaperubahanactive','active')
@section('title',"Tambah Area Perubahan")
@section('content')
<div class="container-fluid py-4">    
  <div class="card">
    <div class="card-body">
      <form action="{{route('areaperubahan.update',$area->id)}}" method="POST">        
        @csrf        
        @method("PUT")
        <label for="">Nama Area Perubahan</label><br>
        <input type="text" name="nama_area_perubahan" id="" class="form-control" placeholder="Nama Area Perubahan" value="{{$area->nama_area_perubahan}}" required><br>
        <label for="">Deskripsi</label><br>
        <textarea name="deskripsi" id="" cols="30" rows="10" class="form-control" required>{{$area->deskripsi}}</textarea>
        <hr>
        <button type="button" class="btn btn-primary btn-sm add-sub">Tambah Sub area perubahan</button>
        <div class="new_area">
          @foreach ($area->subarea as $item)              
            <div class="sub_area_input">
              <input type="text" name="sub_data[sub_name][]" id="" class="form-control" value="{{$item->name_sub_area_perubahan}}" placeholder="Sub Nama Area Perubahan"><br>
              <label for="">Sub Deskripsi</label><br>
              <textarea name="sub_data[sub_deskripsi][]" id="" cols="30" rows="10" class="form-control">{{$item->deskripsi_sub_area_perubahan}}</textarea><br/>
              <button type="button" class="btn btn-primary btn-sm add-sub">Tambah Sub area perubahan</button>
              <button type="button" class="btn btn-sm btn-secondary remove-sub">Hapus Sub Area Perubahan</button>
            </div>
          @endforeach
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
      </form>
    </div>
  </div>
</div>
@push('scriptjs')
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
  $(document).on('click', '.add-sub', function () {
    var html = `
      <div class="sub_area_input">
        <input type="text" name="sub_data[sub_name][]" id="" class="form-control" placeholder="Sub Nama Area Perubahan"><br>
        <label for="">Sub Deskripsi</label><br>
        <textarea name="sub_data[sub_deskripsi][]" id="" cols="30" rows="10" class="form-control"></textarea><br/>
        <button type="button" class="btn btn-primary btn-sm add-sub">Tambah Sub area perubahan</button>
        <button type="button" class="btn btn-sm btn-secondary remove-sub">Hapus Sub Area Perubahan</button>
      </div>
    `
    $('.new_area').append(html)
  })
  $(document).on('click', '.remove-sub', function () {
    $(this).closest('.sub_area_input').remove();
  });
</script>
@endpush
@endsection