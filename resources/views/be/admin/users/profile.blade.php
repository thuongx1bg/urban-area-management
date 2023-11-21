@extends('be.layouts.admin')
@section('title')
    <title>Users</title>
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        @include('be.partials.content-header',['title'=>'Users', 'action'=>'/ profile'])
{{--        <section style="background-color: #eee;">--}}
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
                                <div class="d-flex justify-content-center mb-2">
                                    <a style="margin-right: 5px" href="{{route('user.edit',['id'=>$user->id])}}" type="button" class="btn btn-primary">Edit Profile</a>
                                    <a href="{{route('user.change_password',['id'=>$user->id])}}" type="button" class="btn btn-outline-primary ms-1">Change Password</a>
                                </div>

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
    </div>

@endsection
@section('js')
    <script>
        $( document ).ready(function() {
            $(".edit-profile").click(function(){
                $(".disabled").removeAttr("disabled");
                $(".edit-profile").attr('style','display: none !important');
                $(".btn-save").attr('style','display: block !important');

            });
        });
    </script>

@endsection
