@extends('be.layouts.admin')
@section('title')
    <title>Roles</title>
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .row .card-header{
            background-color:aquamarine;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        @include('be.partials.content-header',['title'=>'Roles', 'action'=>'/ edit'])

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form</h6>
            </div>
            <div class="card-body">
                @php
                    $isAdmin = $role->id == 1 ? true : false;
                 @endphp
                <form  enctype="multipart/form-data"  method="post" action="{{route('role.update',['id'=>$role->id])}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Name <span class="text-danger">*</span></label>
                            <input @if($isAdmin) disabled @endif value="{{old('name') ?? $role->name}}" name="name" type="text" class="form-control @error('name') is-invalid @enderror " id="inputEmail4" placeholder="Name">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Role description</label>
                        <textarea @if($isAdmin) disabled @endif name="display_name" class="form-control" id="exampleFormControlTextarea1" rows="3">{{old('display_name') ?? $role->display_name }}</textarea>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <label for="">
                                    <input @if($isAdmin) disabled @endif type="checkbox" class="checkall">
                                </label>
                                Checkall
                            </div>
                            @foreach($permisstions as $permisstion)
                                <div class="row">
                                    <div class="card  mb-3 col-md-12" >
                                        <div class="card-header">
                                            <label for="">
                                                <input @if($isAdmin) disabled @endif type="checkbox" class="checkbox_wrapper">
                                            </label>
                                            Module {{$permisstion->name}}
                                        </div>
                                        <div class="row">
                                            @foreach($permisstion->permisstionsChildren as $permisstionItem)
                                                <div class="card-body text-primary col-md-3">
                                                    <h5 class="card-title">
                                                        <label for="">
                                                            <input @if($isAdmin) disabled @endif type="checkbox"
                                                                   {{  $permisstionCheck->contains('id',$permisstionItem->id) ? 'checked':''}}

                                                                   class="checkbox_children" name="permission_id[]" value="{{$permisstionItem->id}}">
                                                        </label>
                                                        {{$permisstionItem->name}}</h5>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button @if($isAdmin) hidden @endif type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>

    </div>

@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $('.select-2').select2({
            'placeholder':'Chọn vai trò'
        })
    </script>
    <script>
        $('.checkbox_wrapper').on('click',function(){
            $(this).parents('.card').find('.checkbox_children').prop('checked',$(this).prop('checked'));
        })
        $('.checkall').on('click',function(){
            $(this).parents().find('.checkbox_children').prop('checked',$(this).prop('checked'));
            $(this).parents().find('.checkbox_wrapper').prop('checked',$(this).prop('checked'));
        })
    </script>
@endsection
