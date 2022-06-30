@extends('master')
@section('uploadfileactive','active')
@section('title',"Upload File")
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
@if (count($errors) > 0)
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <div class="d-flex justify-content-between">
    <div class="d-flex justify-content-start" style="color:white">
      <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
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
              <a class="btn btn-primary" data-toggle="modal" data-target="#add">Upload File</a>                
            </div>
        </div>
        <div class="card-body">
            <table id="unitkerjatable" class="display nowrap table table-bordered table-stripped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama File</th>                        
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($file as $key=>$item)
                        <tr>
                          <td>{{$key+1}}</td>
                          <td>{!!wordwrap($item->name_file,30,"<br>\n", false)!!} <br>
                            @if ($item->point)
                              <span style="background-color: green; color:white;">Sudah di evaluasi</span>
                            @else
                              <span style="background-color: red; color:white;">Belum di Evaluasi</span>
                            @endif
                          </td>
                          <td>
                            <a href="#" data-toggle="modal" onclick="deleteFile({{$item->id}})" data-target="#hapus" rel="noopener noreferrer" class="btn btn-sm btn-danger">Hapus</a>
                            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#view" onclick="lihatFile('{{$item->path_file}}')">Lihat</a>
                          </td>
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
      <form method="post" action="{{route('uploads.store')}}"  enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
            <a class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
              <span aria-hidden="true">&times;</span>
            </a>
          </div>
          <div class="modal-body">            
            <div class="row">
              <div class="col-3">
                <input type="file" accept=".pdf" name="upload" class="btn btn-sm btn-success" id=""> 
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success btn-sm">Submit</button>
          </div>
        </div>
      </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="height: 100% !important;">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <a class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
        <div class="modal-body" style="height: 100vh;">
          <iframe id="showfile" width="100%" height="100%" name="show_file" frameborder="0"></iframe>
        </div>
      </div>
  </div>
</div>

<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{route('uploads.delete')}}" method="post">
        @csrf
        @method("DELETE")
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

    function edit(id,name){
      $('#id_area_perubahan').val(id)
      $('#edit_nama_area_perubahan').val(name)
      $('#formedit').attr('action',`${window.location.origin}/area-perubahan/update/${id}`)
    }
    
    function lihatFile(path){
      $("#showfile").attr('src',path);
    }
    function deleteFile(id){
      $("#idarea").val(id);
    }
</script>
@endpush
@endsection