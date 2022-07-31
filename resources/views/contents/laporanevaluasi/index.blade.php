@extends('master')
@section('lembarkerjaevaluasiactive','active')
@section('title',"Lembar Kerja Evaluasi")
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
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="unitkerjatable" class="table table-striped table-hover dt-responsive display nowrap" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Unit</th>
                  <th>Email Pengirim</th>
                  <th>File Upload</th>
                  <th>Tahun</th>
                  <th>Waktu Upload</th>
                  <th>Action</th>
                </tr>
              </thead>
                    <tbody>
                      @foreach ($file as $key => $item)                        
                        <tr>
                          <td>{{$key+1}}</td>
                          <td>{{$item->user->name}}</td>
                          <td>{{$item->user->email}}</td>
                          <td>
                            {!!wordwrap($item->name_file,30,"<br>\n", false)!!}                             
                          </td>
                          <td>{{$item->points ? $item->points->tahun : null}}</td>
                          <td>{{\Carbon\Carbon::parse($item->created_at)->format("D, d M")}}</td>
                          <td>
                            <a href="{{route('laporanevaluasi.show',[$item->user_id,$item->id])}}" class="btn btn-sm btn-success">Detail</a>
                            @php
                               $cek = DB::table('scoring_master_unit_kerjas')->where("file_id",$item->id)->where('unit_kerja_id',$item->user_id)->count();
                            @endphp
                            @if (auth()->guard('web')->user()->role == 'admin')                                
                              @if ($cek > 0)
                              <a href="{{route('laporanevaluasi.edit',[$item->user_id,$item->id])}}" class="btn btn-sm btn-warning">Edit</a>
                              @else
                              <a href="{{route('laporanevaluasi.berinilai',[$item->user_id,$item->id])}}" class="btn btn-sm btn-warning">Beri Nilai</a>
                              @endif                            
                              <a data-toggle="modal" onclick="deleteLaporan({{$item->user_id}},{{$item->id}})" data-target="#hapus" rel="noopener noreferrer" class="btn btn-sm btn-danger">Hapus</a>
                            @endif
                          </td>
                        </tr>  
                      @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Laporan Evaluasi</h5>
          <a class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
        <div class="modal-body">
          <label for="">Rencana Aksi</label><br>
          <textarea name="rencana_aksi" id="" cols="30" rows="10" class="form-control"></textarea><br>
          <label for="">Area Perubahan</label><br>
          <select name="area_perubahan" id="" class="form-control">
            <option value="1">Manajemen Perlatan</option>
            <option value="1">Manajemen Perubahan</option>
          </select><br>
          <label for="">Target Waktu</label><br>
          <input type="date" name="tanggal_waktu" id="" class="form-control">
          <label for="">Rencana Realisasi</label><br>
          <input type="text" name="realisasi" id="" class="form-control">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success btn-sm">Submit</button>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Laporan Evaluasi</h5>
          <a class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
        <div class="modal-body">
          <label for="">Rencana Aksi</label><br>
          <textarea name="rencana_aksi" id="" cols="30" rows="10" class="form-control"></textarea><br>
          <label for="">Area Perubahan</label><br>
          <select name="area_perubahan" id="" class="form-control">
            <option value="1">Manajemen Perlatan</option>
            <option value="1">Manajemen Perubahan</option>
          </select><br>
          <label for="">Target Waktu</label><br>
          <input type="date" name="tanggal_waktu" id="" class="form-control">
          <label for="">Rencana Realisasi</label><br>
          <input type="text" name="realisasi" id="" class="form-control">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success btn-sm">Submit</button>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{route('laporanevaluasi.delete')}}" method="post">
      @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Penilaian akan di hapus</h5>
        <a class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
          <span aria-hidden="true">&times;</span>
        </a>
      </div>
      <div class="modal-body">  
          <input type="hidden" name="user_id" id="userid">
          <input type="hidden" name="file_id" id="fileid">
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
    function deleteLaporan(userid,fileid){
      $("#userid").val(userid);
      $("#fileid").val(fileid);
    }
</script>
@endpush
@endsection