@extends('be.layouts.admin')
@section('css')
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        @include('be.partials.content-header',['title'=>'Buildings','route'=>route('user.create')])
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
        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List Buildings</h6>
            </div>
            <div class="card-body">
                @if($check)


                    oke
                @else

                    error
                @endif
            </div>
        </div>

    </div>

@endsection

