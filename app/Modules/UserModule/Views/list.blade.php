@extends('layouts.master') @section('title','User List')

@section('css')
@stop

@section('content')
    <section class="content-header">
        <h1>User List</h1>
        <ol class="breadcrumb">
            <li><a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a></li>
            <li><a href="{{{url('user/add')}}}">Add User</a></li>
            <li class="active">User List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="container-fluid">

            <div class="">
                <div class="col-md-12">

                        <form role="form" action="{{url('user/list')}}" class="form-horizontal" method="get">
                        <div class="row">
                            <div class="form-group col-md-3 m-b-5">
                                <label class="control-label required">Role</label>
                                {!! Form::select('roles',$roles, Input::old('roles'),['class'=>'form-control','style'=>'width:100%;','data-placeholder'=>'Choose Roles','id'=>'roles']) !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-default btn-submit mr-2" ><i class="fa fa-search"></i> Find</button>
                        </div>
                        <div class="form-group col-md-6 m-b-5">
                        </div>

                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="table-wrapper table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr class="table-header">
                                <th rowspan="2" class="text-left">Employee</th>
                                <th rowspan="2" class="text-left">User Name</th>
                                <th rowspan="2" class="text-center">Role</th>
                                <!-- <th rowspan="2" class="text-center">Status</th> -->
                                <th colspan="2" class="text-center">Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=0; ?>
                            @foreach($user as $value)
                                <tr>
                                    <td style="text-align: left">{{ $value->name }}</td>
                                    <td style="text-align: left">{{ $value->email }}</td>
                                    <td style="text-align: left">{{ $value->role }}</td>
                                <!-- <td style="text-align: center">
                                            <input type="checkbox" id="status_<?php echo $i; ?>" name="status_<?php echo $i; ?>" onchange="changeStatus(<?php echo $i; ?>,<?php echo $value->id; ?>)" @if($value->status == 1) checked @endif data-toggle="toggle" data-on="Active" data-off="Deactive" data-size="mini" data-onstyle="success">
                                        </td> -->
                                    <td style="text-align: center;">
                                        <a title="Edit Data" href="{{url('user/edit')}}/{{ $value->id }}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </td>
                                    <td style="text-align: center;">
                                        <a title="Change Password" href="{{url('user/reset')}}/{{ $value->id }}">
                                            <i class="fa fa-unlock-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            {{ $user->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

@stop

@section('js')

<script type="text/javascript">
    $("#permission").multiSelect();

    function changeStatus(x,id){
        var status = $('#status_'+x).is(':checked'); 
        $.ajax({
            url: "{{url('user/changeStatus')}}",
            type: 'POST',
            data: {
                    "_token": "{{ csrf_token() }}",
                    "id" : id,
                    'status': status
                  },
            success: function(data) {
                var result = JSON.parse(data);
                if(result == 1){
                  swal({
                    title: 'Wel Done!',
                    text: 'Status Updated successfully',
                    icon: "success",
                  });
                }else if(result == 0){
                  swal({
                    title: 'Sorry!',
                    text: 'Permission Denied',
                    icon: "warning",
                  });
                } 
                location.reload();
            },error: function(data){
                swal({
                  title: 'Ooops!',
                  text: 'Something went wrong',
                  icon: "error",
                });
            }
        });
    }
    
</script>

@stop