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
            <div class="d-flex justify-content-end align-items-center">
                <a class="btn btn-primary btn-sm" href="{{route('unitkerja.create')}}">Tambah Unit Kerja</a>
            </div>
        </div>
        <div class="card-body">
            <table id="unitkerjatable" class="display nowrap table table-bordered table-stripped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $key=>$item)
                        
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$item->name}}</td>
                      <td>{{$item->email}}</td>
                      <td>{{$item->masterunitkerja->name}}</td>
                      <td>
                        <a href="{{route('unitkerja.edit',$item->id)}}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="#hapus"  data-toggle="modal" data-target="#hapus" onclick="hapus({{$item->id}})" class="btn-submit btn btn-danger btn-sm">Delete</a>
                      </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
    $('#unitkerjatable').DataTable( {
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
          axios.post("{{route('unitkerja.delete')}}", {          
            "_token":"{{csrf_token()}}",
            "id" : id
          })
          .then(function (response) {            
            Swal.fire('Terhapus!', '', 'success').then(()=>{
              window.location = "{{route('unitkerja.index')}}"
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