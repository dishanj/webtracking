@extends('layouts.master') @section('title','Menu Update')

@section('css')
@stop

@section('content')
    <section class="content-header">
        <h1>Update Menu</h1>
        <ol class="breadcrumb">
            <li><a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a></li>
            <li><a href="{{{url('menu/list')}}}">Menu List</a></li>
            <li class="active">Update Menu</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="container-fluid">
            <div class="">
                <div class="col-md-12">

                        <form role="form" action="{{url('menu/update')}}" class="form-horizontal" method="post">
                            {{ csrf_field() }}

                        <div class="row">
                            <div class="form-group col-md-3 m-b-5">
                                <label class="control-label required">Menu Label</label>
                                <input type="text" class="form-control @if($errors->has('labels')) error @endif"  id="labels" name="labels" placeholder="Menu Label"  value="{{$selected_menu->menu_name}}">
                                @if($errors->has('labels'))
                                    <label id="label-error" style="color: red" class="error" for="labels">{{$errors->first('labels')}}</label>
                                @endif
                                <input type="hidden" name="menu_id" id="menu_id" value="{{ $menu_id }}">
                            </div>

                            <div class="form-group col-md-3 m-b-5">
                                <label class="control-label">Menu Icon</label>
                                {!! Form::select('menu_icon', $all_icon,$selected_menu->icon_id,['class'=>'form-control','style'=>'width:100%;font-family:\'FontAwesome\'','data-placeholder'=>'Choose Icon','id' => 'menu_icon','onchange' => 'setText();']) !!}
                                @if($errors->has('menu_icon'))
                                    <label id="label-error" style="color: red" class="error" for="label">{{$errors->first('menu_icon')}}</label>
                                @endif
                            </div>

                            <div class="form-group col-md-3 m-b-5">
                                <label class="control-label required">Menu URL</label>
                                <input type="text" class="form-control @if($errors->has('menu_url')) error @endif" name="menu_url" id="menu_url" placeholder="Ex: menu/add" value="{{$selected_menu->url}}">
                                @if($errors->has('menu_url'))
                                    <label id="label-error" style="color: red" class="error" for="label">{{$errors->first('menu_url')}}</label>
                                @endif
                            </div>

                            <div class="form-group col-md-3 m-b-5">
                                <label class="control-label required">Menu Parent</label>
                                {!! Form::select('parent_menu',$all_menu, $selected_menu->parent_id,['class'=>'form-control','style'=>'width:100%;','data-placeholder'=>'Choose Parent Menu','id'=>'parent_menu']) !!}

                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4 m-b-5">
                                <label class="control-label required">Permissions</label>
                                {!! Form::select('permission[]',$all_role, $permission_roles,['class'=>'form-control','style'=>'width:100%;','data-placeholder'=>'Choose Parent Menu','multiple'=>'multiple','id'=>'permission']) !!}
                                @if($errors->has('permission'))
                                    <label id="label-error" style="color: red" class="error" for="label">{{$errors->first('permission')}}</label>
                                @endif
                                <a href='#' id='select-all'>Select all</a> |
                                <a href='#' id='deselect-all'>Deselect all</a>
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
    $("#permission").multiSelect();

    $(function() {
        $('#select-all').click(function () {
            $('#permission').multiSelect('select_all');
            return false;
        });

        $('#deselect-all').click(function () {
            $('#permission').multiSelect('deselect_all');
            return false;
        });
    });
</script>

@stop