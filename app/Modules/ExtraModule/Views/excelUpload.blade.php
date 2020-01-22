@extends('layouts.master') @section('title','Product Upload')

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
        <h1>Data Upload <small>Management</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a></li>
            <li class="active">Upload EXCEL</li>
        </ol>
    </section>
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Upload Excel</h3>
                <div class="box-tools pull-right">
                    <!-- <a type="button" style="margin-right: 5px" class="btn btn-success btn-sm" id="btn-find" href="download-latest"><i class="fa fa-file-excel-o"></i> Latest Product Excel</a> -->
                    <a type="button" style="margin-right: 5px" class="btn btn-success btn-sm" id="btn-find" href="download-sample"><i class="fa fa-file-excel-o"></i> Sample Product Excel</a>
                </div>
            </div>

            <div class="box-body">
                <form role="form" action="{{url('other/excelupload')}}" class="form-validation" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label required">File</label>
                                <input type="file" class="form-control @if($errors->has('csv_file')) error @endif"  id="csv_file" name="csv_file" value="{{Input::old('csv_file')}}">
                                @if($errors->has('csv_file'))
                                    <label id="label-error" style="color: red" class="error" for="csv_file">{{$errors->first('csv_file')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <button type="submit" class="btn btn-primary pull-right">
                                <i class="fa fa-floppy-o"></i> Save
                            </button>
                        </div>
                    </div>
                </form>

                @isset($response)

                    <div class="row">
                        @if($response['error'])
                            <div class="alert alert-danger">
                                <p>{{$response['message']}}</p>
                            </div>
                        @else
                            <div class="alert alert-success">
                                <p>{{$response['message']}}</p>
                            </div>
                            @if(isset($response['data']) && !empty($response['data']))
                                <div class="table-wrapper container">
                                    <div class="row box-header with-border">
                                        <div class="col-md-12 text-left">
                                            Below given product(s) not imported. Please check the sheet and import again
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr class="table-header">
                                                <th class="text-center">Product ID</th>
                                                <th class="text-center">Reason</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($response['data'] as $key => $product)
                                                <tr>
                                                    <td>{{$key}}</td>
                                                    <td>{{implode(', ', $product)}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                @endisset

            </div> <!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->

@stop

@section('js')

    <script type="text/javascript">
        $("#permission").multiSelect();

    </script>

@stop