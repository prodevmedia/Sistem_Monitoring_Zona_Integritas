@extends('master')
@section('masterunitkerjaactive','active')
@section('title',"Master Unit Kerja")
@section('content')
{{-- <div class="alert alert-success alert-dismissible fade show" role="alert">
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
</div> --}}
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-end align-items-center">
                <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createModal">Tambah Unit Kerja</a>
            </div>
        </div>
        <div class="card-body">
            <table id="unitkerjatable" class="display nowrap table table-bordered table-stripped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($masterunitkerja as $key => $item)
                        <tr>
                          <td>{{$key+1}}</td>
                          <td>{{$item->name}}</td>
                          <td>
                            <a href="#edit" class="btn btn-warning btn-sm" data-id="{{$item->name}} " onclick="edit('{{$item->name}}',{{$item->id}})">Edit</a>
                            <a href="#hapus"  data-toggle="modal" data-target="#hapus" onclick="hapus({{$item->id}})" class="btn-submit btn btn-danger btn-sm">Delete</a>
                          </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Master Unit Kerja</h5>
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" name="name" class="form-control" placeholder="Tambah Master Unit Kerja" id="">
        <div style="color:red" class="error-add"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="simpan()">Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Master Unit Kerja</h5>
        <button type="button" class="btn btn-sm btn-danger closeModalEdit" id="" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" name="name_edit" class="form-control" placeholder="Edit Master Unit Kerja" id="editname">
        <div style="color:red" class="error-add"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary closeModalEdit" data-dismiss="modal" id="closeModalEdit">Close</button>
        <button type="button" class="btn btn-primary" onclick="update()">Update</button>
      </div>
    </div>
  </div>
</div>
@push('scriptjs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap4.min.js"></script>
<script>
    function datatable() { 
      $('#unitkerjatable').DataTable();
    }
    datatable()
    var ids;
    function edit(name,id) {
      ids = id
      $("#editModal").modal('show');
      $('#editname').val(name)
    }

    $('.closeModalEdit').click(()=>{
      $("#editModal").modal('hide');
    })

    function update(){
      var name = $('[name="name_edit"]').val()
      axios.put(`${window.location.origin}/master-unit-kerja/${ids}`, {          
          "_token":"{{csrf_token()}}",
          "name" : name
        }).then((res)=>{
          if (res.data.status == 400) {            
            $('.error-add').html(res.data.message);
          }else{
            Swal.fire({
              icon:"success",
              title: 'Berhasil diubah'
            }).then(()=>{
              window.location.reload()
            })
          }
      })
    }

    function simpan() {
      var name = $('[name="name"]').val()
      axios.post("{{route('masterunitkerja.store')}}", {          
          "_token":"{{csrf_token()}}",
          "name" : name
        }).then((res)=>{
          if (res.data.status == 400) {            
            $('.error-add').html(res.data.message);
          }else{
            Swal.fire({
              icon:"success",
              title: 'Berhasil di tambahkan'
            }).then(()=>{
              window.location.reload()
            })
          }
        })
    }

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
          axios.post("{{route('masterunitkerja.delete')}}", {          
            "_token":"{{csrf_token()}}",
            "id" : id
          })
          .then(function (response) {  
            console.log(response)
            if (response.data.status == 400) {
              Swal.fire(`${response.data.message}`, '', 'error').then(()=>{
                window.location = "{{route('masterunitkerja.index')}}"
              })
            }else{

              Swal.fire('Terhapus!', '', 'success').then(()=>{
                window.location = "{{route('masterunitkerja.index')}}"
              })
            }
          })
        } else if (result.isDenied) {
          Swal.fire('Hapus Di batalkan', '', 'info')
        }
      })
    }
</script>
@endpush
@endsection