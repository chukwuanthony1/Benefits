@extends('layouts.merchantlayout')
@section('content')
<script type="text/javascript">
    var allProducts = parseInt('{{ $allProducts }}');
    var approvedProducts = parseInt('{{ $approvedProducts }}');
    var rejectedProducts = parseInt('{{ $rejectedProducts }}');
    var pendingProducts = parseInt('{{ $pendingProducts }}');

  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Products', 'Count'],
      ['Approved Products', approvedProducts],
      ['Rejected Products', rejectedProducts],
      ['Pending Products', pendingProducts]
    ]);

    var options = {
      title: 'Products Ratio'
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
  }
</script>
<div class="page-content">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Dashboard</span>
            </li>
        </ul>
        <div class="page-toolbar">
            <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
                <i class="icon-calendar"></i>&nbsp;
                <span class="thin uppercase hidden-xs"></span>&nbsp;
                <i class="fa fa-angle-down"></i>
            </div>
        </div>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> Dashboard
        <small>dashboard & statistics</small>
    </h3>
    
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-green-sharp">
                            <span data-counter="counterup" data-value="{{$allProducts}}">{{$allProducts}}</span>
                            <small class="font-green-sharp"></small>
                        </h3>
                        <small>All Products</small>
                    </div>
                    <div class="icon">
                        <i class="icon-pie-chart"></i>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress">
                        <span style="width: 76%;" class="progress-bar progress-bar-success green-sharp">
                            <!-- <span class="sr-only">76% progress</span> -->
                        </span>
                    </div>
                    <!-- <div class="status">
                        <div class="status-title"> progress </div>
                        <div class="status-number"> 76% </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-red-haze">
                            <span data-counter="counterup" data-value="{{$approvedProducts}}">{{$approvedProducts}}</span>
                        </h3>
                        <small>Approved Employees</small>
                    </div>
                    <div class="icon">
                        <i class="icon-like"></i>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress">
                        <span style="width: 85%;" class="progress-bar progress-bar-success red-haze">
                            <!-- <span class="sr-only">85% change</span> -->
                        </span>
                    </div>
                    <div class="status">
                        <!-- <div class="status-title"> change </div>
                        <div class="status-number"> 85% </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-blue-sharp">
                            <span data-counter="counterup" data-value="{{$pendingProducts}}">{{$pendingProducts}}</span>
                        </h3>
                        <small>Pending Products</small>
                    </div>
                    <div class="icon">
                        <i class="icon-basket"></i>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress">
                        <span style="width: 85%;" class="progress-bar progress-bar-success blue-sharp">
                            <!-- <span class="sr-only">45% grow</span> -->
                        </span>
                    </div>
                    <div class="status">
                        <!-- <div class="status-title"> grow </div>
                        <div class="status-number"> 45% </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-purple-soft">
                            <span data-counter="counterup" data-value="{{$rejectedProducts}}">{{$rejectedProducts}}</span>
                        </h3>
                        <small>Rejected Products</small>
                    </div>
                    <div class="icon">
                        <i class="icon-user"></i>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress">
                        <span style="width: 87%;" class="progress-bar progress-bar-success purple-soft">
                            <!-- <span class="sr-only">56% change</span> -->
                        </span>
                    </div>
                    <div class="status">
                        <!-- <div class="status-title"> change </div>
                        <div class="status-number"> 57% </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-6">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Products Stats</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="piechart" style="width: 100%px; height: 350px;"></div> 
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">Progress Summary</span>
                </div>
            </div>
            @if($allProducts < 0)
            <div class="portlet-body">
              <div class="progress-group">
                Approved
                <span class="float-right"><b>{{$approvedProducts}}</b>/{{$allProducts}}</span>
                <div class="progress">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: {{$approvedProducts/$allProducts * 100}}%" aria-valuemin="0" aria-valuenow="{{$approvedProducts}}" aria-valuemax="{{$allProducts}}"></div>
                </div>
              </div>
              <hr/>
              <div class="progress-group">
                Pending
                <span class="float-right"><b>{{$pendingProducts}}</b>/{{$allProducts}}</span>
                <div class="progress">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: {{$pendingProducts/$allProducts * 100}}%" aria-valuemin="0" aria-valuenow="{{$pendingProducts}}" aria-valuemax="{{$allProducts}}"></div>
                </div>
              </div>
              <hr/>
                <div class="progress-group">
                    Rejected
                    <span class="float-right"><b>{{$rejectedProducts}}</b>/{{$allProducts}}</span>
                    <div class="progress">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: {{$rejectedProducts/$allProducts * 100}}%" aria-valuemin="0" aria-valuenow="{{$rejectedProducts}}" aria-valuemax="{{$allProducts}}"></div>
                    </div>
                </div>
              <hr/>
            </div>
            @endif
        </section>
    </div>
</div>
@endsection