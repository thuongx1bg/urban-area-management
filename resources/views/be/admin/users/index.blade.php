@extends('be.layouts.admin')
@section('title')
    <title>Users</title>
@endsection
@section('css')
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        @include('be.partials.content-header',['title'=>'Users','route'=>route('user.create')])
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
                <h6 class="m-0 font-weight-bold text-primary">List Users</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered data-table " id="dataTable" width="100%" cellspacing="0"">

                    <thead>

                    <tr>

                        <th>No</th>

                        <th>Name</th>
                        <th>UserName</th>
                        <th>Email</th>
                        <th>Building</th>
                        <th>Status</th>




                        <th width="100px">Action</th>

                    </tr>

                    </thead>

                    <tbody>

                    </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection
@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {


            var table = $('.data-table').DataTable({

                processing: true,

                serverSide: true,

                ajax: "{{ route('user.index') }}",

                columns: [

                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'username', name: 'username'},
                    {data: 'email', name: 'email'},
                    {data: 'building', name: 'building'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: true, searchable: true},

                ]

            });



        });

    </script>

    <script src="{{ asset('be/js/delete.js') }}"></script>

@endsection
