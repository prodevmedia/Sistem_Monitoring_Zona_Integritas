@extends('master')
@section('periodeactive','active')
@section('title',"Periode")
@section('content')
<div class="container-fluid py-4">
  @if (Session::has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <div class="d-flex justify-content-between">
      <div class="d-flex justify-content-start">
        <strong>Success!</strong>&nbsp;{{Session::get('success')}}
      </div>
      <div class="d-flex justify-content-end">
        <button type="button" class="close btn btn-sm btn-danger" style="color: white" data-dismiss="alert"
          aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
  </div>
  @endif

  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-end align-items-center">
        @if (auth()->user()->role=="admin")
        <a class="btn btn-primary" href="{{route('periode.create')}}">Tambah Periode</a>
        @endif
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="unitkerjatable" class="table table-striped table-hover dt-responsive display nowrap" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Tahun</th>
              <th>Aktif</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($periode as $key => $item)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$item->tahun}}</td>
              <td><button class="btn btn-sm btn-{{$item->is_active ? 'success' : 'danger'}}"
                  onclick="toggleActive({{$item->id}})">{{$item->is_active ? 'Aktif' : 'Tidak Aktif'}} </button> </td>
              <td>
                <a href="{{route('periode.edit',$item->id)}}" class="btn btn-sm btn-warning">Edit</a>
                <a href="#" onclick="hapus({{$item->id}})" rel="noopener noreferrer"
                  class="btn btn-sm btn-danger">Hapus</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@push('scriptjs')
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
  integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
  integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
  integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap4.min.js"></script>
<script>
  $('#unitkerjatable').DataTable( {
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: false,
    });
    function deleteRencana(id){
      $("#idrencana").val(id);
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
          axios.post("{{route('periode.delete')}}", {          
            "_token":"{{csrf_token()}}",
            "id" : id
          })
          .then(function (response) {  
            console.log(response)
            if (response.data.status == 400) {
              Swal.fire(`${response.data.message}`, '', 'error').then(()=>{
                window.location = "{{route('periode.index')}}"
              })
            }else{

              Swal.fire('Terhapus!', '', 'success').then(()=>{
                window.location = "{{route('periode.index')}}"
              })
            }
          })
        } else if (result.isDenied) {
          Swal.fire('Hapus Di batalkan', '', 'info')
        }
      })
    }

    function toggleActive(id){
        /* Read more about isConfirmed, isDenied below */
          axios.post("{{route('periode.toggleActive')}}", {          
            "_token":"{{csrf_token()}}",
            "id" : id
          })
          .then(function (response) {  
            console.log(response)
            if (response.data.status == 400) {
              Swal.fire(`${response.data.message}`, '', 'error').then(()=>{
                window.location = "{{route('periode.index')}}"
              })
            }else{

              Swal.fire('Berhasil!', '', 'success').then(()=>{
                window.location = "{{route('periode.index')}}"
              })
            }
          })
    }
</script>
@endpush
@endsection