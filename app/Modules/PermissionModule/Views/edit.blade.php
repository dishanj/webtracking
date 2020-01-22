@extends('layouts.master') @section('title','Permission Edit')

@section('css')
<link rel="stylesheet" href="{{asset('plyr-master/dist/plyr.css')}}">
@stop

@section('content')

    <section class="content-header">
        <h1>Update Permission</h1>
        <ol class="breadcrumb">
            <li><a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a></li>
            <li><a href="{{{url('permission/list')}}}">Permission List</a></li>
            <li class="active">Update Permission</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="container-fluid">
            <div class="">
                <div class="col-md-10">
                        <form role="form" action="{{url('permission/update')}}" class="form-horizontal" method="post">
                            {{ csrf_field() }}

                        <div class="row">
                            <div class="form-group col-md-4 m-b-5">
                                <label class="control-label required">Permission</label>
                                <input type="text" value="{{ $data->name }}" class="form-control @if($errors->has('permission')) error @endif"  id="permission" name="permission" placeholder="Permission"  >
                                @if($errors->has('permission'))
                                    <label id="label-error" style="color: red" class="error" for="permission">{{$errors->first('permission')}}</label>
                                @endif
                                <input type="hidden" value="{{ $data->id}}" name="id_txt" id="id_txt">
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
    
</script>

@stop