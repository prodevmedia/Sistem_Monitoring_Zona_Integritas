@extends('master')
@section('areaperubahanactive','active')
@section('title',"Area Perubahan")
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
@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <div class="d-flex justify-content-between">
    <div class="d-flex justify-content-start">
      <strong>Error!</strong>&nbsp;{{Session::get('error')}}
    </div>
    <div class="d-flex justify-content-end">
      <button type="button" class="close btn btn-sm btn-warning" style="color: white" data-dismiss="alert" aria-label="Close">
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
                  <a class="btn btn-primary" data-toggle="modal" data-target="#add">Tambah Area Perubahan</a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <table id="unitkerjatable" class="display nowrap table table-bordered table-stripped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Unit Kerja</th>
                        @if (auth()->user()->role=="admin")
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($area as $key=>$item)
                        <tr>
                          <td>{{$key+1}}</td>
                          <td>{{$item->nama_area_perubahan}}</td> 
                          @if (auth()->user()->role=="admin")                         
                          <td>
                              <a href="#" data-toggle="modal" onclick="deleteArea({{$item->id}})" data-target="#hapus" rel="noopener noreferrer" class="btn btn-sm btn-danger">Hapus</a>
                              <a href="#" data-toggle="modal" onclick="edit({{$item->id}},'{{$item->nama_area_perubahan}}', {{$item->master_unit_kerja_id}})" data-target="#edit" class="btn btn-sm btn-warning">
                                Edit
                              </a>
                          </td>
                          @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form method="post" action="{{route('areaperubahan.store')}}">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Area Perubahan</h5>
            <a class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
              <span aria-hidden="true">&times;</span>
            </a>
          </div>
          <div class="modal-body">
            <label for="">Pilih Unit Kerja</label><br>
            <select name="unit_kerja" class="form-control">
              <option disabled selected>Pilih Unit Kerja</option>
              @foreach ($unit as $item)
                  <option value="{{$item->id}}">{{$item->name_unit_kerja}}</option>
              @endforeach
            </select>
            <label for="">Nama Area Perubahan</label><br>
            <input type="text" name="nama_area_perubahan" id="" class="form-control" placeholder="Nama"><br>            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success btn-sm">Submit</button>
          </div>
        </div>
      </form>
    </div>
</div>
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form method="post" id="formedit">
        @csrf
        @method("PUT")
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Area Perubahan</h5>
          <a class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
        <div class="modal-body">
          <label for="">Pilih Unit Kerja</label><br>
            <select name="unit_kerja"  id="editunitkerja"  class="form-control">
              <option disabled selected>Pilih Unit Kerja</option>
              @foreach ($unit as $item)
                  <option value="{{$item->id}}">{{$item->name_unit_kerja}}</option>
              @endforeach
            </select>
          <label for="">Nama Area Perubahan</label><br>
          <input type="hidden" name="id_area_perubahan">
          <input type="text" name="nama_area_perubahan" id="edit_nama_area_perubahan" class="form-control" placeholder="Nama"><br>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success btn-sm">Submit</button>
        </div>
      </div>
      </form>
    </div>
</div>
<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{route('areaperubahan.delete')}}" method="post">
        @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hapus Area Perubahan</h5>
          <a class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
        <div class="modal-body">  
            <input type="hidden" name="id" id="idarea">
            <h4>Apa kamu yakin untuk menghapusnya ?</h4>        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tidak</button>
          <button type="submit" class="btn btn-success btn-sm">Ya</button>
        </div>
      </div>
      </form>
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
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
    });

    function deleteArea(id){
      $("#idarea").val(id);
    }

    function edit(id,name,idunitkerja){
      $('#id_area_perubahan').val(id)
      $('#editunitkerja').val(idunitkerja).change();
      $('#edit_nama_area_perubahan').val(name)
      $('#formedit').attr('action',`${window.location.origin}/area-perubahan/update/${id}`)
    }
</script>
@endpush
@endsection