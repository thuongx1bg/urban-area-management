@extends('be.layouts.admin')
@section('title')
    <title>Buildings</title>
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        @include('be.partials.content-header',['title'=>'Houses', 'action'=>'/ edit'])

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('building.update',['id'=>$building->id])}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="inputEmail4">Name <span class="text-danger">*</span></label>
                            <input value="{{old('name') ?? $building->name}}" name="name" type="text" class="form-control @error('name') is-invalid @enderror " id="inputEmail4" placeholder="Name">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-7">
                            <label for="inputAddress">Address <span class="text-danger">*</span></label>
                            <input value="{{old('address') ?? $building->address}}" name="address" type="text" class="form-control @error('address') is-invalid @enderror" id="inputAddress" placeholder="Address ">
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Note</label>
                        <textarea name="note" class="form-control" id="exampleFormControlTextarea1" rows="3">{{old('note') ?? $building->note}}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>

    </div>

@endsection
