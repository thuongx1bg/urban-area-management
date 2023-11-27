@extends('be.layouts.admin')
@section('title')
    <title>QrCode</title>
@endsection
@section('css')
    <style>
        html,
        body {
            height: 100%;
            background-color: rgba(213,225,239,255);
        }

        .container {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            padding: 15px;
            border-radius: 15px;
            text-align: center;
        }

        .card-img-top {
            border-radius: 10px;
        }

        .card-title {
            padding: 10px;
            font-size: 16px;
        }

        .card-text {
            font-size: 13px;
            color: grey;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        @include('be.partials.content-header',['title'=>'QrCodes','route'=>route('user.create')])
        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Result check QrCode</h6>
            </div>
            <div class="card-body">
                @if($check)
                    <div class="alert alert-success" role="alert">
                        This qr code is valid
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        This qr code is not valid
                    </div>
                @endif
            </div>
        </div>

    </div>

@endsection

