@extends('master')
@section('lembarkerjaevaluasiactive','active')
@section('title',"Penilaian Lembar Evaluasi")
@section('content')
<div class="container-fluid py-4">
  <div class="card">
      <div class="card-header">            
      </div>
      <div class="card-body">
        <form action="{{route('laporanevaluasi.store')}}" method="post">
          <input type="hidden" name="user_id" value="{{$user->id}}">
          <input type="hidden" name="file_id" value="{{$user->file->id}}">
          @csrf          
          {{-- <div class="customTable"> --}}
            <div class="row">
              <div class="col-6">
                <select name="type" id="" class="form-control" required>
                  <option disabled selected>Pilih Reform / Pemenuhan</option>
                  <option value="refrom">Reform</option>
                  <option value="pemenuhan">Pemenuhan</option>
                </select>
              </div>
              <div class="col-6">
                <select name="tahun" id="" class="form-control" required>
                  <option disabled selected>Pilih Tahun</option>
                  @foreach ($tanggal as $item)                    
                    <option value="{{$item}}">{{$item}}</option>
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
                  <input type="number" style="font-size:15px; width: auto; !important; border:none; background-color:none;" min="0.00" step="0.01" name="pengungkit[bobot]" id="">
                </td>
                <td>
                  <input type="text"  style="font-size:15px; width: auto; !important; border:none; background-color:none;" name="pengungkit[penjelasan]" id="">
                </td>
                <td>
                  <input type="text"  style="font-size:15px; width: auto; !important; border:none; background-color:none;" name="pengungkit[pilihan_jawaban]" id="">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="pengungkit[jawaban]" id="">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="pengungkit[nilai]" id="">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="pengungkit[presentase]" id="">
                </td>
              </tr>
              <tr>
                <td colspan="9" align="center">Penilaian Master Unit Kerja</td>
              </tr>    
              <tr>
                <td>{{$user->masterunitkerja->name_unit_kerja}}</td>   
                <td>
                  <input type="number" style="font-size:15px; width: auto; !important; border:none; background-color:none;" min="0.00" step="0.01" name="masterunitkerja[bobot]" id="">
                </td>
                <td>
                  <input type="text"  style="font-size:15px; width: auto; !important; border:none; background-color:none;" name="masterunitkerja[penjelasan]" id="">
                </td>
                <td>
                  <input type="text"  style="font-size:15px; width: auto; !important; border:none; background-color:none;" name="masterunitkerja[pilihan_jawaban]" id="">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="masterunitkerja[jawaban]" id="">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="masterunitkerja[nilai]" id="">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="masterunitkerja[presentase]" id="">
                </td>
              </tr>    
              <tr>
                <td colspan="9" align="center">Penilaian 
                  <span style="background-color: #8ce62c; color:white; width:120px; height:20px;">Area Perubahan</span> & 
                  <span style="background-color: #f2463a; color:white; width:120px; height:20px;">Sub Area Perubahan</span>
                </td>
              </tr>    
              @foreach ($user->masterunitkerja->areaperubahan as $item)              
              <tr style="background-color: #8ce62c; color:white">
                <td>
                  <input type="hidden" name="areaperubahan[id][]" id="" value="{{$item->id}}">
                  {{$item->nama_area_perubahan}}
                </td>   
                <td>
                  <input type="number" style="font-size:15px; width: auto; !important; border:none; background-color:none;" min="0.00" step="0.01" name="areaperubahan[bobot][]" id="">
                </td>
                <td>
                  <input type="text"  style="font-size:15px; width: auto; !important; border:none; background-color:none;" name="areaperubahan[penjelasan][]" id="">
                </td>
                <td>
                  <input type="text"  style="font-size:15px; width: auto; !important; border:none; background-color:none;" name="areaperubahan[pilihan_jawaban][]" id="">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="areaperubahan[jawaban][]" id="">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="areaperubahan[nilai][]" id="">
                </td>
                <td>
                  <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="areaperubahan[presentase][]" id="">
                </td>
              </tr>    
              @foreach ($item->subarea as $subarea)
              <tr style="background-color: #f2463a; color:white">
                <td width="20%">       
                  <input type="hidden" name="subareaperubahan[id][][{{$item->id}}]" id="" value="{{$subarea->id}}">
                  {!!wordwrap($subarea->name_sub_area_perubahan,50,"<br>\n", false)!!}
                </td>   
                <td>
                  <input type="number" style="font-size:15px; width: auto; !important; border:none; background-color:none;" min="0.00" step="0.01" name="subareaperubahan[bobot][][{{$item->id}}]" id="">
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
                          <option value="{{$item2}}">{{$item2}}</option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="subareaperubahan[nilai][][{{$item->id}}]" id="">
                  </td>
                  <td>
                    <input type="text" style="font-size:15px; width: auto; !important; border:none; background-color:none;"  name="subareaperubahan[presentase][][{{$item->id}}]" id="">
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