
@extends('layouts.app')

@section('content')



                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div style="background: url(http://khobatdongsan24h.vn/image/catalog/du-an/list/6-2020/Khu-do-thi-viet-hung-1.jpg) !important;" class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input value="{{ old('name') }}" name="name" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="exampleFirstName"
                                               placeholder="Name" required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input value="{{ old('username') }}"  name="username" type="text" class="@error('username') is-invalid @enderror form-control form-control-user" id="exampleLastName"
                                               placeholder="Username">
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input  value="{{ old('phone') }}" name="phone" type="text" class="@error('phone') is-invalid @enderror form-control form-control-user" id="exampleFirstName"
                                               placeholder="Phone Number">
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input value="{{ old('cmt') }}" name="cmt" type="text" class="@error('cmt') is-invalid @enderror form-control form-control-user" id="exampleLastName"
                                               placeholder="Id Card">
                                        @error('cmt')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input  placeholder="Email Address" id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" >
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input placeholder="Date of birth" id="email" type="date" class="form-control form-control-user @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" >
                                        @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <select style="padding: 0.8rem 1rem;
    color: #6e707e;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #d1d3e2;
    width: 100%;" name="own_id" type="text" class="  form-control-user" id="exampleLastName"
                                                placeholder="Roles">
                                                <option  value="0">House owner</option>
                                                <option  value="1">House member</option>

                                        </select>
                                    </div>

                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <select name="gender" style="padding: 0.8rem 1rem;
    color: #6e707e;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #d1d3e2;
    width: 100%;" name="building_id" type="text" class=" form-select form-control-user" id="exampleLastName"
                                                placeholder="Gender">
                                                <option  value="1">Male</option>
                                                <option  value="0">Female</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <select name="building_id" style="padding: 0.8rem 1rem;
    color: #6e707e;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #d1d3e2;
    width: 100%;" name="building_id" type="text" class=" form-select form-control-user" id="exampleLastName"
                                                placeholder="Building">
                                            @foreach($buildings as $b)
                                                <option  value="{{$b->id}}">{{$b->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input value="{{ old('password') }}" id="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"
                                               id="exampleInputPassword" placeholder="Password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input value="{{ old('password_confirm') }}"
                                            name="password_confirm" required autocomplete="new-password"

                                            type="password" class="form-control form-control-user  @error('password_confirm') is-invalid @enderror"
                                               id="exampleRepeatPassword" placeholder=" Password Confirm">
                                        @error('password_confirm')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="{{url('login')}}">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>

@endsection
