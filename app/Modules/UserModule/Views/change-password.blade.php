@extends('layouts.master') @section('title','User Update Password')

@section('css')
@stop

@section('content')
    <section class="content-header">
        <h1>Change Password</h1>
        <ol class="breadcrumb">
            <li><a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a></li>
            <li><a href="{{{url('user/list')}}}">User List</a></li>
            <li class="active">Change Password</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="container-fluid">
            <div class="">
                <div class="col-md-10">
                        <form role="form" action="{{url('user/reset')}}" class="form-horizontal" method="post" onsubmit="return checkPassword();">
                            {{ csrf_field() }}

                        <div class="row">
                            <div class="form-group col-md-4 m-b-5">
                                <label class="control-label required">Password</label>
                                <input type="password" class="form-control @if($errors->has('password')) error @endif"  id="password" name="password" placeholder="Password">
                                @if($errors->has('password'))
                                    <label id="label-error" style="color: red" class="error" for="password">{{$errors->first('password')}}</label>
                                @endif
                                <input type="hidden" name="user_id" id="user_id" value="{{ $id }}">
                            </div>

                            <div class="form-group col-md-4 m-b-5">
                                <label class="control-label required">Password Confirm</label>
                                <input type="password" class="form-control @if($errors->has('password_confirm')) error @endif"  id="password_confirm" name="password_confirm" placeholder="Password Confirm">
                                @if($errors->has('password_confirm'))
                                    <label id="label-error" style="color: red" class="error" for="password_confirm">{{$errors->first('password_confirm')}}</label>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-default btn-submit mr-2">
                                <i class="fa fa-floppy-o"></i> Update
                            </button>

                        </div>
                        <div class="form-group col-md-6 m-b-5">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

@stop

@section('js')

<script type="text/javascript">
    
    function checkPassword(){
        var pwd = $("#password").val();
        var re_pwd = $("#password_confirm").val();
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