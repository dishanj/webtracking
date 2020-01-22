@extends('layouts.master') @section('title','Dashboard')
<!-- Content Header (Page header) -->
@section('css')
    <style type="text/css">
        .bg-white {
            background: #fff;
        }

        .amcharts-chart-div a {
            display: none !important;
        }
    </style>
@stop


@section('content')
    <meta http-equiv="refresh" content="300">
    <section class="content-header page-title-box">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <section class="content-header">
        <h1>
            {{$merchant}}
        </h1>
    </section>

    <section class="content">
        <div class="card-box">
            <section class="content">
                <div class="box box box-primary">

                    <div class="col-sm-5 col-12  search-area pack-order-top">
                        <form role="form" method="get" id="myForm">
                            <div class="form-group">
                                <label>Customers Registered Form</label>
                                <div>
                                    <div class="input-daterange input-group"
                                         id="date-range">
                                        <input type="text" name="from_date" class="form-control"
                                               id="from_date" placeholder="From Date"
                                               value="@if(isset($date_from)) {{ $date_from }} @else {{ date('Y-m-01') }}  @endif">
                                        <input type="text" name="to_date" class="form-control" id="to_date"
                                               placeholder="To Date"
                                               value="@if(isset($date_to)) {{ $date_to }} @else {{ date('Y-m-d') }}  @endif">

                                        <button type="submit" class="btn btn-primary">Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>




                    {{--<div class="box-body col-5">--}}
                        {{--<form class="form-horizontal form-validation" role="form" method="get" id="myForm">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">--}}
                                    {{--<div class="form-group" style="margin-right:0;margin-left:0">--}}
                                        {{--<label class="control-label">Customers Registered From</label>--}}
                                        {{--<input type="text" name="from_date" class="form-control" id="from_date"--}}
                                               {{--placeholder="From Date"--}}
                                               {{--value="@if(isset($date_from)) {{ $date_from }} @else {{ date('Y-m-01') }}  @endif">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">--}}
                                    {{--<div class="form-group" style="margin-right:0;margin-left:0">--}}
                                        {{--<label class="control-label">To</label>--}}
                                        {{--<input type="text" name="to_date" class="form-control" id="to_date"--}}
                                               {{--placeholder="To Date"--}}
                                               {{--value="@if(isset($date_to)) {{ $date_to }} @else {{ date('Y-m-d') }}  @endif">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-md-12 text-right">--}}
                                    {{--<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Find--}}
                                    {{--</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                </div>



                <div class="row">
                    <section class="col-lg-12 connectedSortable tab-view-package">
                        <div class="nav-tabs-custom">

                            <!-- Tabs within a box -->
                            <ul class="nav nav-tabs pull-left">
                                <li class="active"><a href="#pending-orders" data-toggle="tab" class="order-table-tabs">Pending
                                        orders</a></li>
                                {{--<li><a href="#ready-to-collect" data-toggle="tab">Ready to collect</a></li>--}}
                                <li><a href="#cancelled-orders" data-toggle="tab">Cancelled orders</a></li>
                                {{--<li><a href="#pending-payments" data-toggle="tab">Pending payments</a></li>--}}
                                <li><a href="#products" data-toggle="tab">Products</a></li>
                            </ul>
                            <div class="tab-content no-padding">
                                <!-- Pending Orders Section -->
                                <div class="chart tab-pane active" id="pending-orders" style="position: relative;">
                                    <div class="box">
                                        <div class="box-header">
                                            <h3 class="box-title">
                                                Pending Orders
                                                <small>From: {{date('d/m/Y', strtotime($date_from))}}
                                                    To: {{date('d/m/Y', strtotime($date_to))}}</small>
                                            </h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" style="margin-right: 5px"
                                                        onclick="exportPendingOrdersExcel()" class="btn buttons-excel"
                                                        id="btn-find"><i class="fa fa-file-excel-o"></i> Excel
                                                </button>
                                            </div>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <form role="form" action="{{url('/order-status-update')}}" class="form-validation" method="post">
                                                    {{ csrf_field() }}
                                                    <table id="example1" class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th><button type="submit" class="btn-sm success">Ready to Pickup</button> </th>
                                                            <th>Order ID</th>
                                                            <th>Product</th>
                                                            <th>Brand</th>
                                                            <th>SKU</th>
                                                            <th>Qty</th>
                                                            <th>Sale Price</th>
                                                            <th>Market Price</th>
                                                            <th>Delivery Status</th>
                                                            <th>Created at</th>
                                                            <th>Last Updated at</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($pendingOrders as $order)
                                                            <tr>
                                                                <td>
                                                                    @if($order->item_delivery_status != 2)
                                                                    <input type="checkbox" name="orderItem[]" value="{{$order->item_id}}">
                                                                    @endif
                                                                </td>
                                                                <td>{{$order->order_id}}</td>
                                                                <td>{{$order->product_name}}</td>
                                                                <td>{{$order->brand_name}}</td>
                                                                <td>{{$order->merchantSku}}</td>
                                                                <td>{{$order->line_qty}}</td>
                                                                <td class="-align-right">{{number_format($order->salePrice, 2)}}</td>
                                                                <td class="-align-right">{{number_format($order->marketPrice, 2)}}</td>
                                                                <td>
                                                                    @isset($itemDeliveryStatus[$order->item_delivery_status])
                                                                    {{$itemDeliveryStatus[$order->item_delivery_status]}}
                                                                    @endisset
                                                                </td>
                                                                <td>{{date('d/m/Y h:i A', strtotime($order->createdAt))}}</td>
                                                                <td>{{date('d/m/Y h:i A', strtotime($order->updatedAt))}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 text-right">
                                                    <?php echo $pendingOrders->appends(['from_date' => $date_from, 'to_date' => $date_to])->links(); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>
                                <!-- End Pending Orders Section -->

                                <!-- Ready to collect Orders Section -->
                            {{--<div class="chart tab-pane" id="ready-to-collect" style="position: relative;">
                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title">Ready to collect Orders</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Rendering engine</th>
                                                <th>Browser</th>
                                                <th>Platform(s)</th>
                                                <th>Engine version</th>
                                                <th>CSS grade</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>Trident</td>
                                                <td>Internet
                                                    Explorer 4.0
                                                </td>
                                                <td>Win 95+</td>
                                                <td> 4</td>
                                                <td>X</td>
                                            </tr>
                                            <tr>
                                                <td>Trident</td>
                                                <td>Internet
                                                    Explorer 5.0
                                                </td>
                                                <td>Win 95+</td>
                                                <td>5</td>
                                                <td>C</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>--}}
                            <!-- End Ready to collect Orders Section -->

                                <!-- Cancelled orders Section -->
                                <div class="chart tab-pane" id="cancelled-orders" style="position: relative;">
                                    <div class="box">
                                        <div class="box-header">
                                            <h3 class="box-title">
                                                Cancelled Orders
                                                <small>From: {{date('m/d/Y', strtotime($date_from))}}
                                                    To: {{date('m/d/Y', strtotime($date_to))}}</small>
                                            </h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" style="margin-right: 5px"
                                                        onclick="exportCanceledOrdersExcel()" class="btn buttons-excel"
                                                        id="btn-find"><i class="fa fa-file-excel-o"></i> Excel
                                                </button>
                                            </div>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="table-responsive">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Product</th>
                                                    <th>Brand</th>
                                                    <th>Qty</th>
                                                    <th>Sale Price</th>
                                                    <th>Created at</th>
                                                    <th>Canceled at</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($cancelOrders as $order)
                                                    <tr>
                                                        <td>{{$order->order_id}}</td>
                                                        <td>{{$order->product_name}}</td>
                                                        <td>{{$order->brand_name}}</td>
                                                        <td>{{$order->line_qty}}</td>
                                                        <td class="-align-right">{{number_format($order->salePrice, 2)}}</td>
                                                        <td>{{date('d/m/Y h:i A', strtotime($order->createdAt))}}</td>
                                                        <td>{{date('d/m/Y h:i A', strtotime($order->canceledAt))}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <?php echo $cancelOrders->appends(['from_date' => $date_from, 'to_date' => $date_to])->links(); ?>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </div>
                                <!-- End Cancelled orders Section -->

                                <!-- Products -->
                                <div class="chart tab-pane" id="products" style="position: relative;">
                                    <div class="box">
                                        <div class="box-header">
                                            <h3 class="box-title">
                                                Products
                                            </h3>
                                            <div class="box-tools pull-right">
                                                <!--<button type="button" style="margin-right: 5px"
                                                        onclick="exportCanceledOrdersExcel()" class="btn buttons-excel"
                                                        id="btn-find"><i class="fa fa-file-excel-o"></i> Excel
                                                </button>-->
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Brand</th>
                                                        <th>Product Name</th>
                                                        <th>SKU</th>
                                                        <th>Merchant SKU</th>
                                                        <th>On-hand Count</th>
                                                        <th>Weight</th>
                                                        <th>Height</th>
                                                        <th>Width</th>
                                                        <th>Depth</th>
                                                        <th>Cost Price</th>
                                                        <th>Market Price</th>
                                                        <th>Sale Price</th>
                                                        <th>Available On</th>
                                                        <th>Discontinue On</th>
                                                        <th>Created at</th>
                                                        <th>Last Updated at</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($products as $product)
                                                        <tr>
                                                            <td>{{$product->product_id}}</td>
                                                            <td>{{$product->brand_name}}</td>
                                                            <td>{{$product->product_name}}</td>
                                                            <td>{{$product->sku}}</td>
                                                            <td>{{$product->merchantSku}}</td>
                                                            <td class="text-right">{{number_format($product->stockOnHand)}}</td>
                                                            <td class="-align-right">{{number_format($product->weight, 2)}}</td>
                                                            <td class="-align-right">{{number_format($product->height, 2)}}</td>
                                                            <td class="-align-right">{{number_format($product->width, 2)}}</td>
                                                            <td class="-align-right">{{number_format($product->depth, 2)}}</td>
                                                            <td class="-align-right">{{number_format($product->costPrice, 2)}}</td>
                                                            <td class="-align-right">{{number_format($product->marketPrice, 2)}}</td>
                                                            <td class="-align-right">{{number_format($product->salePrice, 2)}}</td>
                                                            <td>{{date('d/m/Y', strtotime($product->availableOn))}}</td>
                                                            <td>{{ ($product->discontinueOn != '0000-00-00 00:00:00')
                                                                    ? date('d/m/Y', strtotime($product->discontinueOn))
                                                                    : '--'
                                                                    }}</td>
                                                            <td>{{date('d/m/Y', strtotime($product->createdAt) )}}</td>
                                                            <td>{{date('d/m/Y', strtotime($product->updatedAt) )}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <?php echo $products->appends(['from_date' => $date_from, 'to_date' => $date_to])->links(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pending payments Section -->
                            {{--<div class="chart tab-pane" id="pending-payments" style="position: relative;">
                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title">Pending payments</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>Rendering engine</th>
                                                <th>Browser</th>
                                                <th>Platform(s)</th>
                                                <th>Engine version</th>
                                                <th>CSS grade</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>Trident</td>
                                                <td>Internet
                                                    Explorer 4.0
                                                </td>
                                                <td>Win 95+</td>
                                                <td> 4</td>
                                                <td>X</td>
                                            </tr>
                                            <tr>
                                                <td>Trident</td>
                                                <td>Internet
                                                    Explorer 5.0
                                                </td>
                                                <td>Win 95+</td>
                                                <td>5</td>
                                                <td>C</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>--}}
                            <!-- End Pending payments Section -->

                            </div>
                        </div>
                    </section>
                </div>

            </section>
        </div>
    </section>


@stop

@section('js')
    <script type="text/javascript">

        $("#from_date").datepicker({
            format: 'yyyy-mm-dd'
        });

        $("#to_date").datepicker({
            format: 'yyyy-mm-dd'
        });

        $(document).ready(function () {
            $(".order-table-tabs").click(function () {
                //alert('ok');
            });
        });

        function exportPendingOrdersExcel() {
            var from = $('#from_date').val();
            var to = $('#to_date').val();
            window.location.href = '{{url('/merchant-pending-orders-to-excel')}}?from_date=' + from + '&to_date=' + to + '';
        }

        function exportCanceledOrdersExcel() {
            var from = $('#from_date').val();
            var to = $('#to_date').val();
            window.location.href = '{{url('/merchant-canceled-orders-to-excel')}}?from_date=' + from + '&to_date=' + to + '';
        }
    </script>
@stop