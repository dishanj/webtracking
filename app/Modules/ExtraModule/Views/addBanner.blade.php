@extends('layouts.master') @section('title','Web Banner Update')

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
        <h1>Web Template <small>Management</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a></li>
            <li class="active">Update Web Banner/Logo</li>
        </ol>
    </section>
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Update Web Banner/Logo</h3>
                <div class="box-tools pull-right">
                </div>
            </div>
            <div class="box-body">
                <form role="form" action="{{url('other/banners/add')}}" class="form-validation" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label class="control-label required">Description</label>
                                <input type="text" class="form-control @if($errors->has('description')) error @endif"  id="description" name="description" placeholder="Description"  value="@if(isset($currentData->description)) {{ $currentData->description }} @endif">
                                @if($errors->has('description'))
                                    <label id="label-error" style="color: red" class="error" for="description">{{$errors->first('description')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label required" style="width: 100%">Current Banner</label>
                                @if($bannerUrl != "")
                                    <img src="{{ $bannerUrl }}" style="width: 200px;height: 200px">
                                    <input type="hidden" name="available_banner" id="available_banner" value="1">
                                    <input type="hidden" name="banner_name" id="banner_name" value="{{ $currentData->bannerName }}">   
                                @else
                                    <input type="hidden" name="available_banner" id="available_banner" value="0"> 
                                    <input type="hidden" name="banner_name" id="banner_name" value="0">
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label required">Banner Image</label>
                                <input type="file" class="form-control @if($errors->has('banner_img')) error @endif"  id="banner_img" name="banner_img">
                                @if($errors->has('banner_img'))
                                    <label id="label-error" style="color: red" class="error" for="banner_img">{{$errors->first('banner_img')}}</label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label required" style="width: 100%">Current Logo</label>
                                @if($logoUrl != "")
                                    <img src="{{ $logoUrl }}" style="width: 200px;height: 200px">
                                    <input type="hidden" name="available_logo" id="available_logo" value="1">
                                    <input type="hidden" name="logo_name" id="logo_name" value="{{ $currentData->logoName }}">
                                @else
                                    <input type="hidden" name="available_logo" id="available_logo" value="0">    
                                    <input type="hidden" name="logo_name" id="logo_name" value="0">
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="control-label required">Logo Image</label>
                                <input type="file" class="form-control @if($errors->has('logo_img')) error @endif"  id="logo_img" name="logo_img">
                                @if($errors->has('logo_img'))
                                    <label id="label-error" style="color: red" class="error" for="logo_img">{{$errors->first('logo_img')}}</label>
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
            </div> <!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->

@stop

@section('js')

<script type="text/javascript">
    $( document ).ready(function() {
        // var url1 = "{{ url('uploads/product-category/') }}/16-1-Test2-v1.jpg";
        $("#banner_img").fileinput({
            uploadAsync: true,
            overwriteInitial: false,
            uploadUrl: "",
            maxFileCount:1,
            resizeImage: false,
            showUpload: false
        });

        $("#logo_img").fileinput({
            uploadAsync: true,
            overwriteInitial: false,
            uploadUrl: "",
            maxFileCount:1,
            resizeImage: false,
            showUpload: false
        });

    });
    
</script>

@stop