@extends('master')
@section('subareaperubahanactive','active')
@section('title',"Sub Area Perubahan")
@section('content')
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <div class="d-flex justify-content-between">
    <div class="d-flex justify-content-start">
      <strong>Success!</strong>&nbsp;{{Session::get('success')}}
    </div>
    <div class="d-flex justify-content-end">
      <button type="button" class="close btn btn-sm btn-danger" style="color: white" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  </div>
</div>
@endif
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-end align-items-center">
                @if (auth()->user()->role=="admin")                    
                  <a class="btn btn-primary" href="{{route('subareaperubahan.create')}}">Tambah Area Perubahan</a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <table id="unitkerjatable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Sub Area Perubahan</th>
                        <th>Penjelasan</th>
                        <th>Pilihan Jawaban</th>
                        <th>Area Perubahan</th>
                        @if (auth()->user()->role=="admin")
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody> 
                  @foreach ($sub as $key=>$item)
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->name_sub_area_perubahan}}</td>
                        <td>{{substr($item->penjelasan,0,50)}}</td>
                        <td>{{$item->pilihan_jawaban}}</td>
                        <td>{{$item->areaperubahan->nama_area_perubahan}}</td>
                        <td>
                          <a href="{{route('subareaperubahan.edit',$item->id)}}" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                      </tr>
                  @endforeach                   
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hapus Area Perubahan</h5>
          <a class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
        <div class="modal-body">  
            <h4>Apa kamu yakin untuk menghapusnya ?</h4>        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tidak</button>
          <button type="submit" class="btn btn-success btn-sm">Ya</button>
        </div>
      </div>
    </div>
</div>
@push('scriptjs')
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap4.min.js"></script>
<script>
    $('#unitkerjatable').DataTable( {
        responsive: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
    });
    function edit(id,name){
      $('#id_area_perubahan').val(id)
      $('#edit_nama_area_perubahan').val(name)
      $('#formedit').attr('action',`${window.location.origin}/area-perubahan/update/${id}`)
    }
</script>
@endpush
@endsection