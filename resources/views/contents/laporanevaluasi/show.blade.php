@extends('master')
@section('lembarkerjaevaluasiactive','active')
@section('title',"Penilaian Lembar Evaluasi")
@section('content')
<div class="container-fluid py-4">
  <div class="card">
      <div class="card-header">            
      </div>
      <div class="card-body">
        <form action="{{route('laporanevaluasi.update')}}" method="post">
          @php
            $scoringPengungkit = \DB::table('scoring_pengungkits')->where('file_id',$fileid)->where('unit_kerja_id',$id)->first();                  
          @endphp 
          <input type="hidden" name="user_id" value="{{$user->id}}">
          <input type="hidden" name="file_id" value="{{$user->file->id}}">
          @csrf          
          {{-- <div class="customTable"> --}}
            <div class="row">
              <div class="col-6">
                {{strtoupper($scoringPengungkit->type)}}
              </div>
            </div><br>
            <div class="row">
              <div class="col-6">
                Tahun {{$scoringPengungkit->tahun}}
              </div>
            </div>
            <div class="table-responsive">

              <table class="table table-striped table-bordered" style="margin-bottom: 0; width:100%;">
                <thead>
              <tr>
                <td colspan="9" align="center">Penilaian Pengungkit</td>
              </tr>
              <tr>
                <th >Penilaian</th>
                <th >Bobot</th>
                <th >Penjelasan</th>
                <th >Pilihan Jawaban</th>
                <th >Jawaban</th>              
                <th >Nilai</th>
                <th >%</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Pengungkit</td>                   
                <td>
                  {{$scoringPengungkit->bobot}}
                </td>
                <td>
                  {{$scoringPengungkit->penjelasan}}
                </td>
                <td>
                  {{$scoringPengungkit->pilihan_jawaban}}
                </td>
                <td>
                  {{$scoringPengungkit->jawaban}}
                </td>
                <td>
                  {{$scoringPengungkit->nilai}}
                </td>
                <td>
                  {{$scoringPengungkit->presentase}}
                </td>
              </tr>
              <tr>
                <td colspan="9" align="center">Penilaian Master Unit Kerja</td>
              </tr>   
              @php
                  $scoringUnitKerja = \DB::table('scoring_master_unit_kerjas')->where('file_id',$fileid)->where('unit_kerja_id',$id)->first();                  
              @endphp    
              <tr>
                <td>{{$user->masterunitkerja->name_unit_kerja}}</td>   
                <td>
                  {{$scoringUnitKerja->bobot}}
                </td>
                <td>
                  {{$scoringUnitKerja->penjelasan}}
                </td>
                <td>
                  {{$scoringUnitKerja->pilihan_jawaban}}
                </td>
                <td>
                  {{$scoringUnitKerja->jawaban}}
                </td>
                <td>
                  {{$scoringUnitKerja->nilai}}
                </td>
                <td>
                  {{$scoringUnitKerja->presentase}}
                </td>
              </tr>    
              <tr>
                <td colspan="9" align="center">Penilaian 
                  <span style="background-color: #8ce62c; color:white; width:120px; height:20px;">Area Perubahan</span> & 
                  <span style="background-color: #f2463a; color:white; width:120px; height:20px;">Sub Area Perubahan</span>
                </td>
              </tr>    
              @foreach ($user->masterunitkerja->areaperubahan as $item)
              @php
                  $scoringArea = \DB::table('scoring_area_perubahans')->where('file_id',$fileid)->where('unit_kerja_id',$id)->first();                  
              @endphp              
              <tr style="background-color: #8ce62c; color:white">
                <td>
                  {{$item->nama_area_perubahan}}
                </td>   
                <td>
                  {{$scoringArea->bobot}}
                </td>
                <td>
                  {{$scoringArea->penjelasan}}
                </td>
                <td>
                  {{$scoringArea->pilihan_jawaban}}
                </td>
                <td>
                  {{$scoringArea->jawaban}}
                </td>
                <td>
                  {{$scoringArea->nilai}}
                </td>
                <td>
                  {{$scoringArea->presentase}}
                </td>
              </tr>    
              @foreach ($item->subarea as $subarea)
              @php
                  $scoringSubArea = \DB::table('scoring_sub_area_perubahans')->where('area_perubahan_id',$item->id)->where('sub_area_perubahan_id',$subarea->id)->where('file_id',$fileid)->where('unit_kerja_id',$id)->first();                  
              @endphp              
              <tr style="background-color: #f2463a; color:white">
                <td width="20%">       
                  {!!wordwrap($subarea->name_sub_area_perubahan,50,"<br>\n", false)!!}
                </td>   
                <td>
                  {{$scoringSubArea->bobot}}
                  </td>
                  <td>
                    {!!wordwrap($subarea->penjelasan,50,"<br>\n", false)!!}
                  </td>
                  <td>
                    {!!wordwrap($subarea->pilihan_jawaban,50,"<br>\n", false)!!}
                  </td>
                  <td>
                    {{$scoringSubArea->jawaban}}
                  </td>
                  <td>
                    {{$scoringSubArea->nilai}}
                  </td>
                  <td>
                    {{$scoringSubArea->presentase}}
                  </td>
                </tr>    
              @endforeach
              @endforeach
            </tbody>
          </table>
            </div> <br>            
          {{-- </div> --}}
        </form>
      </div>
    </div>
</div>
@endsection