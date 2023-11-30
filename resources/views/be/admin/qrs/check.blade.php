@extends('be.layouts.admin')
@section('title')
    <title>QrCode</title>
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        @include('be.partials.content-header',['title'=>'QrCodes','action'=>'/ check'])
        @if(isset($check))
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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered data-table " id="dataTable" width="100%" cellspacing="0"">

                    <thead>

                    <tr>
                        @if(isset($qr))
                        <th>Qr Number</th>
                            @if($qr->own_id != 0)
                        <th>Guest's name</th>
                                <th>Phone</th>
                                <th>Gender</th>
                        <th>Note</th>

                            @endif
                        @endif
                        <th >Name's homeowner</th>
                        <th >Address</th>

                    </tr>

                    </thead>

                    <tbody>
                        <tr>
                            @if(isset($qr))
                            <td >{{ $qr->id }}</td>
                                @if($qr->own_id != 0)
                            <td>{{$qr->name}}</td>
                                    <td>{{$qr->phone}}</td>

                                    <td>{{$qr->gender == 1 ? "Male" : "Female"}}</td>
                            <td>{{$qr->note}}</td>

                                @endif
                            @endif
                            <td>{{ isset($user) ? $user->name : ''}}</td>
                            <td>{{ isset($user) ? $user->building->name : ''}}</td>
                        </tr>
                    </tbody>

                    </table>
                </div>

            </div>
        </div>
        @endif
        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form</h6>
            </div>
            <div class="card-body">
                <form id="target" method="post" action="{{route('qr.check')}}" >
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Data</label>
                        <textarea autofocus name="note" class="form-control" id="exampleFormControlTextarea1" rows="8">{{old('note') }}</textarea>
                    </div>
                    <button hidden  id="submitButton" type="submit" class="btn btn-success">Check</button>
                </form>
            </div>
        </div>

    </div>

@endsection
@section('js')
    <script>
        let typingTimer;
        // Set the delay time in milliseconds (e.g., 1000 ms = 1 second)
        const doneTypingInterval = 1000;

        // Listen for keyup events on the input field
        $('#exampleFormControlTextarea1').keyup(function () {
            // Clear the previous timeout
            clearTimeout(typingTimer);

            // Set a new timeout
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        // Function to be called after typing is done
        function doneTyping() {
            $('#submitButton').click();
            // $('#exampleFormControlTextarea1').val('');
            // Add your code to handle the event after typing is done
            // For example, you can fetch data, submit a form, etc.
        }

    </script>
@endsection
