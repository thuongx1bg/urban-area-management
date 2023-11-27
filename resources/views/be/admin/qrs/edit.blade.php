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
                        <div class="form-group col-md-3">
                            <label for="inputEmail4">Name <span class="text-danger">*</span></label>
                            <input @if(!$checkEdit) disabled @endif  value="{{old('name') ?? $qr->name }}" name="name" type="text" class="form-control @error('name') is-invalid @enderror " id="inputEmail4" placeholder="Name">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputEmail4">Phone Number <span class="text-danger">*</span></label>
                            <input @if(!$checkEdit) disabled @endif  value="{{old('phone') ?? $qr->phone }}" name="phone" type="text" class="form-control @error('name') is-invalid @enderror " id="inputEmail4" placeholder="Phone Number">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Date  <span class="text-danger">*</span> </label>
                            <input @if(!$checkEdit) disabled @endif  value="{{old('date') ?? $qr->date }}" name="date" type="datetime-local" class="form-control @error('date') is-invalid @enderror" id="date"/>
                            @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Gender <span class="text-danger">*</span> </label>
                            <div class="d-flex"><div class="form-check" style="margin-right: 10px">
                                    <input @if(!$checkEdit) disabled @endif  @if($qr->gender == 1) checked @endif  class="form-check-input" type="radio" value="1" name="gender" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Male
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input @if(!$checkEdit) disabled @endif  @if($qr->gender == 0) checked @endif  class="form-check-input" type="radio" value="0" name="gender" id="flexRadioDefault2" >
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Famle
                                    </label>
                                </div></div>

                        </div>

                    </div>
                    <div class="form-row ">
                        <div class="form-group col-md-6" >
                            <label for="exampleFormControlTextarea1">Note</label>
                            <textarea @if(!$checkEdit) disabled @endif name="note" class="form-control" id="exampleFormControlTextarea1" rows="3">{{old('note') ?? $qr->note}}</textarea>
                        </div>
                        <div class="form-group col-md-6 " style="text-align: center">
                            <label for="exampleFormControlTextarea1"></label>
                            {!! QrCode::size(200)->generate(route('qr.infor',['qr_id'=>$qr->id])); !!}
                        </div>
                    </div>
                    <button  @if(!$checkEdit) hidden @endif type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>

    </div>

@endsection
