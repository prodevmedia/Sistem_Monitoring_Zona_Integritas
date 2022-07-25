@extends('master')
@section('unitkerjaactive','active')
@section('title',"Edit User Unit Kerja")
@section('content')
<div class="container py-4">
  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('unitkerja.index')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit User Unit Kerja</li>
      </ol>
  </nav>  
  <form action="{{route('unitkerja.update',$unitkerja->id)}}" method="post">    
      @method('put')
      @csrf
      <label for="">Nama</label><br>
      <input type="text" name="name" id="" class="form-control" placeholder="Nama" value="{{$unitkerja->name}}"><br>
      @error('name')
          <div style="color:red">{{$message}}</div><br>
      @enderror        
      <label for="">Email</label><br>
      <input type="email" name="email" id="" class="form-control" placeholder="Email" value="{{$unitkerja->email}}"><br>
      @error('email')
          <div style="color:red">{{$message}}</div><br>
      @enderror        
      <label for="">Password</label><br>
      <input type="password" name="password" id="" class="form-control" placeholder="Password"><br>
      @error('password')
          <div style="color:red">{{$message}}</div><br>
      @enderror        
      {{-- <label for="">Username</label><br>
      <input type="text" name="username" id="" class="form-control" placeholder="Username"><br>
      @error('username')
          <div style="color:red">{{$message}}</div><br>
      @enderror         --}}
      <label for="">Unit Kerja</label><br>
      <select name="unit_kerja" id="" class="form-control">
          <option selected disabled>Pilih</option>
          @foreach ($masterunitkerja as $key=>$item)
              <option value="{{$item->id}}" @if ($item->id == $unitkerja->unit_kerja_id)
                  selected
              @endif>{{$item->name}}</option>
          @endforeach
      </select> <br>
      @error('unit_kerja')
          <div style="color:red">{{$message}}</div><br>
      @enderror       
      <button type="submit" class="btn btn-success btn-sm btn-submit">Submit</button>
  </form>
</div>
@endsection