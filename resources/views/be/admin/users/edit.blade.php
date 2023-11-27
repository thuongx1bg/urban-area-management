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
        @include('be.partials.content-header',['title'=>'Users', 'action'=>'/ edit'])

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form</h6>
            </div>
            <div class="card-body">
                <form disabled=""  enctype="multipart/form-data" method="post" action="{{route('user.update',['id'=> $user->id])}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Name <span class="text-danger">*</span></label>
                            <input @if($user->id == 1) disabled @endif   value="{{old('name') ?? $user->name}}" name="name" type="text" class="form-control @error('name') is-invalid @enderror " id="inputEmail4" placeholder="Name">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputAddress">UserName <span class="text-danger">*</span></label>
                            <input  @if($user->id == 1) disabled @endif  value="{{$user->username}}" name="username" type="text" class="form-control @error('username') is-invalid @enderror" id="inputAddress" placeholder="Username ">
                            @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Phone Number </label>
                            <input @if($user->id == 1) disabled @endif  value="{{old('phone') ?? $user->phone}}" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror " id="inputEmail4" placeholder="Phone Number">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Id Card </label>
                            <input @if($user->id == 1) disabled @endif  value="{{old('cmt') ?? $user->cmt}}" name="cmt" type="text" class="form-control @error('cmt') is-invalid @enderror" id="inputAddress" placeholder="Id Card ">
                            @error('cmt')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Date of birth  <span class="text-danger">*</span></label>
                            <input @if($user->id == 1) disabled @endif  value="{{old('date') ?? $user->date}}" name="date" type="date" class="form-control @error('date') is-invalid @enderror" id="inputAddress" placeholder="Date of birth ">
                            @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div @if($checkOwn) hidden @endif class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input @if($user->id == 1) disabled @endif  value="{{old('email') ?? $user->email}}" name="email" type="text" class="form-control @error('email') is-invalid @enderror " id="inputEmail4" placeholder="Email">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlSelect1">Houses <span class="text-danger">*</span></label>
                            <select @if($user->id == 1 || $checkOwn) disabled @endif  name="building_id" class="form-control" id="exampleFormControlSelect1">
                                @foreach($buildings as $building)
                                    <option @if($building->id == $user->building->id) selected @endif value="{{$building->id}}">{{$building->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlSelect1">Status <span class="text-danger">*</span></label>
                            <select @if($user->id == 1|| $checkOwn) disabled @endif  name="status" class="form-control" id="exampleFormControlSelect1">
                                <option @if($user->status == 1) selected @endif value="1">Accept</option>
                                <option @if($user->status == 0) selected @endif value="0" >Pending</option>
                                <option @if($user->status == -1) selected @endif value="-1" >Reject</option>
                            </select>
                        </div>
                        <div @if( $checkOwn) hidden @endif  class="form-group col-md-6">
                            <label for="exampleFormControlSelect1">Roles <span class="text-danger">*</span></label>
                            <select @if($user->id == 1 ) disabled @endif  multiple name="role_id[]" class="form-control select-2" id="exampleFormControlSelect1">
                                @foreach($roles as $role)
                                    @if($role->id != 1)
                                    <option
                                        {{$roleOfUser->contains('id',$role->id)?'selected':''}}
                                        value="{{$role->id}}">{{$role->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="exampleFormControlSelect1">Reset Password: <span class="btn btn-info btn-icon-split">123456789</span> </label>
                            <select @if($user->id == 1) disabled @endif  name="reset_password" class="form-control" id="exampleFormControlSelect1">
                                <option value="1">Yes</option>
                                <option value="0" selected>No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3 ">
                            <label></label>
                            <div class="form-check" style="margin-right: 10px">
                                <input @if($user->id == 1) disabled @endif  @if($user->gender == 1) checked @endif class="form-check-input" type="radio" value="1" name="gender" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Male
                                </label>
                            </div>
                            <div class="form-check">
                                <input @if($user->id == 1) disabled @endif  @if($user->gender == 0) checked @endif class="form-check-input" type="radio" value="0" name="gender" id="flexRadioDefault2" >
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Famle
                                </label>
                            </div>
                        </div>

                    </div>

                    <button @if($user->id == 1) hidden="" @endif  type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>

    </div>

@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select-2').select2({
            'placeholder':'Choose roles'
        })
    </script>
@endsection
