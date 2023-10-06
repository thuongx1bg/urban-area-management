@extends('layouts.app')

@section('content')
            <!-- Content Row -->
            <div class="card shadow ">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Information</h6>
                </div>
                <div class="card-body" style="display: flex; justify-content: space-around">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Name's homeowner</th>
                            <th scope="col">Building</th>
                            <th scope="col">Guest's name</th>
                            <th scope="col">Note</th>
                            <th scope="col">QrCode</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$qr->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->building->name}}</td>
                            <td>{{$qr->name}}</td>
                            <td>{{$qr->note}}</td>
                            <td>{!! QrCode::generate(route('qr.infor',['qr_id'=>$qr->id])); !!}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
@endsection
