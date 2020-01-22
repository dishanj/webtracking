@extends('layouts.master') @section('title','Permission List')

@section('css')
@stop

@section('content')
    <section class="content-header">
        <h1>Roles List</h1>
        <ol class="breadcrumb">
            <li><a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a></li>
            <li><a href="{{{url('roles/add')}}}">Add Roles</a></li>
            <li class="active">Roles List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-wrapper table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr class="table-header">
                                <th rowspan="2" class="text-center">ID</th>
                                <th rowspan="2" class="text-center">Name</th>
                                <th rowspan="2" class="text-center">Permission</th>
                                <th colspan="2" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=0; ?>
                            @foreach($roles as $value)
                                <tr>
                                    <td style="text-align: left">{{ $value->id }}</td>
                                    <td style="text-align: left">{{ $value->name }}</td>
                                    <td style="text-align: left;    word-break: break-word;">{{ $value->permission }}</td>
                                    <td style="text-align: center;">
                                        <a title="Edit" href="{{url('roles/edit')}}/{{ $value->id }}">
                                            <i class="fa fa-pencil"></i>
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
                            <?php echo $roles->render(); ?>
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
    // $("#permission").multiSelect();

    function changeStatus(x,id){
        var status = $('#status_'+x).is(':checked'); 
        $.ajax({
            url: "{{url('permission/changeStatus')}}",
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