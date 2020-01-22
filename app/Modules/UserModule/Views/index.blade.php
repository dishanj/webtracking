@extends('layouts.master') @section('title','User Add')

@section('css')
@stop

@section('content')

    <section class="content-header">
        <h1>Add User</h1>
        <ol class="breadcrumb">
            <li><a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a></li>
            <li><a href="{{{url('user/list')}}}">User List</a></li>
            <li class="active">Add User</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="container-fluid">
            <div class="">
                <div class="col-md-12">

                        <form role="form" action="{{url('user/add')}}" class="form-horizontal" method="post" onSubmit="return checkPassword();">
                            {{ csrf_field() }}

                        <div class="row">
                            <div class="form-group col-md-3 m-b-5">
                                <label class="control-label required">First Name</label>
                                <input type="text" class="form-control @if($errors->has('first_name')) error @endif"  id="first_name" name="first_name" placeholder="First Name">
                                @if($errors->has('first_name'))
                                    <label id="label-error" style="color: red" class="error" for="first_name">{{$errors->first('first_name')}}</label>
                                @endif
                            </div>

                            <div class="form-group col-md-3 m-b-5">
                                <label class="control-label required">Last Name</label>
                                <input type="text" class="form-control @if($errors->has('last_name')) error @endif"  id="last_name" name="last_name" placeholder="Last  Name">
                                @if($errors->has('last_name'))
                                    <label id="label-error" style="color: red" class="error" for="last_name">{{$errors->first('last_name')}}</label>
                                @endif
                            </div>

                            <div class="form-group col-md-3 m-b-5">
                                <label class="control-label required">User Name(E-mail)</label>
                                <input type="email" class="form-control @if($errors->has('user_name')) error @endif"  id="user_name" name="user_name" placeholder="User Name"  value="{{Input::old('user_name')}}">
                                @if($errors->has('user_name'))
                                    <label id="label-error" style="color: red" class="error" for="user_name">{{$errors->first('user_name')}}</label>
                                @endif
                            </div>
                        </div>

                            <div class="row">
                                <div class="form-group col-md-3 m-b-5">
                                    <label class="control-label required">Password</label>
                                    <input type="password" class="form-control @if($errors->has('password')) error @endif"  id="password" name="password" placeholder="Password">
                                    @if($errors->has('password'))
                                        <label id="label-error" style="color: red" class="error" for="password">{{$errors->first('password')}}</label>
                                    @endif
                                </div>

                                <div class="form-group col-md-3 m-b-5">
                                    <label class="control-label required">Password Confirm</label>
                                    <input type="password" class="form-control @if($errors->has('password_confirm')) error @endif"  id="password_confirm" name="password_confirm" placeholder="Password Confirm">
                                    @if($errors->has('password_confirm'))
                                        <label id="label-error" style="color: red" class="error" for="password_confirm">{{$errors->first('password_confirm')}}</label>
                                    @endif
                                </div>

                                <div class="form-group col-md-3 m-b-5">
                                    <label class="control-label required">User Role</label>
                                    {!! Form::select('user_role',$role, Input::old('user_role'),['class'=>'form-control','style'=>'width:100%;','data-placeholder'=>'Choose User Role','id'=>'user_role']) !!}
                                    @if($errors->has('user_role'))
                                        <label id="label-error" style="color: red" class="error" for="user_role">{{$errors->first('user_role')}}</label>
                                    @endif
                                </div>
                            </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-default btn-submit mr-2">
                                <i class="fa fa-floppy-o"></i> Save
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
    $( document ).ready(function() {
        $('#merchant').prop('disabled', true);
    });    

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