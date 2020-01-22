@extends('layouts.master') @section('title','User Update Password')

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
		<h1>User <small>Management</small> </h1>
		<ol class="breadcrumb">
			<li><a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a></li>
			<li><a href="#">Profile</a></li>
			<li class="active">Change My Password</li>
		</ol>
	</section>
	<section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Change My Password</h3>
                <div class="box-tools pull-right">
                </div>
            </div>

            <div class="box-body">
                <form role="form" action="{{url('user/change-my-password')}}" class="form-validation" method="post" onsubmit="return checkPassword();">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label required">Current Password</label>
                                <input type="password" class="form-control @if($errors->has('current_password')) error @endif"  id="current_password" name="current_password" placeholder="Current Password">
                                @if($errors->has('current_password'))
                                    <label id="label-error" style="color: red" class="error" for="current_password">{{$errors->first('current_password')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label required">New Password</label>
                                <input type="password" class="form-control @if($errors->has('password')) error @endif"  id="password" name="password" placeholder="Password">
                                @if($errors->has('password'))
                                    <label id="label-error" style="color: red" class="error" for="password">{{$errors->first('password')}}</label>
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label required">Confirm New Password</label>
                                <input type="password" class="form-control @if($errors->has('password_confirmation')) error @endif"  id="password_confirmation" name="password_confirmation" placeholder="Password Confirm">
                                @if($errors->has('password_confirmation'))
                                    <label id="label-error" style="color: red" class="error" for="password_confirmation">{{$errors->first('password_confirmation')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <button type="submit" class="btn btn-primary pull-right">
                                <i class="fa fa-floppy-o"></i> Update
                            </button>
                        </div>      
                    </div> 
                </form>
            </div> <!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->

@stop

@section('js')

<script type="text/javascript">
    
    function checkPassword(){
        var pwd = $("#password").val();
        var re_pwd = $("#password_confirmation").val();
        if(pwd != re_pwd){
            swal({
              title: "Ooops!",
              text: "Password does not match!",
              icon: "warning",
            });
            return false;
        }
        return true;
    }
</script>

@stop