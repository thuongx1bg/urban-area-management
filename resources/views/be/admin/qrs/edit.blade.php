@extends('be.layouts.admin')
@section('title')
    <title>QrCode</title>
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        @include('be.partials.content-header',['title'=>'QrCodes','action'=>'/ edit'])

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('qr.update',['id'=>$qr->id])}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="inputEmail4">Name <span class="text-danger">*</span></label>
                            <input value="{{old('name') ?? $qr->name }}" name="name" type="text" class="form-control @error('name') is-invalid @enderror " id="inputEmail4" placeholder="Name">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-7" style="text-align: center">
                            {!! QrCode::generate(route('qr.infor',['qr_id'=>$qr->id])); !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Note</label>
                        <textarea name="note" class="form-control" id="exampleFormControlTextarea1" rows="3">{{old('note') ?? $qr->note}}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>

    </div>

@endsection
