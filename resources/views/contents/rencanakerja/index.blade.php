@extends('master')
@section('rencanakerjaactive','active')
@section('title',"Rencana Kerja")
@section('content')
<div class="container-fluid py-4">
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
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-end align-items-center">
                @if (auth()->user()->role=="admin")  
                  <a class="btn btn-primary" href="{{route('rencanakerja.create')}}">Tambah Rencana Kerja</a>
                @endif
            </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="unitkerjatable" class="table table-striped table-hover dt-responsive display nowrap" cellspacing="0">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Rencana Aksi</th>
                    <th>Unit Kerja</th>
                    <th>User</th>
                    <th>Target Waktu</th>
                    <th>Realisasi</th>
                    @if (auth()->user()->role=="admin")  
                      <th>Action</th>
                    @endif
                  </tr>
                    </thead>
                    <tbody>                    
                      @foreach ($rencana as $key => $item)
                          <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$item->rencana_aksi}}</td>
                            <td>{{$item->masterunitkerja->name}}</td>
                            <td>{{$item->userunitkerja->name}}</td>
                            <td>{{\Carbon\Carbon::parse($item->tanggal_waktu)->isoFormat('dddd, D MMMM Y H:mm')}}</td>
                            <td>{{$item->realisasi}}</td>
                            <td>
                              <a href="{{route('rencanakerja.edit',$item->id)}}" class="btn btn-sm btn-warning">Edit</a>
                              <a href="#" data-toggle="modal" onclick="deleteRencana({{$item->id}})" data-target="#hapus" rel="noopener noreferrer" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                          </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{route('rencanakerja.delete')}}" method="post">
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
            <input type="hidden" name="id" id="idrencana">
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
    function deleteRencana(id){
      $("#idrencana").val(id);
    }
</script>
@endpush
@endsection