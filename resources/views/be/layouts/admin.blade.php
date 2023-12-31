<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://static.thenounproject.com/png/3503944-200.png" type="image/gif">
    @yield('title')
    <!-- Custom fonts for this template-->
    <link href="{{asset('template-admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('template-admin/css/sb-admin-2.min.css')}}" rel="stylesheet">
    @yield('css')


</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    @include('be.partials.sidebar')
    <!-- End of Sidebar -->


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            @include('be.partials.header')
            <!-- End of Topbar -->


            <!-- Begin Page Content -->
            @yield('content')
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        @include('be.partials.footer')
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"
                > Logout</a>
            </div>
        </div>
    </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
<!-- Bootstrap core JavaScript-->
<script src="{{asset('template-admin/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('template-admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('template-admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('template-admin/js/sb-admin-2.min.js')}}"></script>

<!-- Page level plugins -->
<script src="{{asset('template-admin/vendor/chart.js/Chart.min.js')}}"></script>

<!-- Page level custom scripts -->
{{--<script src="{{asset('template-admin/js/demo/chart-area-demo.js')}}"></script>--}}
<script src="{{asset('template-admin/js/demo/chart-pie-demo.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script src="{{asset('vendor/sweetalert2/sweetalert2@11.js')}}"></script>
<script src="https://js.pusher.com/4.4/pusher.min.js"></script>

<script type="text/javascript">
    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        encrypted: true,
        cluster: "ap1"
    });
    var channel = pusher.subscribe('NotificationEvent');
    channel.bind('send-message', function (data) {
        var canUpdateNotification = @json(auth()->user()->can('update_notification'));
        var checkAdmin = @json(auth()->user()->roles[0]->id );
        var idUser =  @json(auth()->user()->id );
        var checkCan = "";
        if(canUpdateNotification){
             checkCan += '123';
        }
        var newNotificationHtml = `
         <a class="dropdown-item d-flex align-items-center" href="`+checkCan+`">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-info-circle text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">${data.name}</div>
                                <span class="font-weight-bold">${data.notification}</span>
                            </div>
          </a>
        `;

        if(checkAdmin != data.role ){
            if(checkAdmin == 2 && idUser == data.user_id)
            {
                $('.menu-notification').prepend(newNotificationHtml);
            }else if(checkAdmin != 2){
                $('.menu-notification').prepend(newNotificationHtml);
            }
        }

    });
</script>

@yield('js')
</body>

</html>
