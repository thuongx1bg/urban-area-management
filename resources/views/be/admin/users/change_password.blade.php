@extends('be.layouts.admin')
@section('title')
    <title>Users</title>
@endsection

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        @include('be.partials.content-header',['title'=>'Users', 'action'=>'/ change password'])

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form</h6>
            </div>
            <div class="card-body">
                <form enctype="multipart/form-data" method="post" action="{{route('user.update_password',['id'=> $id])}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Password <span class="text-danger">*</span></label>
                            <input  name="password" type="password" class="form-control @error('password') is-invalid @enderror " placeholder="Enter Password">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputAddress">Password Confirm <span class="text-danger">*</span></label>
                            <input name="password_confirm" type="password" class="form-control @error('password_confirm') is-invalid @enderror" placeholder="Enter Password Confirm ">
                            @error('password_confirm')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>

    </div>

@endsection

