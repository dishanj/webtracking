@extends('layouts.master') @section('title','Menu Insert')

@section('css')
@stop

@section('content')

    <section class="content-header">
        <h1>Add Menu</h1>
        <ol class="breadcrumb">
            <li><a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a></li>
            <li><a href="{{{url('menu/list')}}}">Menu List</a></li>
            <li class="active">Add Menu</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="container-fluid">
            <div class="">
                <div class="col-md-12">
                        <form role="form" action="{{url('menu/add')}}" class="form-horizontal" method="post">
                            {{ csrf_field() }}

                        <div class="row">
                            <div class="form-group col-md-3 m-b-5">
                                <label class="control-label required">Menu Label</label>
                                <input type="text" class="form-control @if($errors->has('labels')) error @endif"  id="labels" name="labels" placeholder="Menu Label"  value="{{Input::old('labels')}}">
                                @if($errors->has('labels'))
                                    <label id="label-error" style="color: red" class="error" for="labels">{{$errors->first('labels')}}</label>
                                @endif
                            </div>

                            <div class="form-group col-md-3 m-b-5">
                                <label class="control-label">Menu Icon</label>
                                {!! Form::select('menu_icon', $icon, Input::old('menu_icon'),['class'=>'form-control','style'=>'width:100%;font-family:\'FontAwesome\'','data-placeholder'=>'Choose Icon','id' => 'menu_icon','onchange' => 'setText();']) !!}
                                @if($errors->has('menu_icon'))
                                    <label id="label-error" style="color: red" class="error" for="label">{{$errors->first('menu_icon')}}</label>
                                @endif
                            </div>

                            <div class="form-group col-md-3 m-b-5">
                                <label class="control-label required">Menu URL</label>
                                <input type="text" class="form-control @if($errors->has('menu_url')) error @endif" name="menu_url" id="menu_url" placeholder="Ex: menu/add" value="{{Input::old('menu_url')}}">
                                @if($errors->has('menu_url'))
                                    <label id="label-error" style="color: red" class="error" for="label">{{$errors->first('menu_url')}}</label>
                                @endif
                            </div>

                            <div class="form-group col-md-3 m-b-5">
                                <label class="control-label required">Menu Parent</label>
                                {!! Form::select('parent_menu',$menus, Input::old('parent_menu'),['class'=>'form-control','style'=>'width:100%;','data-placeholder'=>'Choose Parent Menu','id'=>'parent_menu']) !!}
                            </div>
                        </div>

                            <div class="row">
                                <div class="form-group col-md-4 m-b-5">
                                    <label class="control-label required">Permissions</label>
                                    {!! Form::select('permission[]',$access, Input::old('permission'),['class'=>'form-control','style'=>'width:100%;','data-placeholder'=>'Choose Parent Menu','multiple'=>'multiple','id'=>'permission']) !!}
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

    $(function() {
        $('#permission').multiSelect({
            selectableHeader: "<input class='form-control' type='text' class='search-input' autocomplete='off'>",
            selectionHeader: "<input class='form-control' type='text' class='search-input' autocomplete='off'>",
            afterInit: function(ms){
                var that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '.ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '.ms-elem-selection.ms-selected';

                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                .on('keydown', function(e){
                    if (e.which === 40){
                        that.$selectableUl.focus();
                        return false;
                    }
                });

                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                .on('keydown', function(e){
                    if (e.which == 40){
                        that.$selectionUl.focus();
                        return false;
                    }
                });
            },
            afterSelect: function(){
                this.qs1.cache();
                this.qs2.cache();
            },
            afterDeselect: function(){
                this.qs1.cache();
                this.qs2.cache();
            }
        });

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