@extends('be.layouts.admin')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        @include('be.partials.content-header',['title'=>'Users', 'action'=>'/ edit'])

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('user.update',['id'=> $user->id])}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Name <span class="text-danger">*</span></label>
                            <input value="{{old('name') ?? $user->name}}" name="name" type="text" class="form-control @error('name') is-invalid @enderror " id="inputEmail4" placeholder="Name">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputAddress">UserName <span class="text-danger">*</span></label>
                            <input value="{{old('address') ?? $user->username}}" name="username" type="text" class="form-control @error('username') is-invalid @enderror" id="inputAddress" placeholder="Username ">
                            @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Phone Number </label>
                            <input value="{{old('phone') ?? $user->phone}}" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror " id="inputEmail4" placeholder="Phone Number">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputAddress">Id Card </label>
                            <input value="{{old('cmt') ?? $user->cmt}}" name="cmt" type="text" class="form-control @error('cmt') is-invalid @enderror" id="inputAddress" placeholder="Id Card ">
                            @error('cmt')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email <span class="text-danger">*</span></label>
                            <input value="{{old('email') ?? $user->email}}" name="email" type="text" class="form-control @error('email') is-invalid @enderror " id="inputEmail4" placeholder="Email">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlSelect1">Building <span class="text-danger">*</span></label>
                            <select name="building_id" class="form-control" id="exampleFormControlSelect1">
                                @foreach($buildings as $building)
                                    <option @if($building->id == $user->building->id) selected @endif value="{{$building->id}}">{{$building->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlSelect1">Reset Password: <span class="btn btn-info btn-icon-split">123456789</span> </label>
                            <select name="reset_password" class="form-control" id="exampleFormControlSelect1">
                                <option value="1">Yes</option>
                                <option value="0" selected>No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlSelect1">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" id="exampleFormControlSelect1">
                                <option @if($user->status == 1) selected @endif value="1">Accept</option>
                                <option @if($user->status == 0) selected @endif value="0" >Pending</option>
                                <option @if($user->status == -1) selected @endif value="-1" >Reject</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>

    </div>

@endsection
