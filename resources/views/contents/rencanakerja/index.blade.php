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
        <button type="button" class="close btn btn-sm btn-danger" style="color: white" data-dismiss="alert"
          aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
  </div>
  @endif

  @if (Session::has('error'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <div class="d-flex justify-content-between">
      <div class="d-flex justify-content-start">
        <strong>Error!</strong>&nbsp;{{Session::get('error')}}
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
              <option value="{{$item->id}}">{{$item->tahun}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-12 col-md-6 text-end">
          <a class="btn btn-success" href="javascript:;" onclick="event.preventDefault();
          document.getElementById('cetak-form').submit();">Cetak</a>
          <form id="cetak-form" action="{{ route('rencanakerja.print') }}" method="POST" class="d-none">
            @csrf
            <input type="hidden" name="periode_id" id="periode-id-print" value="all">
          </form>
          <a class="btn btn-primary" href="{{route('rencanakerja.create')}}">Tambah Rencana Kerja</a>
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
              <th>Realisasi</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
            <tr>
              <td></td>
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
              <td>{{$item->status != 'Belum Upload' ? \Carbon\Carbon::parse($item->updated_at)->isoFormat('dddd, D MMMM Y') : ''}}</td>
              <td>{{$item->status}}</td>
              <td>
                @if ($item->periode->is_active)
                <a href="{{route('rencanakerja.edit',$item->id)}}" class="btn btn-sm btn-warning">Edit</a>
                <a href="#" onclick="hapus({{$item->id}})" rel="noopener noreferrer"
                  class="btn btn-sm btn-danger">Hapus</a>                    
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
  table = $('#unitkerjatable').DataTable( {
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: false,
        orderCellsTop: true,
        initComplete: function() {
          var table = this.api();

          // Add filtering
          table.columns([2, 5]).every(function() {
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
        },
        dom: 'Bfrtip',
        buttons: [
            'print'
        ]
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
          axios.post("{{route('rencanakerja.delete')}}", {          
            "_token":"{{csrf_token()}}",
            "id" : id
          })
          .then(function (response) {  
            console.log(response)
            if (response.data.status == 400) {
              Swal.fire(`${response.data.message}`, '', 'error').then(()=>{
                window.location = "{{route('rencanakerja.index')}}"
              })
            }else{

              Swal.fire('Terhapus!', '', 'success').then(()=>{
                window.location = "{{route('rencanakerja.index')}}"
              })
            }
          })
        } else if (result.isDenied) {
          Swal.fire('Hapus Di batalkan', '', 'info')
        }
      })
    }

    function changePeriode(event) {
      var select = event.target;
      var id = select.value;

      var periode = select.options[select.selectedIndex].text;

      if (periode == '') {
        $('#periode-id-print').val('all');
      } else {
        $('#periode-id-print').val(id);
      }

      table.column(3).search(periode);
      table.draw()

    }
</script>
@endpush
@endsection