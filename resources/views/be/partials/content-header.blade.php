<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{$title}} {{$action ?? ''}}</h1>
    @if(!isset($action))
        <a href="{{$route}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                class="fas {{$icon ?? 'fa-plus'}} fa-sm text-white-50"></i> Create</a>
    @endif

</div>
