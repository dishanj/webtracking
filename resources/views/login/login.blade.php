{{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}
{{--	<meta charset="utf-8">--}}
{{--	<meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--	<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">--}}
{{--	<meta name="author" content="Presto">--}}
{{--	<!-- App Favicon -->--}}
{{--	<link rel="shortcut icon" href="{{asset('images/icon/favicon.ico')}}">--}}
{{--	<!-- App title -->--}}
{{--	<title>Login - Presto</title>--}}
{{--	<!-- Bootstrap CSS -->--}}
{{--	<link href="{{asset('src/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />--}}
{{--	<!-- App CSS -->--}}
{{--	<link href="{{asset('src/css/styles.css')}}" rel="stylesheet" type="text/css"/>--}}
{{--	<script src="assets/js/modernizr.min.js"></script>--}}
{{--</head>--}}
{{--<body>--}}

{{--<div class="account-pages"></div>--}}
{{--<div class="clearfix"></div>--}}
{{--<div class="wrapper-page">--}}
{{--	<div class="account-bg">--}}
{{--		<div class="card-box mb-0">--}}
{{--			<div class="text-center m-t-20 ">--}}
{{--				<a class="logo">--}}
{{--					<i class="icon-c-logo"></i>--}}
{{--				</a>--}}
{{--			</div>--}}
{{--			<div class="m-t-20">--}}
{{--				<div class="row">--}}
{{--					<div class="col-12">--}}
{{--						<h6 class="text-title">Sign In</h6>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--				@if (session('error'))--}}
{{--					<div class="alert alert-danger">--}}
{{--						{{ session('error') }}--}}
{{--					</div>--}}
{{--				@endif--}}
{{--				<form class="m-t-10"  role="form" method="POST" action="{{ url('user/login') }}">--}}
{{--					{{ csrf_field() }}--}}
{{--					<div class="form-group row">--}}
{{--						<div class="col-12">--}}
{{--							<label for="email">Email address</label>--}}
{{--							<input class="form-control" type="email" name="email">--}}
{{--						</div>--}}
{{--					</div>--}}

{{--					<div class="form-group row">--}}
{{--						<div class="col-12">--}}
{{--							<label for="email">Password</label>--}}
{{--							<input class="form-control" type="password" name="password" >--}}
{{--						</div>--}}
{{--					</div>--}}

{{--					<div class="form-group row">--}}
{{--						<div class="col-12">--}}
{{--							<div class="checkbox checkbox-custom">--}}
{{--								<input id="checkbox-signup" type="checkbox">--}}
{{--								<label for="checkbox-signup">--}}
{{--									Remember me--}}
{{--								</label>--}}
{{--							</div>--}}
{{--						</div>--}}
{{--					</div>--}}

{{--					<div class="form-group text-center row m-t-10">--}}
{{--						<div class="col-12">--}}
{{--							<button class="btn btn-success btn-block" type="submit">Sign In</button>--}}
{{--						</div>--}}
{{--					</div>--}}

{{--				</form>--}}
{{--			</div>--}}

{{--			<div class="clearfix"></div>--}}
{{--		</div>--}}
{{--	</div>--}}
{{--	<!-- end card-box-->--}}
{{--</div>--}}
{{--<!-- end wrapper page -->--}}


{{--<script>--}}
{{--    var resizefunc = [];--}}
{{--</script>--}}

{{--<!-- jQuery  -->--}}
{{--<script src="{{asset('js/jquery.min.js')}}"></script>--}}
{{--<script src="{{asset('js/popper.min.js')}}"></script><!-- Popper for Bootstrap -->--}}
{{--<script src="{{asset('js/bootstrap.min.js')}}"></script>--}}
{{--<script src="{{asset('Login/js/main.js')}}"></script>--}}
{{--<!-- App js -->--}}
{{--<script src="{{asset('js/jquery.core.js')}}  assets/js/jquery.core.js"></script>--}}
{{--<script src="{{asset('js/jquery.app.js')}}  assets/js/"></script>--}}

{{--</body>--}}
{{--</html>--}}



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>efl - login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
	<meta content="Coderthemes" name="author" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<!-- App favicon -->
	<link rel="shortcut icon" href="assets/images/favicon.ico">
	<!-- App css -->
	<link href="{{asset('efl/assets/css/bootstrap.min.css')}} " rel="stylesheet" type="text/css" />
	<link href="{{asset('efl/assets/css/icons.css')}} " rel="stylesheet" type="text/css" />
	<link href="{{asset('efl/assets/css/style.css')}} " rel="stylesheet" type="text/css" />
	<script src="{{asset('efl/assets/js/modernizr.min.js')}} "></script>
</head>

<body>
<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="wrapper-page">
					<div class="m-t-40 card-box">
						<div class="text-center">
							<h2 class="text-uppercase m-t-0 m-b-25">
                                            <span>
                                                <img src="{{asset('efl/assets/images/logo/logo.gif')}}" alt="" height="50">
                                            </span>
							</h2>
							<!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
						</div>
						<div class="account-content">
							@if (session('error'))
								<div class="alert alert-danger">
									{{ session('error') }}
								</div>
							@endif

							<form class="form-horizontal" role="form" method="POST" action="{{ url('user/login') }}">
									{{ csrf_field() }}

{{--								<div class="form-group m-b-5">--}}
{{--									<div class="col-12">--}}
{{--										<label>Company Code:</label>--}}
{{--										<input class="form-control" type="email"  required="">--}}
{{--									</div>--}}
{{--								</div>--}}

								<div class="form-group m-b-5">
									<div class="col-12">
										<label for="email">Email</label>
										<input class="form-control" type="email" name="email">
									</div>
								</div>

								<div class="form-group m-b-5">
									<div class="col-12">
										<label for="password">Password</label>
										<input class="form-control" type="password" name="password" >
									</div>
								</div>

								<div class="form-group m-b-5">
									<div class="col-12">
										<div class="checkbox checkbox-primary">
											<input id="checkbox5" type="checkbox">
											<label for="checkbox5">Remember me</label>
										</div>
									</div>
								</div>

								<div class="form-group account-btn text-center">
									<div class="col-12">
										<button class="btn btn-primary btn-block btn-login" type="submit">Login</button>
										<a href="#" class="text-muted pull-left a-link m-t-10">Forgot your password?</a>
									</div>
								</div>

							</form>

							<div class="clearfix"></div>

						</div>
					</div>
					<!-- end card-box-->
					<div class="m-t-40 card-box">
						<div class="account-content">
							<form class="form-horizontal" action="#">

								<div class="form-group m-b-5">
									<div class="col-12">
										<label>Shipment/House Bill/Direct Master Number:</label>
										<input class="form-control" type="text" required="">
									</div>
								</div>
								<div class="form-group account-btn text-center m-b-5">
									<div class="col-12">
										<button class="btn btn-primary btn-block btn-login" type="submit">Find</button>
									</div>
								</div>
							</form>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
				<!-- end wrapper -->
			</div>
		</div>
	</div>
</section>


<script>
	var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="{{asset('efl/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('efl/assets/js/popper.min.js')}}"></script>
<script src="{{asset('efl/assets/js/bootstrap.min.js')}} "></script>
<script src="{{asset('efl/assets/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('Login/js/main.js')}}"></script>
<!-- App js -->
<script src="{{asset('efl/assets/js/jquery.core.js')}}"></script>
<script src="{{asset('efl/assets/js/jquery.app.js')}}"></script>

</body>
</html>





