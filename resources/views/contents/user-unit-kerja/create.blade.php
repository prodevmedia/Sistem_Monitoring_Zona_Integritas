@extends('master')
@section('unitkerjaactive','active')
@section('title',"Create User Unit Kerja")
@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('userUnitKerja.index')}}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Create User Unit Kerja</li>
        </ol>
    </nav>  
    <form action="{{route('userUnitKerja.store')}}" method="post">    
        @csrf
        <label for="">Nama</label><br>
        <input type="text" name="name" id="" class="form-control" placeholder="Nama"><br>
        @error('name')
            <div style="color:red">{{$message}}</div><br>
        @enderror        
        <label for="">Email</label><br>
        <input type="email" name="email" id="" class="form-control" placeholder="Email"><br>
        @error('email')
            <div style="color:red">{{$message}}</div><br>
        @enderror        
        <label for="">Password</label><br>
        <input type="password" name="password" id="" class="form-control" placeholder="Password"><br>
        @error('password')
            <div style="color:red">{{$message}}</div><br>
        @enderror        
        <label for="">Unit Kerja</label><br>
        <select name="master_unit_kerja_id" id="" class="form-control">
            <option selected disabled>Pilih</option>
            @foreach ($masterunitkerja as $key=>$item)
                <option value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
        </select> <br>
        @error('unit_kerja')
            <div style="color:red">{{$message}}</div><br>
        @enderror       
        <button type="submit" class="btn btn-success btn-sm btn-submit">Submit</button>
    </form>
</div>
@push('scriptjs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
@endsection