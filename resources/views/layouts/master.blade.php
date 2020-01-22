<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>EFL | @yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('AdminLTE/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('AdminLTE/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('AdminLTE/dist/css/AdminLTE.min.css?ver=1.3')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('AdminLTE/dist/css/skins/_all-skins.min.css?ver=1.2')}}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{asset('AdminLTE/bower_components/morris.js/morris.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{asset('AdminLTE/bower_components/jvectormap/jquery-jvectormap.css')}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{asset('AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{asset('AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
  <!--Bootstrp -->
  <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}" >
  <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}" >
  <!--Bootstrp Toggle-->
  <link rel="stylesheet" href="{{asset('libraries/css/bootstrap-toggle.min.css')}}" >
  <!--Multi select -->
  <link rel="stylesheet" href="{{asset('libraries/css/multi-select.css')}}" >
  <!-- fileinput -->
  <link rel="stylesheet" href="{{asset('fileinput/css/fileinput.min.css')}}" >
  <!-- Srilanka Map CSS -->
  <link rel="stylesheet" href="{{asset('sriLanka-map/jsmaps/jsmaps.css')}}" >
  <link href="{{asset('src/css/styles-p.css')}}" rel="stylesheet" type="text/css"/>


  <!-- App favicon -->
{{--  <link rel="shortcut icon" href="{{asset('efl/assets/images/favicon.ico')}}">--}}
{{--  <!--Morris Chart CSS -->--}}
{{--  <link rel="stylesheet" href="{{asset('efl/assets/plugins/morris/morris.css')}} ">--}}
{{--  <!-- Plugins css-->--}}
{{--  <link href="{{asset('efl/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />--}}
{{--  <!-- App css -->--}}
{{--  <link href="{{asset('efl/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />--}}
{{--  <link href="{{asset('efl/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />--}}
{{--  <link href=" {{asset('efl/assets/css/metismenu.min.css')}}" rel="stylesheet" type="text/css" />--}}
{{--  <link href="{{asset('efl/assets/css/style.css')}}" rel="stylesheet" type="text/css" />--}}
{{--  <script src="{{asset('efl/assets/js/modernizr.min.js')}}"></script>--}}


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- INCLUDE css -->
  @yield('css')
  <!-- INCLUDE css -->

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i&display=swap" rel="stylesheet">
</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img style="width: 50px;padding: 3px;" src="{{asset('AdminLTE/dist/img/efl-logo.png')}}"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img style="width: 160px;" class="img-responsive" src="{{asset('AdminLTE/dist/img/logo.gif')}}"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Notifications: -->
          <!-- User Account: style can be found in dropdown.less -->
          @include('includes.useraccount')

        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    @include('includes.menu')
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      @yield('content')
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.2
    </div>
    <strong>Copyright &copy; 2019 <a href="#">EFL.</a></strong> All rights
    reserved.
  </footer>


  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery  -->
<script src=" {{asset('efl/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('efl/assets/js/popper.min.js ')}}"></script>
<script src=" {{asset('efl/assets/js/bootstrap.min.js')}}"></script>
<script src=" {{asset('efl/assets/js/metisMenu.min.js')}}"></script>
<script src=" {{asset('efl/assets/js/waves.js')}}"></script>
<script src=" {{asset('efl/assets/js/jquery.slimscroll.js')}}"></script>
<!--Morris Chart-->
<script src=" {{asset('efl/assets/plugins/morris/morris.min.js')}}"></script>
<script src=" {{asset('efl/assets/plugins/raphael/raphael-min.js')}}"></script>
<!-- Dashboard init -->
<script src=" {{asset('efl/assets/pages/jquery.dashboard.js')}}"></script>
<!-- App js -->
<script src=" {{asset('efl/assets/js/jquery.core.js')}}"></script>
<script src=" {{asset('efl/assets/js/jquery.app.js')}}"></script>
<script src="{{asset('efl/assets/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<!-- form advanced init js -->
<script src="{{asset('efl/assets/pages/jquery.form-advanced.init.js')}}"></script>





<!-- jQuery 3 -->
<script src="{{asset('AdminLTE/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('AdminLTE/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{asset('AdminLTE/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{asset('AdminLTE/bower_components/morris.js/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('AdminLTE/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{asset('AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('AdminLTE/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('AdminLTE/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{asset('AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{asset('AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('AdminLTE/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('AdminLTE/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('AdminLTE/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('AdminLTE/dist/js/demo.js')}}"></script>

<!--Multi select -->
<script src="{{asset('libraries/js/jquery.multi-select.js')}}"></script>

<!-- Sweet alert -->
<script src="{{asset('libraries/js/sweetalert.min.js')}}"></script>

<!-- Booststrp toggle -->
<script src="{{asset('libraries/js/bootstrap-toggle.min.js')}}"></script>

<!-- fileinput -->
<script src="{{asset('fileinput/js/fileinput.min.js')}}"></script>

<!-- quicksearch -->
<script src="{{asset('jquery/jquery.quicksearch.js')}}"></script>

<!-- canvas -->
<script src="{{asset('js/canvas-charts/canvasjs.min.js')}}"></script>

<!-- Srilanka Map JS -->
<script src="{{asset('sriLanka-map/jsmaps/jsmaps-libs.js')}}"></script>
<script src="{{asset('sriLanka-map/jsmaps/jsmaps-panzoom.js')}}"></script>
<script src="{{asset('sriLanka-map/jsmaps/jsmaps.min.js')}}"></script>
<script src="{{asset('sriLanka-map/maps/sriLanka.js')}}"></script>

<!-- amcharts -->
<script src="{{asset('js/amcharts/core.js')}}"></script>
<script src="{{asset('js/amcharts/charts.js')}}"></script>
<script src="{{asset('js/amcharts/animated.js')}}"></script>

<script type="text/javascript">
  @if(session('success'))
    swal({
      title: '{{session('success.title')}}',
      text: '{{session('success.message')}}',
      icon: "success",
    });
  @elseif(session('error'))
    swal({
      title: '{{session('error.title')}}',
      text: '{{session('error.message')}}',
      icon: "error",
    });
  @elseif(session('warning'))
    swal({
      title: '{{session('warning.title')}}',
      text: '{{session('warning.message')}}',
      icon: "warning",
    });
  @elseif(session('info'))
    swal({
      title: '{{session('info.title')}}',
      text: '{{session('info.message')}}',
      icon: "info",
    });
  @endif
</script>
@yield('js')
</body>
</html>



