@extends('be.layouts.admin')
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
                <form method="post" action="{{route('user.store')}}">
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
                            <input value="{{old('address')}}" name="username" type="text" class="form-control @error('username') is-invalid @enderror" id="inputAddress" placeholder="Username ">
                            @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email <span class="text-danger">*</span></label>
                            <input value="{{old('email') }}" name="email" type="text" class="form-control @error('email') is-invalid @enderror " id="inputEmail4" placeholder="Email">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlSelect1">Building <span class="text-danger">*</span></label>
                            <select name="building_id" class="form-control" id="exampleFormControlSelect1">
                                @foreach($buildings as $building)
                                    <option @if($building->id == old('building_id')) selected @endif value="{{$building->id}}">{{$building->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlSelect1">Password: <span class="btn btn-info btn-icon-split">123456789</span> </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>

    </div>

@endsection
