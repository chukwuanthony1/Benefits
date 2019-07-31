@extends('layouts.companylayout')
@section('content')
<script type="text/javascript">
    var active = parseInt('{{ $companyStaffsActive }}');
    var deactivated = parseInt('{{ $companyStaffsDeActive }}');
    var verified = parseInt('{{ $companyStaffsVerified }}');
    var UnVerified = parseInt('{{ $companyStaffsUnVerified }}');

  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Employees', 'Count'],
      ['Active Employees', active],
      ['Deactivated Employees', deactivated],
      ['Verified Employees', verified],
      ['UnVerified Employees', UnVerified]
    ]);

    var options = {
      title: 'Employee Ratio'
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
                            <span data-counter="counterup" data-value="{{$companyStaffs}}">{{$companyStaffs}}</span>
                            <small class="font-green-sharp"></small>
                        </h3>
                        <small>Registered Employees</small>
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
                            <span data-counter="counterup" data-value="{{$companyStaffsVerified}}">{{$companyStaffsVerified}}</span>
                        </h3>
                        <small>Verified Employees</small>
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
                            <span data-counter="counterup" data-value="{{$companyStaffsUnVerified}}">{{$companyStaffsUnVerified}}</span>
                        </h3>
                        <small>UnVerified Employees</small>
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
                            <span data-counter="counterup" data-value="{{$companyStaffsActive}}">{{$companyStaffsActive}}</span>
                        </h3>
                        <small>Active Employee</small>
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
                        <span class="caption-subject font-dark bold uppercase">Employee Stats</span>
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
            @if($companyStaffs < 0)
                <div class="portlet-body">
              <div class="progress-group">
                Verified
                <span class="float-right"><b>{{$companyStaffsVerified}}</b>/{{$companyStaffs}}</span>
                <div class="progress">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: {{$companyStaffsVerified/$companyStaffs * 100}}%" aria-valuemin="0" aria-valuenow="{{$companyStaffsVerified}}" aria-valuemax="{{$companyStaffs}}"></div>
                </div>
              </div>
              <hr/>
              <div class="progress-group">
                Unverified
                <span class="float-right"><b>{{$companyStaffsUnVerified}}</b>/{{$companyStaffs}}</span>
                <div class="progress">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: {{$companyStaffsUnVerified/$companyStaffs * 100}}%" aria-valuemin="0" aria-valuenow="{{$companyStaffsUnVerified}}" aria-valuemax="{{$companyStaffs}}"></div>
                </div>
              </div>
              <hr/>
                <div class="progress-group">
                Active
                    <span class="float-right"><b>{{$companyStaffsActive}}</b>/{{$companyStaffs}}</span>
                    <div class="progress">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: {{$companyStaffsActive/$companyStaffs * 100}}%" aria-valuemin="0" aria-valuenow="{{$companyStaffsActive}}" aria-valuemax="{{$companyStaffs}}"></div>
                    </div>
                  </div>
              <hr/>
              <div class="progress-group">
                Deactivated
                <span class="float-right"><b>{{$companyStaffsDeActive}}</b>/{{$companyStaffs}}</span>
                <div class="progress">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: {{$companyStaffsDeActive/$companyStaffs * 100}}%" aria-valuemin="0" aria-valuenow="{{$companyStaffsDeActive}}" aria-valuemax="{{$companyStaffs}}"></div>
                </div>
              </div>
                </div>
            @endif
          </div>
        </section>
    </div>
</div>
@endsection