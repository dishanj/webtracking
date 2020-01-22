@extends('layouts.master') @section('title','Add Role')

@section('css')

@stop

@section('content')

    <section class="content-header">
        <h1>Add Role</h1>
        <ol class="breadcrumb">
            <li><a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a></li>
            <li><a href="{{{url('role/list')}}}">Role List</a></li>
            <li class="active">Add Role</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="container-fluid">
            <div class="">
                <div class="col-md-10">
                        <form role="form" action="{{url('roles/add')}}" class="form-horizontal" method="post">
                            {{ csrf_field() }}

                        <div class="row">
                            <div class="form-group col-md-4 m-b-5">
                                <label class="control-label required">Role Name</label>
                                <input type="text" class="form-control @if($errors->has('role_name')) error @endif"  id="role_name" name="role_name" placeholder="Role Name"  value="{{Input::old('role_name')}}">
                                @if($errors->has('role_name'))
                                    <label id="label-error" style="color: red" class="error" for="user_name">{{$errors->first('role_name')}}</label>
                                @endif
                            </div>


                        </div>

                            <div class="row">

                                <div class="form-group col-md-4 m-b-5">
                                    <label class="control-label required">Permissions</label>
                                    {!! Form::select('permission[]',$data, Input::old('permission'),['class'=>'form-control','style'=>'width:100%;','data-placeholder'=>'Choose Menu','multiple'=>'multiple','id'=>'permission']) !!}
                                    @if($errors->has('permission'))
                                        <label id="label-error" style="color: red" class="error" for="label">{{$errors->first('permission')}}</label>
                                    @endif
                                    <a href='#' id='select-all'>Select all</a> |
                                    <a href='#' id='deselect-all'>Deselect all</a>
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
    $("#permission").multiSelect();

    $(function() {
        $('#select-all').click(function () {
            $('#role_name').multiSelect('select_all');
            return false;
        });

        $('#deselect-all').click(function () {
            $('#role_name').multiSelect('deselect_all');
            return false;
        });
    });
</script>

@stop