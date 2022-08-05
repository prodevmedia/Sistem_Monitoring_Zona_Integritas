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
                <select name="type" id="" class="form-control" required>
                  <option disabled selected>Pilih Reform / Pemenuhan</option>
                  <option value="refrom" @if ($scoringPengungkit->type == "refrom")
                      selected
                  @endif>Reform</option>
                  <option  @if ($scoringPengungkit->type == "pemenuhan")
                    selected
                @endif value="pemenuhan">Pemenuhan</option>
                </select>                
              </div>
              <div class="col-6">
                <select name="tahun" id="" class="form-control" required>
                  <option disabled selected>Pilih Tahun</option>
                  @foreach ($tanggal as $item)                    
                    <option @if ($item == $scoringPengungkit->tahun)
                      selected
                  @endif value="{{$item}}">{{$item}}</option>
                  @endforeach
                </select>
              </div>              
            </div><br>
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
                  <input type="number" style="font-size:15px; width: auto; !important; border:none; background-color:none;" min="0.00" step="0.01" name="pengungkit[bobot]" id="" value="{{$scoringPengungkit->bobot}}">
                </td>
                <td>
                  <input type="text"  style="font-size:15px; width: auto; !important; border:none; background-color:none;" name="pengungkit[penjelasan]" id=""  value="{{$scoringPengungkit->penjelasan}}">
                </td>
                <td>
                  <input type="text"  style="font-size:15px; width: auto; !important; border:none; background-color:none;" name="pengungkit[pilihan_jawaban]" id=""  value="{{$scoringPengungkit->pilihan_jawaban}}">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="pengungkit[jawaban]" id=""  value="{{$scoringPengungkit->jawaban}}">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="pengungkit[nilai]" id="" value="{{$scoringPengungkit->nilai}}">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="pengungkit[presentase]" id="" value="{{$scoringPengungkit->presentase}}">
                </td>
              </tr>
              <tr>
                <td colspan="9" align="center">Penilaian Master Unit Kerja</td>
              </tr>   
              @php
                  $scoringUnitKerja = \DB::table('scoring_master_unit_kerjas')->where('file_id',$fileid)->where('unit_kerja_id',$id)->first();                  
              @endphp    
              <tr>
                <td>{{$user->masterunitkerja->name}}</td>   
                <td>
                  <input type="number" style="font-size:15px; width: auto; !important; border:none; background-color:none;" min="0.00" step="0.01" name="masterunitkerja[bobot]" id="" value="{{$scoringUnitKerja->bobot}}">
                </td>
                <td>
                  <input type="text"  style="font-size:15px; width: auto; !important; border:none; background-color:none;" name="masterunitkerja[penjelasan]" id="" value="{{$scoringUnitKerja->penjelasan}}">
                </td>
                <td>
                  <input type="text"  style="font-size:15px; width: auto; !important; border:none; background-color:none;" name="masterunitkerja[pilihan_jawaban]" id="" value="{{$scoringUnitKerja->pilihan_jawaban}}">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="masterunitkerja[jawaban]" id="" value="{{$scoringUnitKerja->jawaban}}">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="masterunitkerja[nilai]" id="" value="{{$scoringUnitKerja->nilai}}">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="masterunitkerja[presentase]" id="" value="{{$scoringUnitKerja->presentase}}">
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
                  <input type="hidden" name="areaperubahan[id][]" id="" value="{{$item->id}}">
                  {{$item->nama_area_perubahan}}
                </td>   
                <td>
                  <input type="number" style="font-size:15px; width: auto; !important; border:none; background-color:none;" min="0.00" step="0.01" name="areaperubahan[bobot][]" id="" value="{{$scoringArea->bobot}}">
                </td>
                <td>
                  <input type="text"  style="font-size:15px; width: auto; !important; border:none; background-color:none;" name="areaperubahan[penjelasan][]" id="" value="{{$scoringArea->penjelasan}}">
                </td>
                <td>
                  <input type="text"  style="font-size:15px; width: auto; !important; border:none; background-color:none;" name="areaperubahan[pilihan_jawaban][]" id="" value="{{$scoringArea->pilihan_jawaban}}">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="areaperubahan[jawaban][]" id="" value="{{$scoringArea->jawaban}}">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="areaperubahan[nilai][]" id="" value="{{$scoringArea->nilai}}">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="areaperubahan[presentase][]" id="" value="{{$scoringArea->presentase}}">
                </td>
              </tr>    
              @foreach ($item->subarea as $subarea)
              @php
                  $scoringSubArea = \DB::table('scoring_sub_area_perubahans')->where('area_perubahan_id',$item->id)->where('sub_area_perubahan_id',$subarea->id)->where('file_id',$fileid)->where('unit_kerja_id',$id)->first();                  
              @endphp              
              <tr style="background-color: #f2463a; color:white">
                <td width="20%">       
                  <input type="hidden" name="subareaperubahan[id][][{{$item->id}}]" id="" value="{{$subarea->id}}">
                  {!!wordwrap($subarea->name_sub_area_perubahan,50,"<br>\n", false)!!}
                </td>   
                <td>
                  <input type="number" style="font-size:15px; width: auto; !important; border:none; background-color:none;" min="0.00" step="0.01" name="subareaperubahan[bobot][][{{$item->id}}]" id="" value="{{$scoringSubArea->bobot}}">
                  </td>
                  <td>
                    {!!wordwrap($subarea->penjelasan,50,"<br>\n", false)!!}
                  </td>
                  <td>
                    {!!wordwrap($subarea->pilihan_jawaban,50,"<br>\n", false)!!}
                  </td>
                  <td>
                    @php
                        $jawaban = explode("/",$subarea->pilihan_jawaban);                        
                    @endphp
                    <select name="subareaperubahan[jawaban][][{{$item->id}}]" class="form-control" id="">
                      @foreach ($jawaban as $item2)
                          <option value="{{$item2}}" @if ($item2 == $scoringSubArea->jawaban)
                              selected
                          @endif>{{$item2}}</option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="subareaperubahan[nilai][][{{$item->id}}]" id=""  value="{{$scoringSubArea->nilai}}">
                  </td>
                  <td>
                    <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="subareaperubahan[presentase][][{{$item->id}}]" id=""  value="{{$scoringSubArea->presentase}}">
                  </td>
                </tr>    
              @endforeach
              @endforeach
            </tbody>
          </table>
            </div> <br>
            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-success" style="width: 100%;">Submit</button>
              </div>
            </div>
          {{-- </div> --}}
        </form>
      </div>
    </div>
</div>
@endsection