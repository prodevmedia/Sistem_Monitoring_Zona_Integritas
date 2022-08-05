@extends('master')
@section('uploadRealisasiKerja','active')
@section('title',"Upload Realisasi Kerja")
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
      <div class="row">
        <div class="form-group row col-12 col-md-6">
          <label for="select-periode" class="col-4 col-md-2 col-form-label">Periode</label>
          <div class="col-6 col-md-3">
            <select onchange="changePeriode(event)" id="select-periode" class="form-select">
              <option value="" selected></option>
              @foreach ($periode as $item)
              <option value="{{$item->tahun}}">{{$item->tahun}}</option>
              @endforeach
            </select>
          </div>
        </div>
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
              <th>Target Waktu</th>
              <th>Status</th>
              <th>File</th>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </thead>
          <tbody>
            @foreach ($rencana as $key => $item)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$item->rencana_aksi}}</td>
              <td>{{$item->masterunitkerja->name}}</td>
              <td>{{\Carbon\Carbon::parse($item->tanggal_waktu)->isoFormat('dddd, D MMMM Y')}}</td>
              <td>{{$item->status}}</td>
              <td>
                @foreach ($item->fileuploads as $file)
                <a href="{{url('/upload/'.$file->name_file)}}" target="_blank">{{$file->name_file}}</a>
                @if ($item->status !='Sudah Evaluasi')
                <button onclick="deleteFile({{$file->id}})" class="btn btn-sm btn-danger">Hapus</button>
                @endif
                <br>
                @endforeach
                @if ($item->status !='Belum Upload')
                <button data-toggle="modal" data-target="#modal-detail-evaluasi"
                  onclick="detail('{{$item->status}}', '{{$item->nilai}}', '{{$item->keterangan}}')"
                  class="btn btn-sm btn-success">Detail</button>
                @endif
                @if ($item->status !='Sudah Evaluasi')
                <a href="#uploadRealisasi" data-toggle="modal" data-target="#modal-upload"
                  onclick="upload({{$item->id}})" class="btn btn-sm btn-primary">+ Upload</a>
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
{{-- modal detail evaluasi --}}
<div class="modal fade" id="modal-detail-evaluasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Evaluasi Rencana Kerja</h5>
        <a class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
          <span aria-hidden="true">&times;</span>
        </a>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group">
            <label for="status-rencana-kerja">Status Dokumen Realiasi Kerja</label>
            <select class="form-control">
              <option id="option-selected">Sudah Evaluasi</option>
            </select>
          </div>
          <div class="form-group">
            <label for="nilai-rencana-kerja">Nilai Realisasi Kerja (0-100)</label>
            <input disabled min="0" max="100" id="nilai-rencana-kerja" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="keterangan-evaluasi">Keterangan Revisi/Evaluasi Realiasi Kerja</label>
            <textarea disabled rows="5" id="keterangan" class="form-control"></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


{{-- Hapus File --}}
<div class="modal fade" id="modal-delete-file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{route('uploadRealiasiKerja.delete')}}" method="post">
      @csrf
      @method("DELETE")
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hapus File</h5>
          <a class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="file-id">
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

{{-- upload file --}}
<div class="modal fade" id="modal-upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="{{route('uploadRealiasiKerja.upload')}}" enctype="multipart/form-data">
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
            <input type="hidden" name="rencana_kerja_id" id="rencana-kerja-id">
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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
  integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
  integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
  integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap4.min.js"></script>
<script>
  table = $('#unitkerjatable').DataTable( {
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: false,
        orderCellsTop: true,
        initComplete: function() {
          var table = this.api();

          // Add filtering
          table.columns([4]).every(function() {
            var column = this;

            var select = $('<select><option value=""></option></select>')
              .appendTo($("thead tr:eq(1) td").eq(this.index()))
              .on('change', function() {
                var val = $.fn.dataTable.util.escapeRegex(
                  $(this).val()
                );

                column
                  .search(val ? '^' + val + '$' : '', true, false)
                  .draw();
              });

            column.data().unique().sort().each(function(d, j) {
              select.append('<option value="' + d + '">' + d + '</option>')
            });

          });
        }
    });
</script>
<script>
  function upload(id){
    $("#rencana-kerja-id").val(id);
  }

  function deleteFile(id) {
    $("#file-id").val(id);

    // open modal
    $("#modal-delete-file").modal("show");
  }

  function detail(status, nilai, keterangan){
    // change value
    $("#option-selected").html(status);
    $("#nilai-rencana-kerja").val(nilai);
    $("#keterangan").val(keterangan);
  }

  function changePeriode(event) {
      var periode = event.target.value;

      table.column(3).search(periode);
      table.draw()

    }

</script>
@endpush
@endsection