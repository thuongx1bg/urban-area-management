@extends('be.layouts.admin')
@section('title')
    <title>Users</title>
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
    .select2-selection{
        height: calc(1.5em + 0.75rem + 2px);
        border: 1px solid #d1d3e2 !important;
    }

    </style>
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        @include('be.partials.content-header',['title'=>'Users','route'=>route('user.create'),'action'=>'/ create'])

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('user.store')}}"  enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Name <span class="text-danger">*</span></label>
                            <input value="{{old('name') }}" name="name" type="text" class="form-control @error('name') is-invalid @enderror " id="inputEmail4" placeholder="Name">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputAddress">UserName <span class="text-danger">*</span></label>
                            <input value="{{old('username')}}" name="username" type="text" class="form-control @error('username') is-invalid @enderror" id="inputAddress" placeholder="Username ">
                            @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div  class="form-group col-md-6">
                            <label for="inputEmail4">Phone Number </label>
                            <input value="{{old('phone') }}" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror " id="inputEmail4" placeholder="Phone Number">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Id Card </label>
                            <input value="{{old('cmt') }}" name="cmt" type="text" class="form-control @error('cmt') is-invalid @enderror" id="inputAddress" placeholder="Id Card ">
                            @error('cmt')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Date of birth <span class="text-danger">*</span> </label>
                            <input value="{{old('date') }}" name="date" type="date" class="form-control @error('date') is-invalid @enderror" id="date"/>
                            @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>
                    <div class="form-row">
                        <div @if($checkOwn) hidden @endif class="form-group col-md-6">
                            <label for="inputEmail4">Email </label>
                            <input value="{{old('email') }}" name="email" type="text" class="form-control @error('email') is-invalid @enderror " id="inputEmail4" placeholder="Email">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div @if($checkOwn) hidden @endif class="form-group col-md-6">
                            <label for="exampleFormControlSelect1">Houses <span class="text-danger">*</span></label>
                            <select  name="building_id" class="form-control" id="exampleFormControlSelect1">
                                @foreach($buildings as $building)
                                    <option @if($building->id == old('building_id') || $building->id == \Illuminate\Support\Facades\Auth::user()->building_id) selected @endif value="{{$building->id}}">{{$building->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div @if($checkOwn) hidden @endif class="form-row">
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlSelect1">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" id="exampleFormControlSelect1">
                                <option selected value="1">Accept</option>
                                <option @if($checkOwn) selected @endif value="0" >Pending</option>
                                <option value="-1" >Reject</option>
                            </select>
                        </div>
                        <div @if($checkOwn) hidden @endif class="form-group col-md-6">
                            <label for="exampleFormControlSelect1">Roles <span class="text-danger">*</span></label>
                            <select  style="height: 130%" multiple name="role_id[]" class="form-control select-2" id="exampleFormControlSelect1">
                                @foreach($roles as $r)
                                    @if($r->id != 1)
                                    <option  @if($checkOwn && $r->id == 2) selected @endif value="{{$r->id}}">{{$r->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="form-row">

                        <div style="display: none" class="form-group col-md-6">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>


                        <div style="display: none" class="form-group col-md-3">
                            <label for="exampleFormControlSelect1">Password: <span class="btn btn-info btn-icon-split">123456789</span> </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">New Password <span class="text-danger">*</span></label>
                            <input  name="password" type="password" class="form-control @error('password') is-invalid @enderror " placeholder="New Password">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputAddress">Confirm Password  <span class="text-danger">*</span></label>
                            <input name="password_confirm" type="password" class="form-control @error('password_confirm') is-invalid @enderror" placeholder="Confirm Password ">
                            @error('password_confirm')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                    </div>

                    <div>
                        <div class="form-group col-md-4 d-flex">
                            <div class="form-check" style="margin-right: 10px">
                                <input checked class="form-check-input" type="radio" value="1" name="gender" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Male
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="0" name="gender" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Female
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>

    </div>

@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select-2').select2({
            'placeholder':'Chọn vai trò',
            width: 'resolve'

        });
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
        $('.select-2').on("change", function() {
            console.log($('.select-2').val());
        });


    </script>
@endsection
