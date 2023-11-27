@extends('be.layouts.admin')
@section('title')
    <title>QrCode</title>
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        @include('be.partials.content-header',['title'=>'QrCodes','route'=>route('qr.create'),'action'=>'/ create'])

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('qr.store')}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputEmail4">Name <span class="text-danger">*</span></label>
                            <input value="{{old('name')}}" name="name" type="text" class="form-control @error('name') is-invalid @enderror " id="inputEmail4" placeholder="Name">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label for="inputEmail4">Phone Number <span class="text-danger">*</span></label>
                            <input value="{{old('phone')}}" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror " id="inputEmail4" placeholder="Phone Number">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Date  <span class="text-danger">*</span> </label>
                            <input value="{{old('date') }}" name="date" type="datetime-local" class="form-control @error('date') is-invalid @enderror" id="date"/>
                            @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Gender <span class="text-danger">*</span> </label>
                            <div class="d-flex"><div class="form-check" style="margin-right: 10px">
                                    <input checked class="form-check-input" type="radio" value="1" name="gender" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Male
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="0" name="gender" id="flexRadioDefault2" checked>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Famle
                                    </label>
                                </div></div>

                        </div>
{{--                        <div class="form-group col-md-7">--}}
{{--                            <label for="inputAddress">Address <span class="text-danger">*</span></label>--}}
{{--                            <input value="{{old('address')}}" name="address" type="text" class="form-control @error('address') is-invalid @enderror" id="inputAddress" placeholder="Address ">--}}
{{--                            @error('address')--}}
{{--                            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Note <span class="text-danger">*</span></label>
                        <textarea name="note" class="form-control @error('note') is-invalid @enderror" id="exampleFormControlTextarea1" rows="3">{{old('note')}}</textarea>
                        @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>

    </div>

@endsection
