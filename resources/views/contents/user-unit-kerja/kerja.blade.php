@extends('master')
@section('unitkerjaactive','active')
@section('title',"Unit Kerja")
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
           
        </div>
        <div class="card-body">
            <table id="kerjaUnitTabel" class="display nowrap table table-bordered table-stripped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Rencana Kerja</th>
                        <th>Area</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($unit as $key=>$item)
                        
                    <tr>
                      <td>{{$item->id}}</td>
                      <td>{{$item->tanggal_waktu}}</td>
                      <td>{{$item->rencana_aksi}}</td>
                      <td>{{$item->area_perubahan_id}}</td>
                      <td>
                        {{-- tombol upload file --}}
                        <a class="btn btn-primary" data-toggle="modal" data-target="#add">Upload File</a>
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

@push('scriptjs')
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('#kerjaUnitTabel').DataTable( {
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
    });
    function hapus(id){
      Swal.fire({
        icon:"info",
        title: 'Apa anda yakin ingin menghapusnya ?',
        showCancelButton: true,
        confirmButtonText: 'Ya',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          console.log(id)
          axios.post("{{route('userUnitKerja.delete')}}", {          
            "_token":"{{csrf_token()}}",
            "id" : id
          })
          .then(function (response) {            
            Swal.fire('Terhapus!', '', 'success').then(()=>{
              window.location = "{{route('userUnitKerja.index')}}"
            })
          })
        } else if (result.isDenied) {
          Swal.fire('Changes are not saved', '', 'info')
        }
      })
    }
</script>
@endpush
@endsection