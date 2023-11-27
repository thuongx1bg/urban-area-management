@extends('layouts.app')

@section('content')


                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div style="background: url(http://khobatdongsan24h.vn/image/catalog/du-an/list/6-2020/Khu-do-thi-viet-hung-1.jpg) !important;" class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                <form class="user" method="POST" action="{{ route('login') }}">
                        @csrf

                                    <div class="form-group">

                                        <input  class="form-control form-control-user @error('username') is-invalid @enderror"
                                               id="username" aria-describedby="emailHelp"
                                               placeholder="Enter username ..." name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                               id="password" placeholder="Password" name="password" required autocomplete="current-password">
                                        @error('password')
                                       <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                       </span>
                                       @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customCheck">Remember
                                                Me</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                                                            {{ __('Login') }}
                                                                        </button>
{{--                                    <hr>--}}
{{--                                    <a href="index.html" class="btn btn-google btn-user btn-block">--}}
{{--                                        <i class="fab fa-google fa-fw"></i> Login with Google--}}
{{--                                    </a>--}}
{{--                                    <a href="index.html" class="btn btn-facebook btn-user btn-block">--}}
{{--                                        <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook--}}
{{--                                    </a>--}}
                                </form>
                                <hr>
                                @if (Route::has('password.request'))
                                    <div class="text-center">
                                        <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                                    </div>
                                @endif

                                <div class="text-center">
                                    <a class="small" href="{{url('/register')}}">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>


@endsection
