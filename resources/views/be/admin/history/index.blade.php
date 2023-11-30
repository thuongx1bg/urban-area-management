@extends('be.layouts.admin')
@section('title')
    <title>History</title>
@endsection
@section('css')
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        @media screen and (max-width: 600px) {
            .th-house,  .th-rule{
                display: none;
            }

        }

    </style>
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
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
                <h6 class="m-0 font-weight-bold text-primary">History Event</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div style="margin: 10px 0px;" class="d-flex align-items-center ">
                        <span>Date Filter:</span>
                        <input style="margin-right: 10px;  color: #6e707e;  padding:5px;width: 295px;border: 1px solid #d1d3e2;border-radius: 0.2rem" type="text" name="daterange" value="" />
                        @php
                            $user = \Illuminate\Support\Facades\Auth::user();
                        @endphp
                        <select @if($user->roles[0]->id == 2) hidden @endif style="max-width: 180px;margin-right: 10px; "  name="building_id" class="form-control" id="exampleFormControlSelect1">
                            <option  value="0">All houses</option>

                            @foreach($buildings as $building)
                                <option @if($user->roles[0]->id == 2 && $user->building_id == $building->id) selected  @endif value="{{$building->id}}">{{$building->name}}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-success filter">Filter</button>
                    </div>
                    <table class="table table-bordered data-table " id="dataTable" width="100%" cellspacing="0"">

                    <thead>

                    <tr>

                        <th class="th-house">House</th>

                        <th>Name</th>
                        <th class="th-rule">Rule</th>
                        <th>Note</th>

                        <th>Date</th>

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

{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>--}}

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function() {
            $('input[name="daterange"]').daterangepicker({
                startDate: moment().subtract(1, 'M'),
                endDate: moment(),
                // startDate: new Date(),
                showDropdowns: true,
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 10,
                autoUpdateInput: true,
                locale: {
                    format: 'YYYY/MM/DD HH:mm'
                },
            });

            var table = $('.data-table').DataTable({

                processing: true,

                serverSide: true,

                ajax: {
                    url:"{{ route('history.index') }}",
                    data:function (d) {
                        d.from_date = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY/MM/DD HH:mm');
                        d.to_date = $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY/MM/DD HH:mm');
                        d.building_id = $('#exampleFormControlSelect1').val();
                    }
                },

                columns: [

                    {class:'th-house',data: 'house', name: 'house'},
                    {data: 'name', name: 'name'},
                    {class:'th-rule',data: 'rule', name: 'rule'},
                    {data: 'note', name: 'note'},
                    {data: 'date', name: 'date', orderable: true, searchable: true},

                ]

            });

            $(".filter").click(function(){
                table.draw();
            });


        });

    </script>

    <script src="{{ asset('be/js/delete.js') }}"></script>

@endsection

