@extends('layouts.master') @section('title','User Add')

@section('css')

<style type="text/css">
   .bg-white{
        background: #fff;
   }
   .skin-blue .content-header {
   	    background-color: #fff;
   	    padding: 10px;
   }

   .box{
   		border-top:none;	
   }


</style>  
@stop

@section('content')

	<section class="content-header">
		<h1>User <small>Profile</small> </h1>
		<ol class="breadcrumb">
			<li><a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a></li>
			<li><a href="{{{url('user/list')}}}">User</a></li>
			<li class="active">Profile</li>
		</ol>
	</section>
	<section class="content">
        <!-- Default box -->
        <div class="col-md-6">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{asset('AdminLTE/dist/img/user2-160x160.jpg')}}" alt="User profile picture">

                    <h3 class="profile-username text-center">
                        @if(Sentinel::check())
                            {{ Sentinel::getUser()->first_name }}  {{ Sentinel::getUser()->last_name }}
                        @endif
                    </h3>

                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">First Name</label>
                            <div class="col-sm-10">
                                <label for="inputName" class="col-sm-2 control-label">{{ Sentinel::getUser()->first_name }}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Last Name</label>
                            <div class="col-sm-10">
                                <label for="inputName" class="col-sm-2 control-label">{{ Sentinel::getUser()->last_name }}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <label for="inputName" class="col-sm-2 control-label">{{ Sentinel::getUser()->email }}</label>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>

        </div>
    </section><!-- /.content -->

@stop
