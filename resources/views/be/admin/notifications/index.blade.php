@extends('be.layouts.admin')
@section('title')
    <title>Notifications</title>
@endsection
@section('css')
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        @include('be.partials.content-header',['title'=>'Notifications', 'action'=>'/ detail'])
        {{--        <section style="background-color: #eee;">--}}
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-5" >
                <div class="card mb-4" style="padding-bottom: 28px">
                    <div class="card-body text-center">
                        <img src="https://static-images.vnncdn.net/files/publish/2022/9/3/bien-vo-cuc-thai-binh-346.jpeg" alt="avatar"
                             class="rounded-circle img-fluid" style="width: 150px;">
                        <h5 class="my-3">{{$user->name}}</h5>
                        <p class="text-muted mb-1">{{$user->email}}</p>
                        <p class="text-muted mb-4">{{ $user->building->address }}</p>
                        <div style="margin-bottom: 30px">{!! QrCode::generate(route('qr.infor',['qr_id'=> $qrId])); !!}</div>
{{--                        <div class="d-flex justify-content-center mb-2">--}}
{{--                            <a style="margin-right: 5px" href="{{route('user.edit',['id'=>$user->id])}}" type="button" class="btn btn-primary">Edit Profile</a>--}}
{{--                            <a href="{{route('user.change_password',['id'=>$user->id])}}" type="button" class="btn btn-outline-primary ms-1">Change Password</a>--}}
{{--                        </div>--}}

                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Full Name</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->name}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->email}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Phone</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->phone}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Id Card</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->cmt}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Username</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->username}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Roles</p>
                            </div>
                            <div class="col-sm-9">
                                @foreach($user->roles as $role)
                                    <p class="text-muted mb-0">{{$role->name}}</p>
                                @endforeach
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Building</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->building->name}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Address</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$user->building->address}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Status</p>
                            </div>
                            <div class="col-sm-9">
                                @php
                                    $status = $user->status;
                                @endphp
                                @if($status == 1)
                                    <div class="btn btn-success btn-icon-split btn-lg " style="padding: 0px 7px">Accepted</div>
                                @elseif($status == -1)
                                    <div class="btn btn-danger btn-icon-split btn-lg " style="padding: 0px 7px">Rejected</div>
                                @else
                                    <div class="btn btn-warning btn-icon-split btn-lg " style="padding: 0px 7px">Pending</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--        </section>--}}
        <div class="row d-flex justify-content-center">
            <div class="d-flex justify-content-center mb-2">
                <a style="margin-right: 5px" href="{{route('user.edit',['id'=>$user->id])}}" type="button" class="btn btn-primary">Edit Profile</a>
                @if($user->status == 0)

                    <a href="{{route('user.accept',['id'=>$user->id,'status'=>1])}}" type="button" class="btn btn-success ms-1">Accept</a>
                @else
                    <a href="{{route('user.accept',['id'=>$user->id,'status'=>0])}}" type="button" class="btn btn-danger ms-1">Reject</a>
                @endif
            </div>
        </div>
    </div>

@endsection
