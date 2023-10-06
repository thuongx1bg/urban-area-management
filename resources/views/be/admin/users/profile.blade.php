@extends('be.layouts.admin')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        @include('be.partials.content-header',['title'=>'Users', 'action'=>'/ profile'])

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('user.update',['id'=> $user->id])}}">
                    <div class="form-row" >
                        @csrf
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Name <span class="text-danger">*</span></label>
                            <input  disabled value="{{old('name') ?? $user->name}}" name="name" type="text" class="disabled form-control @error('name') is-invalid @enderror " id="inputEmail4" placeholder="Name">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputAddress">UserName <span class="text-danger">*</span></label>
                            <input disabled value="{{old('address') ?? $user->username}}" name="username" type="text" class="disabled form-control @error('username') is-invalid @enderror" id="inputAddress" placeholder="Username ">
                            @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email <span class="text-danger">*</span></label>
                            <input disabled value="{{old('email') ?? $user->email}}" name="email" type="text" class="disabled form-control @error('email') is-invalid @enderror " id="inputEmail4" placeholder="Email">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlSelect1">Building <span class="text-danger">*</span></label>
                            <select disabled name="building_id" class="disabled form-control" id="exampleFormControlSelect1">
                                @foreach($buildings as $building)
                                    <option @if($building->id == $user->building->id) selected @endif value="{{$building->id}}">{{$building->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row d-none" >
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlSelect1">Reset Password: <span class="btn btn-info btn-icon-split">123456789</span> </label>
                            <select name="reset_password" class="form-control" id="exampleFormControlSelect1">
                                <option value="1">Yes</option>
                                <option value="0" selected>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex">

                        <button type="submit" class="d-none btn-save btn btn-success"> Save</button>

                        <div  class="btn btn-success edit-profile">Edit Profile</div>
                    </div>

                </form>
            </div>
        </div>

    </div>

@endsection
@section('js')
    <script>
        $( document ).ready(function() {
            $(".edit-profile").click(function(){
                $(".disabled").removeAttr("disabled");
                $(".edit-profile").attr('style','display: none !important');
                $(".btn-save").attr('style','display: block !important');

            });
        });
    </script>

@endsection
