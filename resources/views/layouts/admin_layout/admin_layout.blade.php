<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    {{-- Sweet Alert --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/af-2.3.5/b-1.7.0/b-colvis-1.7.0/b-html5-1.7.0/b-print-1.7.0/cr-1.5.3/date-1.0.3/fc-3.3.2/fh-3.1.8/kt-2.6.1/r-2.2.7/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.3/datatables.min.css"/>
    {{-- <link rel="stylesheet" href="{{ url('css/datatable/datatables.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}"> --}}
      <!-- Select2 -->
    <link rel="stylesheet" href="{{ url ('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ url ('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ url('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('css/admin_css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ url('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ url('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ url('plugins/summernote/summernote-bs4.min.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('sweet::alert')

        @include('layouts.admin_layout.admin_header')

        @include('layouts.admin_layout.admin_sidebar')

        @yield('content')

        @include('layouts.admin_layout.admin_footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ url('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ url('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
    <!-- Bootstrap 4 -->
    <script src="{{ url('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ url('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ url('plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ url('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ url('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ url('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ url('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ url('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ url('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ url('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('js/admin_js/adminlte.js') }}"></script>

    <!-- DataTables  & Plugins -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/af-2.3.5/b-1.7.0/b-colvis-1.7.0/b-html5-1.7.0/b-print-1.7.0/cr-1.5.3/date-1.0.3/fc-3.3.2/fh-3.1.8/kt-2.6.1/r-2.2.7/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.3/datatables.min.js"></script>

    {{-- <script src="{{ url('plugins/datatables/jquery.dataTables.min.js')}}"></script> --}}
    {{-- <script src="{{ url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ url('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{ url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script> --}}

    <script src="{{ url('plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{ url('plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{ url('plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ url('js/admin_js/demo.js') }}"></script>
    <script src="{{url('plugins/select2/js/select2.full.min.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ url('js/admin_js/pages/dashboard.js') }}"></script>
    <script src="{{ url('js/admin_js/admin_script.js')}}"></script>
    <script src="{{ url('js/admin_js/imagePrev.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
    </script>
    <!-- bs-custom-file-input -->
    <script src="{{ url('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
          var fileName = $(this).val().split("\\").pop();
          $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
        </script>

    <!-- Page specific script -->
<script>
    $(function () {
        $('#sections').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend: 'print', title: 'Data', exportOptions: { columns: ':visible' } },
            { extend: 'pdfHtml5', title: 'PDF', download: 'open', exportOptions: { columns: ':visible' } },
            { extend: 'copyHtml5', exportOptions: { columns: ':visible' } },
            { extend: 'csvHtml5', title: 'CSV', exportOptions: { columns: ':visible' } },
            { extend: 'excelHtml5', title: 'Excel', exportOptions: { columns: ':visible' } },
            { extend: 'colvis', text: 'Visibility Column' }
        ]
        });
    });

    $(function () {
        $('#categories').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend: 'print', title: 'Data', exportOptions: { columns: ':visible' } },
            { extend: 'pdfHtml5', title: 'PDF', download: 'open', exportOptions: { columns: ':visible' } },
            { extend: 'copyHtml5', exportOptions: { columns: ':visible' } },
            { extend: 'csvHtml5', title: 'CSV', exportOptions: { columns: ':visible' } },
            { extend: 'excelHtml5', title: 'Excel', exportOptions: { columns: ':visible' } },
            { extend: 'colvis', text: 'Visibility Column' }
        ]
        });
    });

    $(function () {
        $('#products').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend: 'print', title: 'Data', exportOptions: { columns: ':visible' } },
            { extend: 'pdfHtml5', title: 'PDF', download: 'open', exportOptions: { columns: ':visible' } },
            { extend: 'copyHtml5', exportOptions: { columns: ':visible' } },
            { extend: 'csvHtml5', title: 'CSV', exportOptions: { columns: ':visible' } },
            { extend: 'excelHtml5', title: 'Excel', exportOptions: { columns: ':visible' } },
            { extend: 'colvis', text: 'Visibility Column' }
        ]
        });
    });

    $(function () {
        $('#brands').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend: 'print', title: 'Data', exportOptions: { columns: ':visible' } },
            { extend: 'pdfHtml5', title: 'PDF', download: 'open', exportOptions: { columns: ':visible' } },
            { extend: 'copyHtml5', exportOptions: { columns: ':visible' } },
            { extend: 'csvHtml5', title: 'CSV', exportOptions: { columns: ':visible' } },
            { extend: 'excelHtml5', title: 'Excel', exportOptions: { columns: ':visible' } },
            { extend: 'colvis', text: 'Visibility Column' }
        ]
        });
    });

    $(function () {
        $('#banners').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend: 'print', title: 'Data', exportOptions: { columns: ':visible' } },
            { extend: 'pdfHtml5', title: 'PDF', download: 'open', exportOptions: { columns: ':visible' } },
            { extend: 'copyHtml5', exportOptions: { columns: ':visible' } },
            { extend: 'csvHtml5', title: 'CSV', exportOptions: { columns: ':visible' } },
            { extend: 'excelHtml5', title: 'Excel', exportOptions: { columns: ':visible' } },
            { extend: 'colvis', text: 'Visibility Column' }
        ]
        });
    });

    $(function () {
        $('#coupon').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend: 'print', title: 'Data', exportOptions: { columns: ':visible' } },
            { extend: 'pdfHtml5', title: 'PDF', download: 'open', exportOptions: { columns: ':visible' } },
            { extend: 'copyHtml5', exportOptions: { columns: ':visible' } },
            { extend: 'csvHtml5', title: 'CSV', exportOptions: { columns: ':visible' } },
            { extend: 'excelHtml5', title: 'Excel', exportOptions: { columns: ':visible' } },
            { extend: 'colvis', text: 'Visibility Column' }
        ]
        });
    });

  </script>
</body>

</html>
