@extends('layouts.master') @section('title','User Update')

@section('css')
@stop

@section('content')

    <section class="content-header">
        <h1>Update User</h1>
        <ol class="breadcrumb">
            <li><a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a></li>
            <li><a href="{{{url('user/list')}}}">User List</a></li>
            <li class="active">Update User</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="container-fluid">
            <div class="">
                <div class="col-md-10">
                        <form role="form" action="{{url('user/update')}}" class="form-horizontal" method="post">
                            {{ csrf_field() }}

                        <div class="row">
                            <div class="form-group col-md-4 m-b-5">
                                <label class="control-label required">First Name</label>
                                <input type="text" class="form-control @if($errors->has('first_name')) error @endif"  id="first_name" name="first_name" placeholder="First Name" value="{{ $user->first_name }}">
                                @if($errors->has('first_name'))
                                    <label id="label-error" style="color: red" class="error" for="first_name">{{$errors->first('first_name')}}</label>
                                @endif
                                <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                            </div>

                            <div class="form-group col-md-4 m-b-5">
                                <label class="control-label required">Last Name</label>
                                <input type="text" class="form-control @if($errors->has('last_name')) error @endif"  id="last_name" name="last_name" placeholder="Last Name" value="{{ $user->last_name }}">
                                @if($errors->has('last_name'))
                                    <label id="label-error" style="color: red" class="error" for="last_name">{{$errors->first('last_name')}}</label>
                                @endif
                            </div>

                            <div class="form-group col-md-4 m-b-5">
                                <label class="control-label required">User Role</label>
                                {!! Form::select('user_role',$all_role, $user->roleId,['class'=>'form-control','style'=>'width:100%;','data-placeholder'=>'Choose User Role','id'=>'user_role','onChange'=>'setMerchant()']) !!}
                                @if($errors->has('user_role'))
                                    <label id="label-error" style="color: red" class="error" for="user_role">{{$errors->first('user_role')}}</label>
                                @endif
                            </div>

                            <div class="form-group col-md-4 m-b-5">
                                <label class="control-label required">Merchant</label>
                                {!! Form::select('merchant',$merchant, Input::old('merchant'),['class'=>'form-control','style'=>'width:100%;','data-placeholder'=>'Choose Merchant','id'=>'merchant']) !!}
                                @if($errors->has('merchant'))
                                    <label id="label-error" style="color: red" class="error" for="merchant">{{$errors->first('merchant')}}</label>
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
    
    $( document ).ready(function() {
        $('#merchant').prop('disabled', true);
    });

    function setMerchant(){
        var role = $("#user_role").val();
        if(role == 3){
            $('#merchant').prop('disabled', false);
        }else{
            $('#merchant').prop('disabled', true);
        }
    }
</script>

@stop